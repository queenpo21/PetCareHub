<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Cart;
use App\Models\ProductSize;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function index(){
        if (auth()->check()) {
            // Nếu người dùng đã đăng nhập, lấy user_id từ user hiện tại
            $userId = auth()->id();
        } else {
            // Nếu không, lấy session_id của phiên làm việc hiện tại
            $userId = session()->getId();
        }

        $cartItems = Cart::select('carts.*', 'product.name', 'product.image', 'product_sizes.price')
        ->join('product', 'carts.product_id', '=', 'product.id')
        ->join('product_sizes', function ($join) {
            $join->on('carts.product_id', '=', 'product_sizes.product_id')
                ->whereColumn('carts.size', '=', 'product_sizes.size');
        })
        ->where('carts.user_id', $userId)
        ->orderBy('carts.id', 'desc')
        ->get();

        $prices = ProductSize::select('product_id', 'size', 'price')
        ->whereIn('product_id', $cartItems->pluck('product_id')->unique())
        ->get()
        ->groupBy(['product_id', 'size']);
    
        // dd($cartItems);
        $sizes = ProductSize::where('product_id', $cartItems->pluck('product_id')->unique()->toArray())
        ->pluck('size')->unique();
        
        // dd($prices);
        return view('pages.giohang', compact('cartItems', 'sizes', 'prices'));
    }
    public function addToCart(Request $request, $id)
    {
        $cart_action = $request->input('cart_action');
        $size = $request->input('size');
        $quantity = $request->input('quantity');
        $userId = $request->input('user_id');

        if ($cart_action === 'add_to_cart') {
            $existingCartItem = Cart::where('user_id', $userId)
            ->where('product_id', $id)
            ->where('size', $size)
            ->first();

            if ($existingCartItem) {

                $existingCartItem->num += $quantity;
                $existingCartItem->save();

            } else {
                    $cart = new Cart();
                    $cart->user_id = $userId;
                    $cart->product_id = $id;
                    $cart->size = $size;
                    $cart->num = $quantity;

                    $cart->save();
                } 
         }elseif ($cart_action === 'buy_now') {
            // Lưu thông tin đơn hàng vào session và chuyển hướng đến trang thanh toán
            $orderInfo = [
                'product_id' => $id,
                'size' => $size,
                'quantity' => $quantity,
            ];
            session()->put('order_info', $orderInfo);
            return response()->json(['success' => true]);
        }
        $cartCount = Cart::where('user_id', $userId)->count('id');
        return response()->json(['success' => true,'message' => 'Thêm sản phẩm vào giỏ hàng thành công!', 'cartCount' => $cartCount]);
    }

    public function getCartCount(Request $request){
        $userId = $request->input('user_id');
        $cartCount = Cart::where('user_id', $userId)->count('id');
        return response()->json(['cartCount' => $cartCount]);
    }

    public function updateCart(Request $request)
    {
        $cartId = $request->input('cart_id');
        $newSize = $request->input('size');
        $newQuantity = $request->input('quantity');

        // Cập nhật cart với kích thước và số lượng mới
        $cartItem = Cart::find($cartId);
        $cartItem->size = $newSize;
        $cartItem->num = $newQuantity;
        $cartItem->save();

        $newPrice = ProductSize::where('product_id', $cartItem->product_id)
                           ->where('size', $newSize)
                           ->first()
                           ->price;

        // Trả về giá dưới dạng JSON
        return response()->json(['price' => $newPrice]);
    }

    public function deleteCartItem(Request $request)
    {
        $cartItemId = $request->input('cart_item_id');

        // Xóa sản phẩm khỏi giỏ hàng
        Cart::destroy($cartItemId);

        // Trả về phản hồi thành công
        return response()->json(['success' => true]);
    }
}

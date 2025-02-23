<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\Cart;
use App\Models\OrderDetail;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Uuid;




use App\Models\ProductSize;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        // Lấy danh sách các id_cart đã chọn từ giỏ hàng
        $selectedItems = $request->input('selected_items');

        if (session()->has('cartItems')) {
            session()->forget('cartItems');
        }

        $selectedItemsArray = explode(',', $selectedItems);


        $cartItems = Cart::select('carts.*', 'product.name', 'product.image', 'product_sizes.price')
        ->join('product', 'carts.product_id', '=', 'product.id')
        ->join('product_sizes', function ($join) {
            $join->on('carts.product_id', '=', 'product_sizes.product_id')
                ->whereColumn('carts.size', '=', 'product_sizes.size');
        })
        ->whereIn('carts.id', $selectedItemsArray)
        ->orderBy('carts.id', 'desc')
        ->get();


        session()->put('cartItems', $cartItems);

        return view('pages.thanhtoan', compact('cartItems'));
    }

    public function processCheckoutBuyNow(Request $request)
    {
        // Lấy danh sách các id_cart đã chọn từ giỏ hàng
        $selectedItems = $request->input('selected_items');

        if (session()->has('cartItems')) {
            session()->forget('cartItems');
        }

        // dd($selectedItems);
        // Lấy thông tin đơn hàng từ session
        $orderInfo = session()->get('order_info');
        // dd($orderInfo);

        // Lấy thông tin sản phẩm từ đơn hàng
        $productId = $orderInfo['product_id'];
        $size = $orderInfo['size'];
        $quantity = $orderInfo['quantity'];


        $cartItems = product::select('product.id as product_id','product.name', 'product.image', 'product_sizes.price','product_sizes.size')
        ->join('product_sizes', 'product.id', '=', 'product_sizes.product_id')
        ->where('product.id', $productId)
        ->where('product_sizes.size', $size)
        ->get();

        $cartItems->map(function ($item) use ($quantity, $size) {
            $item->num = $quantity;
            $item->size = $size;
            return $item;
        });

        //     // dd($cartItems);

        session()->put('cartItems', $cartItems);
        // dd($cartItems);

        return view('pages.thanhtoan', compact('cartItems'));
    }

    public function buyNow(Request $request){

        if (auth()->check()) {
            $user_id = auth()->id();
        } else{
            $user_id = session()->getId();
        }
        
        $orderCode = substr(bin2hex(random_bytes(4)), 0, 8); //Sử dụng random_bytes để tạo chuỗi ngẫu nhiên, rồi chuyển đổi sang định dạng hexadecimal.

        $orderData = [
            'code' => $orderCode,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'note' => $request->note,
            'method_payment' => $request->method_payment,
            'total' => $request->total_price*1000,
            'user_id' => $user_id,
        ];
        
        if ($request->has('city') && $request->has('district') && $request->has('ward') && $request->has('addressDetail')) {
            $orderData['address'] = implode('.', [$request->addressDetail, $request->ward, $request->district, $request->city]);
        } else{
            $orderData['address'] = 'Cửa hàng PetCareHub';
        }

        session()->put('orderData', $orderData);

        $cartItems = session()->get('cartItems');

        return view('pages.chitietdonhang')->with(['orderData'=>$orderData, 'cartItems'=>$cartItems]);
    }
    public function confirmOrder(){

        $cartItems = session()->get('cartItems');
        $orderData = session()->get('orderData');

        $order = Order::create($orderData);

        //Dùng transaction 
        $order = DB::transaction(function () use ($orderData, $cartItems) {
            // Tạo đơn hàng
            $order = Order::create($orderData);
    
            // Lặp qua từng sản phẩm trong giỏ hàng và tạo chi tiết đơn hàng
            foreach ($cartItems as $cartItem) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'size' => $cartItem->size,
                    'num' => $cartItem->num,
                    'price' => $cartItem->price,
                ]);
    
                // Xóa sản phẩm khỏi giỏ hàng nếu cần
                Cart::where('id', $cartItem->id)->delete();
            }
    
            return $order; // Trả về đối tượng đơn hàng để tiếp tục xử lý
        });
    
        // Kiểm tra phương thức thanh toán và cập nhật trạng thái đơn hàng
        if($order->method_payment === 'Tiền mặt'){
            return Redirect::to('/cho-xac-nhan');
        } else {
            // $order->status_payment = 1;
            $order->status = "Đang giao";
            $order->save();  // Lưu lại trạng thái mới của đơn hàng
            return Redirect::to('/dang-giao');
        }
    }  
}

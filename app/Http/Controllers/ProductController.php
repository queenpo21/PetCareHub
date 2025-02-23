<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;
use App\Models\type_product;
use App\Models\Gallery;
use App\Models\ProductSize;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;

class ProductController extends Controller
{

    
    use ValidatesRequests;

    public function index()
    {
        $pro = product::all();
        $typ = type_product::all();
        return view('admin.admin_sanpham')->with('pro', $pro)->with('typ', $typ);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'pet' => 'required',
            'typeProduct_name' => 'required',
            'inventory' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $pro = new product;
        $pro->name = $request->input('name');
        $pro->pet = $request->input('pet');

        $pro->typeProduct_name = $request->input('typeProduct_name');
        $typeProduct = type_product::where('name', $request->input('typeProduct_name'))->first();
        if ($typeProduct) {
            $pro->typeProduct_id = $typeProduct->id;
        }
        $pro->inventory = $request->input('inventory');
        $pro->description = $request->input('description');

        $get_image = $request->file('image');
        $get_name_img = $get_image->getClientOriginalName();
        $name_img = current(explode('.', $get_name_img));
        $new_image = $name_img . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
        $get_image->move('public/storage/products',  $new_image);
        $pro->image = $new_image;

        $pro->save();

        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $galleryImage) {
                $get_image =  $galleryImage;
                $get_name_img = $get_image->getClientOriginalName();
                $name_img = current(explode('.', $get_name_img));
                $new_image = $name_img . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move('public/storage/gallery',  $new_image);
                Gallery::create([
                    'product_id' => $pro->id,
                    'image' => $new_image
                ]);
            }
        }

        foreach ($request->sizes as $sizeData) {
            ProductSize::create([
                'product_id' => $pro->id,
                'size' => $sizeData['size'],
                'price' => $sizeData['price'],
            ]);
        }

        $pro->calculateMinMaxPrice();

        Session::put('message', 'Thêm sản phẩm thành công!');
        return Redirect::to('/quan-ly-san-pham');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'pet' => 'required',
            'typeProduct_name' => 'required',
            'inventory' => 'required',
            'description' => 'required',
        ]);

        $pro = product::find($id);
        $pro->name = $request->input('name');
        $pro->pet = $request->input('pet');
        $pro->typeProduct_name = $request->input('typeProduct_name');
        $typeProduct = type_product::where('name', $request->input('typeProduct_name'))->first();
        if ($typeProduct) {
            $pro->typeProduct_id = $typeProduct->id;
        }
        $pro->size = $request->input('size');
        $pro->inventory = $request->input('inventory');
        $pro->description = $request->input('description');

        $pro->save();

        ProductSize::where('product_id', $pro->id)->delete();

        foreach ($request->sizesEdit as $sizeData) {
            ProductSize::create([
                'product_id' => $pro->id,
                'size' => $sizeData['size'],
                'price' => $sizeData['price'],
            ]);
        }

        $pro->calculateMinMaxPrice();

        Session::put('message', 'Chỉnh sửa sản phẩm thành công!');
        return Redirect::to('/quan-ly-san-pham');
    }

    public function destroy($id)
    {
        $pro = product::find($id);
        $pro->delete();

        Session::put('message', 'Đã xóa sản phẩm!');
        return Redirect::to('/quan-ly-san-pham');
    }
    public function getProduct($id)
    {
        $pro = product::find($id);
        $sizes = ProductSize::where('product_id', $id)->get(['size', 'price']);

        return response()->json([
            'success' => true,
            'product' => $pro,
            'sizes' => $sizes
        ]);
    }

    public function updateNewStatus($id, Request $request)
    {
        $pro = product::find($id);
        $pro->new = $request->new;
        $pro->save();
        return response()->json(['message' => 'Cập nhật trạng thái mới thành công.']);
    }

    public function updateBestSellerStatus($id, Request $request)
    {
        $pro = product::find($id);
        $pro->bestseller = $request->bestseller;
        $pro->save();
        return response()->json(['message' => 'Cập nhật trạng thái mới thành công.']);
    }

    public function updateImage(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $product = Product::find($request->id);

        if ($product) {
            // Xóa ảnh cũ
            if ($product->image) {
                Storage::delete('public/storage/products/' . $product->image);
            }

            // Lưu ảnh mới
            if ($request->hasFile('image')) {
                $get_image = $request->file('image');
                $get_name_img = $get_image->getClientOriginalName();
                $name_img = current(explode('.', $get_name_img));
                $new_image = $name_img . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
                $get_image->move('public/storage/products',  $new_image);
                $product->image = $new_image;
                $product->save();
            }

            return response()->json(['new_image' => $new_image]);
        } else {
            return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
        }
    }

    //Page KH
    public function showByPetandCateId($pet, $cate_id)
    {

        if ($pet == 'dog') $pet = 'Chó';
        else $pet = 'Mèo';
        $pro = DB::table('product')
            ->join('typeProduct', 'product.typeProduct_id', '=', 'typeProduct.id')
            ->select('Product.*')
            ->where('typeProduct.category_id', '=', $cate_id)
            ->where('pet', '=', $pet)
            ->get();
        $types = DB::table('typeProduct')
            ->select('typeProduct.*')
            ->where('category_id', '=', $cate_id)
            ->get();
        return view('pages.sanpham', ['pro' => $pro, 'types' => $types, 'cate_id' => $cate_id, 'pet' => $pet]);
    }
    public function allProduct($cate_id){
        $pro = DB::table('product')
            ->join('typeProduct', 'product.typeProduct_id', '=', 'typeProduct.id')
            ->select('Product.*')
            ->where('typeProduct.category_id', '=', $cate_id)
            ->get();
        $types = DB::table('typeProduct')
            ->select('typeProduct.*')
            ->where('category_id', '=', $cate_id)
            ->get();
        return view('pages.sanpham', ['pro' => $pro, 'types' => $types, 'cate_id' => $cate_id]);
    }

    public function filterProduct(Request $request, $cate_id)
    {
        $filterData = [
            'typeProduct' => $request->input('typeProduct', []),
            'pett' => $request->input('pett', []),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'sap_xep' => $request->input('sap_xep')
        ];

        session()->put('filterData', $filterData);

        $pro = DB::table('product')
            ->join('typeProduct', 'product.typeProduct_id', '=', 'typeProduct.id')
            ->select('product.*')
            ->where('typeProduct.category_id', '=', $cate_id);

        if ($request->has('typeProduct')) {
            $typeProductIds = $request->input('typeProduct');
            $pro->whereIn('typeProduct.id', $typeProductIds);
        }

        // Lọc sản phẩm theo loại pet. 
        if ($request->has('pett')) {
            $petTypes = $request->input('pett');
            $pro->whereIn('product.pet', $petTypes);
        }

        // Lọc theo giá min và max
        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = (float) $request->input('min_price');
            $maxPrice = (float) $request->input('max_price');
            $pro->whereBetween('min_price', [$minPrice, $maxPrice]);
        } elseif ($request->has('min_price')) {
            // Chỉ lọc theo giá min
            $minPrice = (float) $request->input('min_price');
            $pro->where('min_price', '>=', $minPrice);
        } elseif ($request->has('max_price')) {
            // Chỉ lọc theo giá max
            $maxPrice = (float) $request->input('max_price');
            $pro->where('min_price', '<=', $maxPrice);
        }


        $sortOption = $request->input('sap_xep');

        switch ($sortOption) {
            case 'A đến Z':
                $pro->orderBy('product.name', 'asc');
                break;
            case 'Z đến A':
                $pro->orderBy('product.name', 'desc');
                break;
            case 'Giảm dần':
                $pro->orderBy('product.max_price', 'desc');
                break;
            case 'Tăng dần':
                $pro->orderBy('product.min_price', 'asc');
                break;
            default:
                break;
        }

        $pro = $pro->get();
        // dd($pro);

        $types = DB::table('typeProduct')
            ->select('typeProduct.*')
            ->where('category_id', '=', $cate_id)
            ->get();

        return view('pages.sanpham', ['pro' => $pro, 'cate_id' => $cate_id, 'types' => $types])->with('filterData', $filterData);;
    }
    public function detailProduct($id)
    {
        $pro = product::find($id);
        // Lấy danh mục của sản phẩm
        $typeProductId = $pro->typeProduct_id;

        // Lấy category_id từ bảng typeProduct
        $typeProduct = DB::table('typeProduct')->where('id', $typeProductId)->first();

        $categoryId = $typeProduct->category_id;

        // Lấy các sản phẩm cùng danh mục (ngoại trừ sản phẩm hiện tại)
        $relatedProducts = DB::table('product')
            ->join('typeProduct', 'product.typeProduct_id', '=', 'typeProduct.id')
            ->where('typeProduct.category_id', $categoryId)
            ->where('product.id', '!=', $id)
            ->select('product.*')
            ->take(4)
            ->get();
        // dd($pro);
        $sizes = ProductSize::where('product_id', $id)->get(['id', 'size', 'price']);

        $numRating = OrderDetail::calculateNumRating($id);

        $feedback = OrderDetail::where('product_id', $id)
        ->join('orders', 'orderDetail.order_id', '=', 'orders.id')
        ->orderBy('rating', 'desc')
        ->take(5)
        ->get(['orderDetail.size', 'orderDetail.num', 'orderDetail.rating', 'orderDetail.feedback', 'orders.name']);

        return view('pages.chitietsp', [
            'pro' => $pro, 
            'relatedProducts' => $relatedProducts, 
            'sizes' => $sizes,
            'numRating' => $numRating,
            'feedback' => $feedback,
        ]);
    }

}

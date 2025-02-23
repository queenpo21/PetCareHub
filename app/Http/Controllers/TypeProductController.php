<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\type_product;
use App\Models\category;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;

class TypeProductController extends Controller
{
    use ValidatesRequests;

    public function index()
    {
        $cate = category::all();
        $typ = type_product::all();
        return view('admin.admin_loaisp')->with('typ', $typ)->with('cate', $cate);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
        ]);
        $typ = new type_product;
        $typ->name = $request->input('name');
        $typ->category_name = $request->input('category');
        $category = Category::where('name', $request->input('category'))->first();
        if ($category) {
            $typ->category_id = $category->id;
        }
        $typ->save();
        Session::put('message', 'Thêm loại sản phẩm thành công!');
        return Redirect::to('/loai-san-pham');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
        ]);
        $typ = type_product::find($id);
        $typ->name = $request->input('name');
        $typ->category_name = $request->input('category');
        $category = Category::where('name', $request->input('category'))->first();
        if ($category) {
            $typ->category_id = $category->id;
        }
        $typ->save();
        Session::put('message', 'Chỉnh sửa loại sản phẩm thành công!');
        return Redirect::to('/loai-san-pham');
    }

    public function destroy($id)
    {
        $typ = type_product::find($id);
        $typ->delete();

        Session::put('message', 'Đã xóa loại sản phẩm!');
        return Redirect::to('/loai-san-pham');
    }
}

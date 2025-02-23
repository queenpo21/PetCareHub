<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\category;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;

session_start();
class CategoryProductController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        $cate = category::all();
        return view('admin.admin_danhmucsp')->with('cate', $cate);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $cate = new category;
        $cate->name = $request->input('name');
       
        $cate->save();
        Session::put('message', 'Thêm danh mục thành công!');
        return Redirect::to('/danh-muc-san-pham');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $cate = category::find($id);
        $cate->name = $request->input('name');
       
        $cate->save();
        Session::put('message', 'Chỉnh sửa danh mục thành công!');
        return Redirect::to('/danh-muc-san-pham');
    }

    public function destroy($id)
    {
        $emps = category::find($id);
        $emps->delete();

        Session::put('message', 'Đã xóa danh mục!');
        return Redirect::to('/danh-muc-san-pham');
    }
    //Hết admin
    public function lay_danh_muc(){
        $cate = category::all();
        return response()->json(['cate' => $cate]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\users;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;

class QLNVController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        $emps = users::where('role', '!=', 'customer')->get();
        return view('admin.admin_quanlynhanvien')->with('emps', $emps);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'date_join' => 'required',
        ]);
        $emps = new users;
        $emps->name = $request->input('name');
        $emps->email = $request->input('email');
        $emps->phone = $request->input('phone');
        $emps->role = $request->input('role');
        $emps->date_join = $request->input('date_join');
        $emps->save();
        Session::put('message', 'Thêm nhân viên thành công!');
        return Redirect::to('/quan-ly-nhan-vien');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'role' => 'required',
            'date_join' => 'required',
        ]);
        $emps = users::find($id);
        $emps->name = $request->input('name');
        $emps->email = $request->input('email');
        $emps->phone = $request->input('phone');
        $emps->role = $request->input('role');
        $emps->date_join = $request->input('date_join');
        $emps->save();
        Session::put('message', 'Chỉnh sửa nhân viên thành công!');
        return Redirect::to('/quan-ly-nhan-vien');
    }

    public function destroy($id)
    {
        $emps = users::find($id);
        $emps->delete();

        Session::put('message', 'Đã xóa nhân viên!');
        return Redirect::to('/quan-ly-nhan-vien');
    }
}

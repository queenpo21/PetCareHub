<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\customer;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;

class CustomerController extends Controller
{
    use ValidatesRequests;
    public function index()
    {
        $cus = customer::all();
        return view('admin.admin_quanlykhachhang')->with('cus', $cus);
    }
    

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $cus = customer::find($id);
        $cus->name = $request->input('name');
        $cus->email = $request->input('email');
        $cus->phone = $request->input('phone');

        $cus->save();
        Session::put('message', 'Chỉnh sửa khách hàng thành công!');
        return Redirect::to('/quan-ly-khach-hang');
    }

    public function destroy($id)
    {
        $cus = customer::find($id);
        $cus->delete();

        Session::put('message', 'Đã xóa khách hàng!');
        return Redirect::to('/quan-ly-khach-hang');
    }
}

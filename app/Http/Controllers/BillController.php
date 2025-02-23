<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillController extends Controller
{
    use ValidatesRequests;
    public function index(){
        $adminController = new AdminController();
        $check = $adminController->checkadmin();
        if(!$check) {
            return redirect('/admin-login');
        }
        $emps = bill::where('status', 'đã giao')->get();
        return view('admin.admin_quanlyhoadon')->with('emps', $emps);
    }
    public function destroy($id)
    {
        $adminController = new AdminController();
        $check = $adminController->checkadmin();
        if(!$check) {
            return redirect('/admin-login');
         }
        $emps = bill::find($id);
        $emps->delete();

        Session::put('message', 'Đã xóa hóa đơn!');
        return Redirect::to('/quan-ly-hoa-don');
    }
    public function show($id)
    {
       
        // $order = DB::table('orders')
        //     ->join('orderdetail', 'orderdetail.order_id', '=', 'order.id')
        //     ->join('product', 'product.id', '=', 'orderdetail.product_id')
        //     ->join('typeproduct','typeproduct.id','=','product.typeProduct_id')
        //     ->where('orders.id', '=', $id)
        //     ->select( 'orders.total as total','orders.ship_cost as ship_cost','orderdetail.num as num'
        //     , 'product.name as product_name','product.price','typeproduct.name as typeproduct_name'
        //     ,'orders.name as kh_name','orders.id as id','orders.status as status','orders.updated_at as updated_at'
        //     ,'orders.address as address')
        //     ->get();
        // return response()->json($order);
        $order = DB::table('orders')
        ->join('orderdetail', 'orderdetail.order_id', '=', 'orders.id')
        ->join('product', 'product.id', '=', 'orderdetail.product_id')
        ->join('typeproduct','typeproduct.id','=','product.typeProduct_id')
        ->join('product_sizes','product_sizes.product_id','=','product.id')
        ->where('orders.id', '=', $id)
        ->whereColumn('product.size', 'product_sizes.size')
        ->select( 'orders.total as total','orders.shipcost as ship_cost','orderdetail.num as num'
        , 'product.name as product_name','product_sizes.price as price' ,'typeproduct.name as typeproduct_name'
        ,'orders.name as kh_name','orders.id as id','orders.status as status','orders.updated_at as updated_at'
        ,'orders.address as address')
            ->get();
            return response()->json($order);
    }
    
}

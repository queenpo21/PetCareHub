<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\order;
use App\Models\orderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    use ValidatesRequests;
    public function index(){
        $adminController = new AdminController();
        $check = $adminController->checkadmin();
        if(!$check) {
           return redirect('/admin-login');
        }
        $emps = Order::get();
        return view('admin.admin_quanlydonhang')->with('emps', $emps);
    }
    public function destroy($id)
    {
        $adminController = new AdminController();
        $check = $adminController->checkadmin();
        if(!$check) {
            return redirect('/admin-login');
         }
        $emps = Order::find($id);
        $emps->delete();

        Session::put('message', 'Đã xóa đơn hàng!');
        return Redirect::to('/quan-ly-don-hang');
    }
    public function show($id)
{
   
    // $order = DB::table('orders')
    //     ->join('orderdetail', 'orderdetail.order_id', '=', 'orders.id')
    //     ->join('product', 'product.id', '=', 'orderdetail.product_id')
    //     ->join('typeproduct','typeproduct.id','=','product.typeProduct_id')
    //     ->join('product_sizes','product_sizes.product_id','=','product.id')
    //     ->where('orders.id', '=', $id)
    //     ->whereColumn('product.size', 'product_sizes.size')
    //     ->select( 'orders.total as total','orders.shipcost as ship_cost','orderdetail.num as num'
    //     , 'product.name as product_name','product_sizes.price as price' ,'typeproduct.name as typeproduct_name'
    //     ,'orders.name as kh_name','orders.id as id','orders.status as status','orders.created_at as created_at')
    //     ->get();
    // return response()->json($order);
    try {
        $order = DB::table('orders')
        ->join('orderdetail', 'orderdetail.order_id', '=', 'orders.id')
        ->join('product', 'product.id', '=', 'orderdetail.product_id')
        ->join('typeproduct','typeproduct.id','=','product.typeProduct_id')
        ->join('product_sizes','product_sizes.product_id','=','product.id')
        ->where('orders.id', '=', $id)
        ->whereColumn('product.size', 'product_sizes.size')
        ->select( 'orders.total as total','orders.shipcost as ship_cost','orderdetail.num as num'
        , 'product.name as product_name','product_sizes.price as price' ,'typeproduct.name as typeproduct_name'
        ,'orders.name as kh_name','orders.id as id','orders.status as status','orders.created_at as created_at')
            ->get();
        return response()->json($order);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
    // {
    //     $order = DB::table('order')
    //         ->join('users', 'users.id', '=', 'order.user_id')
    //         ->join('product', 'products.id', '=', 'order.product_id')
    //         ->where('order.id', '=', $id)
    //         ->select('order.*', 'users.name as user_name', 'product.name as product_name')
    //         ->first();

    //     return response()->json($order);
    // }

    
    public function orderDetail(){
        return view('pages.chitietdonhang');
    }

    public function cancelOrder(Request $request, $code)
    {

        $order = Order::find('order_code', $code);

        $order->status = 'Đã hủy';
        $order->cancelllation_reason = $request->reason; 
        $order->save();

        Session::put('message', 'Hủy đơn hàng thành công!');
        return Redirect::to('/cho-xac-nhan');
    }

    public function detail($id){
        $total = DB::table('orders')
                ->select('total')
                ->where('id', $id)
                ->first();
        // dd($total);
        $details = DB::table('orderDetail')
            ->join('product', 'orderDetail.product_id', '=', 'product.id') // Join bảng product
            ->select('orderDetail.*', 'product.image', 'product.name') // Chọn các cột cần lấy
            ->where('order_id', $id)
            ->get();

        return view('pages.chitietdonhanggd', ['total' => $total, 'details' => $details]);
    }

    public function confirmOrder(Request $request)
    {
        $orderId = $request->orderId;

        // Thực hiện xác nhận đơn hàng
        $order = Order::findOrFail($orderId);
        $order->status = 'Đang giao'; 
        $order->save();

        // Phản hồi JSON về client (nếu cần)
        return response()->json(['message' => 'Xác nhận đơn hàng thành công']);
    }

    public function cancel(Request $request)
    {
        // Lấy id của đơn hàng từ request
        $orderId = $request->orderId;

        // Thực hiện hủy đơn hàng
        $order = Order::findOrFail($orderId);
        $order->status = 'Đã hủy'; // Đặt trạng thái là "Đã hủy"
        $order->save();

        // Xóa đơn hàng khỏi cơ sở dữ liệu (nếu cần)
        $order->delete();

        // Phản hồi JSON về client (nếu cần)
        return response()->json(['message' => 'Hủy đơn hàng thành công']);
    }
    public function UpdateStatus( Request $request)
    {
        Log::info('Request data:', $request->all());
        $id = $request->input('id');
        $status = $request->input('status');
         $order = Order::find($id);
         $order->status = $status;
         $order->save();
         
    }
    
}


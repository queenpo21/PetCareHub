<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\order;
use App\Models\orderDetail;
use Illuminate\Support\Facades\session;
use Illuminate\Support\Facades\Redirect;


class HistoryController extends Controller
{
    public function handleRequest(Request $request)
    {
        if ($request->isMethod('get')) {
            return $this->choXacNhan($request);
        } elseif ($request->isMethod('post')) {
            return $this->cancel($request);
        }
    }
    public function choXacNhan(Request $request){
        if (auth()->check()) {
            // Nếu người dùng đã đăng nhập, lấy user_id từ user hiện tại
            $userId = auth()->id();
        } else {
            // Nếu không, lấy session_id của phiên làm việc hiện tại
            $userId = session()->getId();
        }

        $order= Order::where('status','Chờ xác nhận')->where('user_id', $userId)
        ->orderBy('created_at','desc')->get();

        return view('pages.lichsugiaodichxacnhan', ['order' => $order]);
    }

    public function daGiao(){
        if (auth()->check()) {
            // Nếu người dùng đã đăng nhập, lấy user_id từ user hiện tại
            $userId = auth()->id();
        } else {
            // Nếu không, lấy session_id của phiên làm việc hiện tại
            $userId = session()->getId();
        }

        $order= Order::where('status','Đã giao ')->where('user_id', $userId)
        ->orderBy('created_at','desc')->get();
        return view('pages.lichsugiaodichxacnhan', ['order' => $order]);
    }

    public function dangGiao(){
        if (auth()->check()) {
            // Nếu người dùng đã đăng nhập, lấy user_id từ user hiện tại
            $userId = auth()->id();
        } else {
            // Nếu không, lấy session_id của phiên làm việc hiện tại
            $userId = session()->getId();
        }

        $order= Order::where('status','Đang giao')
        ->where('user_id', $userId)
        ->orderBy('created_at','desc')->get();
        return view('pages.lichsugiaodichxacnhan', ['order' => $order]);
    }

    public function daHuy(){
        if (auth()->check()) {
            // Nếu người dùng đã đăng nhập, lấy user_id từ user hiện tại
            $userId = auth()->id();
        } else {
            // Nếu không, lấy session_id của phiên làm việc hiện tại
            $userId = session()->getId();
        }
        $order= Order::where('status','Đã hủy')->where('user_id', $userId)
        ->orderBy('updated_at','desc')->get();
        return view('pages.lichsugiaodichxacnhan', ['order' => $order]);
    }

    public function cancel(Request $request)
    {

        // $cancellation = $request->input('reason');
        $cancellation = $request->input('cancellation');
        $orderCode = $request->input('code');

        try {
            $order = Order::where('code', $orderCode)->first();
            if($order){
                $order->status = 'Đã hủy';
                $order->cancelllation_reason = $cancellation;
                $order->save();
            }
            

            return response()->json(['message' => 'Đã cập nhật trạng thái hủy đơn hàng thành công.', 'redirect_url' => '/DoAn_PetcareHub/da-huy']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Đã xảy ra lỗi. Vui lòng thử lại.'], 500);
        }
    }

}

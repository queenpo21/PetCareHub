<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\console;
use Illuminate\Support\Facades\Log;


class AdminController extends Controller
{
    public function checkadmin(){
    
        $admin = Auth::user();
        if($admin){
            return true;
        }
        return false;
    }

    public function trangchu(){
        if(!$this->checkadmin()) {
            return redirect('/admin-login');
        }
        // $totalRevenue = $this->getTotalRevenue();
        // $totalBills = $this->countTotalBills();
        // $newCustomersCount = $this->countNewCustomersInCurrentMonth(); 
        return view('admin.admin_home'
        // , [
        //     'totalRevenue' => $totalRevenue,
        //     'totalBills' => $totalBills,
        //     'newCustomersCount' => $newCustomersCount
        // ]
        );
    }


    //  private function getTotalRevenue()
    // {
    //     // Sử dụng query builder để gọi function
    //     $result = DB::select("SELECT GetTotalRevenue() AS totalRevenue ");

    //     // Trích xuất kết quả từ kết quả truy vấn
    //     $totalRevenue = $result[0]->totalRevenue;

    //     return $totalRevenue;
    // }

    // private function countTotalBills()
    // {
    //     // Sử dụng query builder để gọi function
    //     $result = DB::select("SELECT CountTotalBills() AS totalBills");

    //     // Trích xuất kết quả từ kết quả truy vấn
    //     $totalBills = $result[0]->totalBills;

    //     return $totalBills;
    // }
    // private function countNewCustomersInCurrentMonth()
    // {
    //     // Sử dụng query builder để gọi function
    //     $result = DB::select("SELECT CountNewCustomersInCurrentMonth() AS newCustomersCount");

    //     // Trích xuất kết quả từ kết quả truy vấn
    //     $newCustomersCount = $result[0]->newCustomersCount;

    //     return $newCustomersCount;
    // } 

   

    public function Login(){
        return view('admin.admin_login');
    }

    public function AuthLogin(Request $request){
        $admin_email = $request->email;
        $admin_password = $request->password;
      if (empty($admin_email) || empty($admin_password)) {
        return back()->withErrors([
            'email' => 'Vui lòng nhập đầy đủ thông tin.',
        ]);
        }

        // Tìm admin với email tương ứng
        $admin = Admin::where('email', $admin_email)->first();
    
        // Nếu không tìm thấy admin hoặc mật khẩu không đúng
        if (!$admin || $admin_password != $admin->password) {
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng.',
            ]);
        }
    
        // Nếu admin không có quyền admin
        if ($admin->role == 'Customer') {
           return back()->withErrors([
                'email' => 'Tài khoản này không có quyền admin.',
            ]);
        }
    
        // Đăng nhập và chuyển hướng đến trang admin
        Auth::login($admin);
        $request->session()->put('admin', $admin);
        return redirect('/admin');
    }

    public function logout(){
        Auth::logout();
        return redirect('/admin-login');
    }
    public function ThongKe($date){
        Log::info('ThongKe function was called with date: ' . $date);
        if(!$this->checkadmin()) {
            return redirect('/admin-login');
        }
        
        $date = $date;
        $count = DB::table('orders')
            ->where('orders.created_at', 'like', '%'.$date.'%')
            ->count();
        $total = DB::table('orders')
          
            ->where('orders.created_at', 'like', '%'.$date.'%')
            ->where('orders.status', '=', 'Đã giao')
            ->sum('orders.total');
        $user= DB::table('users')
            ->where('date_join', 'like', '%'.$date.'%')
        ->count(); 
        $response = [
            'count' => $count,
            'total' => $total,
            'user' => $user,
        ];
        
        return response()->json($response);
    }
    public function ThongKeDH($startOfWeek, $endOfWeek){
       


        $endOfWeek = \Carbon\Carbon::parse($endOfWeek)->addDay();
        Log::info('ThongKeDH function was called with startOfWeek: ' . $startOfWeek . ' and endOfWeek: ' . $endOfWeek);
        if(!$this->checkadmin()) {
            return redirect('/admin-login');
        }
        
       
        $orderofweek = DB::table('orders')
                    ->select(DB::raw('DATE(orders.created_at) as date'), DB::raw('count(*) as count'))
                    ->whereBetween('orders.created_at', [$startOfWeek, $endOfWeek])
                    ->groupBy(DB::raw('DATE(orders.created_at)'))
                    ->get(); 
    


        $response = [
            'orderofweek' => $orderofweek,
            // 'total' => $total,
            // 'user' => $user,
        ];
        
        return response()->json($response);


    // }
}
public function ThongKeDT($startOfWeek, $endOfWeek){
        
    Log::info('ThongKeDT function was called with startOfWeek: ' . $startOfWeek . ' and endOfWeek: ' . $endOfWeek);
    if(!$this->checkadmin()) {
        return redirect('/admin-login');
    }
    
    $endOfWeek = \Carbon\Carbon::parse($endOfWeek)->addDay();
                
     $totalPerDay = DB::table('orders')
                 ->select(DB::raw('DATE(orders.created_at) as date'), DB::raw('SUM(orders.total) as total'))
                 ->whereBetween('orders.created_at', [$startOfWeek, $endOfWeek])
                 ->where('orders.status', '=', 'Đã giao')
                 ->groupBy('date')
                 ->get();
                
    $response = [
        'totalPerDay' => $totalPerDay,
        // 'total' => $total,
        // 'user' => $user,
    ];
    
    return response()->json($response);


// }
}
public function Top(Request $request){
    if(!$this->checkadmin()) {
        return redirect('/admin-login');
    }

    // Ghi lại dữ liệu yêu cầu vào nhật ký
    Log::info('Dữ liệu yêu cầu: ', $request->all());

    $month = $request->input('month');
    $month = $request->input('month');
    if (!$month) {
        return response()->json(['error' => 'Tháng không hợp lệ'], 400);
    }

    // Tách năm và tháng từ chuỗi month
    $year = substr($month, 0, 4);
    $monthOnly = substr($month, 5, 2);
    // Đảm bảo $month là giá trị hợp lệ
    if(!$month) {
        Log::error('Tháng không hợp lệ hoặc bị thiếu');
        return response()->json(['error' => 'Tháng không hợp lệ'], 400);
    }

    $top = DB::table('orderdetail')
    ->join('product', 'product.id', '=', 'orderdetail.product_id')
    ->join('orders', 'orders.id', '=', 'orderdetail.order_id')
    ->select('product.name as product_name', DB::raw('SUM(orderdetail.num) as total'))
    ->whereYear('orders.created_at', $year)
     ->whereMonth('orders.created_at', $monthOnly)
    ->groupBy('product.name')
    ->orderBy('total', 'desc')
    ->limit(5)
    ->get();
    return response()->json($top);
}
}

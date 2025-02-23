<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\customer;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function  ForgetPassword()
    {
       return view('pages.forgetpass');
    }
   
    public function checkCustomer() {
        if (session('isLoggedIn')) {
           return true;
        } else {
            return false;
        }
    }
    public function index(){

        $first = Product::where('bestseller', '1')->first();
        $second = Product::where('new', 1)->first();
        if ($first) {
            $topSales = Product::where('bestseller', '1')
                ->where('id', '!=', $first->id)->get();
        } else {
            $topSales = Product::where('bestseller', '1');
        }
        
        if ($second) {
            $newProducts = Product::where('new', 1)
                ->where('id', '!=', $second->id)->get();
        } else {
            $newProducts = Product::where('new', 1)->get();
        }
        return view('pages.home',compact('topSales', 'newProducts', 'first', 'second'));
    }
    public function Profile(){
        if(!$this->checkCustomer()) {
            return redirect('/login');
        }
        return view('pages.profile');
    }
    public function Account(){
     
        return view('pages.account');
    }
    public function Login(){
        return view('pages.login');
    }
    public function Logout(Request $request){
        $request->session()->forget('isLoggedIn');
        return redirect('/trang-chu');
    }
     public function Signin(){
        
        return view('pages.signin');
    }
        public function Register(Request $request){
       
        $customer = new customer;
        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->date_join = \Carbon\Carbon::now(); // Laravel's Carbon
        $customer->email = $request->email;
        $customer->password = $request->password;
        $customer->role = 'customer';
        // var_dump($customer->name, $customer->phone, $customer->date_join, $customer->email, $customer->password, $customer->role);
        // die();
        if (empty($customer->email) || empty($customer->password)|| empty($customer->name)|| empty($customer->phone)){
            return back()->withErrors([
                'password' => 'Vui lòng nhập đầy đủ thông tin.',
            ]);
        }
        if (!filter_var($customer->email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors([
                'email' => 'Email không hợp lệ.',
            ]);
        }
        if (customer::where('email', $customer->email)->exists()) {
            return back()->withErrors([
                'email' => 'Email đã tồn tại.',
            ]);
        }
        
        if (strlen($customer->phone) < 10 || strlen($customer->phone) > 11) {
            return back()->withErrors([
                'phone' => 'Số điện thoại không hợp lệ',
            ]);
        }
        $customer->save();
        
        return redirect('/login');
    }
    public function AuthLogin(Request $request){
        $customer_email = $request->email;
        $customer_password = $request->password;
        if (empty($customer_email) || empty($customer_password)) {
            return back()->withErrors([
                'email' => 'Vui lòng nhập đầy đủ thông tin.',
            ]);
        }
        // Tìm customer với email tương ứng
        $customer = customer::where('email', $customer_email)->first();
        // Nếu không tìm thấy customer hoặc mật khẩu không đúng
        if (!$customer || $customer_password != $customer->password) {
            return back()->withErrors([
                'email' => 'Email hoặc mật khẩu không đúng.',
            ]);
        }
        // Đăng nhập và chuyển hướng đến trang account
        // Auth::login($customer);
        // $request->session()->put('customer', $customer);
        $request->session()->put('customer', $customer);
        $request->session()->put('isLoggedIn', true);
        $request->session()->put('userId', $customer->id);
        return redirect('/trang-chu');
    }
    public function ChangeInfor(Request $request){
        $customer = customer::find($request->session()->get('userId'));
        if ($request->has('name')) {
            $customer->name = $request->name;
        }
        if ($request->has('tel')) {
            $customer->phone = $request->tel;
        }
        if ($request->has('email')) {
            $customer->email = $request->email;
        }
        if ($request->has('date')) {
            $customer->date_of_birth = $request->date;
        }
        $customer->save();
        return redirect('/account');
    }
    public function GetPass(Request $request){
        $email = $request->email;
        $request->session()->put('email', $email);
        if(empty($email)){
            return back()->withErrors([
                'email' => 'Vui lòng nhập email.',
            ]);
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors([
                'email' => 'Email không hợp lệ.',
            ]);
        }
        if (!customer::where('email', $email)->exists()) {
            return back()->withErrors([
                'email' => 'Email không tồn tại.',
            ]);
        }
        $random_number = rand(100000, 999999);
      
        $request->session()->put('random_number', $random_number);
        $data = [
            'title' => 'Forget Password',
            'body'  => 'This is your code:',
            'random_number' => $random_number,
        ];
    
        Mail::send('emails.reset_password', $data, function($message) use ($email) {
            $message->to($email)
                    ->subject('Reset Password')
                    ->from('PetcareHub@gmail.com', 'Petcare Hub');
        });
        // if (count(Mail::failures()) > 0) {
        //     // handle failed emails
        //     return response()->json(['message' => 'Mail Sent Fail'], 500);
        // } else {
        //     return response()->json(['message' => 'Mail Sent Successfully'], 200);
        // }
        return redirect('/entercode');
    }
    public function EnterCode(){
        return view('pages.entercode');
    }
    public function CheckCode(Request $request){
        // dd($request->session()->get('random_number'));
        $code = $request->code;
        // dd($code);
        if (empty($code)) {
            return back()->withErrors([
                'code' => 'Vui lòng nhập mã xác nhận.',
            ]);
        }
        if ($code != $request->session()->get('random_number')) {
            return back()->withErrors([
                'code' => 'Mã xác nhận không đúng.',
            ]);
        }
        return redirect('/resetpass');
    }
    public function ResetPass(){
        return view('pages.newpass');
    }
    public function NewPass(Request $request){
        $password = $request->password;
        $repassword = $request->repassword;
        if (empty($password) || empty($repassword)) {
            return back()->withErrors([
                'repassword' => 'Vui lòng nhập đủ thông in.',
            ]);
        }
        if ($password != $repassword) {
            return back()->withErrors([
                'repassword' => 'Mật khẩu không khớp.',
            ]);
        }
        $customer = customer::where('email', $request->session()->get('email'))->first();
        $customer->password = $password;
        $customer->save();
        return redirect('/login');
    }
    public function Security(){
        return view('pages.changepass');
    }
    public function Address(){
        return view('pages.address');
    }
    public function EditProfile(){
        return view('pages.editprofile');
    }
    public function ChangePass(Request $request)
    {
        $customer = customer::find($request->session()->get('userId'));
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $re_password = $request->re_password;
        if (empty($old_password) || empty($new_password) || empty($re_password)) {
            return back()->withErrors([
                're_password' => 'Vui lòng nhập đủ thông tin.',
            ]);
        }
       
        if ($old_password != $customer->password) {
            return back()->withErrors([
                'old_password' => 'Mật khẩu cũ không đúng.',
            ]);
        }
        if ($new_password != $re_password) {
            return back()->withErrors([
                're_password' => 'Mật khẩu mới không khớp.',
            ]);
        }
        if($old_password == $new_password){
            return back()->withErrors([
                're_password' => 'Mật khẩu mới không được trùng với mật khẩu cũ.',
            ]);
        }
        $customer->password = $new_password;
        $customer->save();
        return redirect('/profile');

    }
}


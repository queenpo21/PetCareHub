@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/styleSignin.css')}}">
<div class="container">
    <div id="frame">
        <form action="{{ url('/resetpass') }}" method="POST">
            @csrf
            <h2>ĐẶT LẠI MẬT KHẨU CHO TÀI KHOẢN</h2><br>
            <p>Nhập mật khẩu mới</p>
            <div class="sty-pass">
                <p>Nhập mật khẩu mới</p>
                <input type="password" name="password" id="new-password" >
                @if ($errors->has('password'))
                <span class="text-danger">{{ $errors->first('password') }}</span>
                 @endif
            </div>
            <div class="sty-pass">
                <p>Xác nhận mật khẩu</p>
                <input type="text" name="repassword" id="confirm-password" >
                @if ($errors->has('repassword'))
                <span class="text-danger">{{ $errors->first('repassword') }}</span>
                 @endif
            </div>     
                <input type="submit" id="complete" value="Hoàn thành">
            </div>
        </form>
    </div>
</div>
@endsection
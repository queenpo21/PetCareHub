@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/styleSignin.css')}}">
<div class="container">
    <div id="frame">
        <form action="{{ url('/checkcode') }}" method="POST">
            @csrf
            <h2>QUÊN MẬT KHẨU</h2><br>
            <h5>Mã xác nhận</h5>
            <br>
            <input type="text" id="code" name="code" placeholder="Mã xác nhận">
            @if ($errors->has('code'))
            <span class="text-danger">{{ $errors->first('code') }}</span>
             @endif
            <div id="sub">
                <input type="submit"  id="send-code" value="Gửi">
               
                <a href="{{ url('/forget') }}"><input type="button" id="cancel" value="Hủy"></a>
            </div>
        </form>
    </div>
</div>
    
            
@endsection
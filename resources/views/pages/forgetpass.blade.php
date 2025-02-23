@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/styleSignin.css')}}">
    <div id="frame">
        <form action="{{ url('/getpass') }}" method="POST">
            @csrf
            <h2>QUÊN MẬT KHẨU</h2>
            <p>(Chúng tôi sẽ gửi mã qua email cho bạn để đặt lại mật khẩu)</p>
            <h5>Email</h5>
            <br>
            <input type="email" name="email" id="email-cus" placeholder="Vui lòng nhập email của bạn">
            @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
             @endif
            <div id="sub">
                <input type="submit" id="send-code" value="Gửi">
                <a href="{{ url('/login') }}"><input type="button" id="cancel" value="Hủy"></a>
            </div>
        </form>
    </div>
@endsection
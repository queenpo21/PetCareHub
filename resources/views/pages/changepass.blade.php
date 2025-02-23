@extends('layout')
@section('content')
        <link rel="stylesheet" href="{{asset('public/frontend/css/styleAccount.css')}}">

    <body>
        
        <div class="container">
            <form action={{URL::to('/change-pass')}} method="POST">
                @csrf
                <div id="profile">
                    <div id="profile-head">
                        <h4>ĐẶT LẠI MẬT KHẨU CHO TÀI KHOẢN</h4>
                        <p>Nhập mật khẩu mới</p>
                    </div>
                    <div id="profile-detail">
                        <div id="change-password">
                            <table>
                                <tr>
                                    <td><h5>Nhập mật khẩu cũ </h5></td>
                                    <td><input name="old_password" type="password" id="old-password"></td>
                                </tr>
                                <tr>
                                    <td><h5>Nhập mật khẩu mới </h5></td>
                                    <td><input type="password" name="new_password" id="new-password"></td>
                                </tr>
                                <tr>
                                    <td><h5>Xác nhận mật khẩu mới </h5></td>
                                    <td><input type="password" name="re_password" id="confirm-password"></td>
                                   
                                </tr>
                            </table>
                            @if ($errors->has('old_password'))
                                    <span class="text-danger">{{ $errors->first('old_password') }}</span>
                             @endif
                            @if ($errors->has('re_password'))
                            <span class="text-danger">{{ $errors->first('re_password') }}</span>
                             @endif
                             @if ($errors->has('old_password'))
                             <span class="text-danger">{{ $errors->first('old_password') }}</span>
                              @endif
                            <div id="forgot-password">
                                <a href="{{ url('/forget') }}">Quên mật khẩu</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="edit-complete">
                    <a href="{{ url('/profile') }}">Hủy</a>
                    <input type="submit" id="complete" name="submit" value="Đặt lại mật khẩu">
                </div>
            </form>
        </div>
    </body>
</html>
@endsection
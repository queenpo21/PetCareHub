@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/styleAccount.css')}}">
<form action="">
    <div id="profile">
        <div id="profile-head">
            <h4>Thông tin cá nhân</h4>
        </div>
        <div id="profile-detail">
            <div class="sty-profile">
                <h5>Họ và Tên khách hàng</h5>
                <input type="button" id="name" name="name" value="Nguyễn Văn A">
                <h5>Email</h5>
                <input type="button" id="emailc" name="emailc" value="abc@gmail.com">
            </div>
            <div class="sty-profile">
                <h5>Ngày Sinh</h5>
                <input type="button" id="date-birth" name="date-birth" value="">
                <h5>Số điện thoại</h5>
                <input type="button" id="tel" name="tel" value="09875453">
            </div>
        </div>
    </div>
    <div style="width: 15vw;margin: auto;">
        <input type="submit" id="submit" name="submit" value="Chỉnh sửa thông tin">
    </div>
</form>
@endsection
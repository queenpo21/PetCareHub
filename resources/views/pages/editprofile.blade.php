@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/styleAccount.css')}}">
<div class="container">
    <form action="{{URL::to('/change-infor')}}" method="POST">
        @csrf
        <div id="profile">
            <div id="profile-head">
                <h4>Thông tin cá nhân</h4>
            </div>
            <div id="profile-detail">
                @php
    $user = \App\Models\Customer::find(session('userId'));
@endphp
<div class="sty-profile">
    <h5>Họ và Tên khách hàng</h5>
    <input type="text" id="name" name="name" value="{{ $user ? $user->name : '' }}">
    <h5>Email</h5>
    <input type="text" id="emailc" name="email" value="{{ $user ? $user->email : '' }}">
</div>
<div class="sty-profile">
    <h5>Ngày Sinh</h5>
    <input type="date" id="date-birth" name="date" value="{{ $user ? $user->date_of_birth : '' }}">
    <h5>Số điện thoại</h5>
    <input type="text" id="tel" name="tel" value="{{ $user ? $user->phone : '' }}">
</div>
            </div>
        </div>
        <div id="edit-complete">
            <a href="{{ url('/profile') }}">Hủy</a>
            <input type="submit" id="complete" name="submit" value="Lưu">
        </div>
    </form>
</div>
@endsection
@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/styleAccount.css')}}">
<div class="container">
    <form action="{{URL::to('/edit-profile')}}" method="GET">
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
    <input type="text" id="date-birth" name="date" value="{{ $user ? $user->date_of_birth : '' }}">
    <h5>Số điện thoại</h5>
    <input type="text" id="tel" name="tel" value="{{ $user ? $user->phone : '' }}">
</div>
            </div>
        </div>
        <div  id="edit-complete">
            <a href="{{ url('/profile') }}">Hủy</a>
            <input type="submit" id="submit" name="submit" value="Chỉnh sửa thông tin">
        
        </div>
    </form>
</div>
    <script>
        function ggmap() {
            document.getElementById('map').innerHTML = `<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.231240417278!2d106.80047381139414!3d10.870008889239834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527587e9ad5bf%3A0xafa66f9c8be3c91!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgVGjDtG5nIHRpbiAtIMSQSFFHIFRQLkhDTQ!5e0!3m2!1svi!2s!4v1715785879974!5m2!1svi!2s" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`
        }
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#itemslider').carousel({ interval: 3000 });
            $('.carousel-showmanymoveone .item').each(function () {
                var itemToClone = $(this);
                for (var i = 1; i < 4; i++) {
                    itemToClone = itemToClone.next();

                    if (!itemToClone.length) {
                        itemToClone = $(this).siblings(':first');
                    }
                    itemToClone.children(':first-child').clone()
                        .addClass("cloneditem-" + (i))
                        .appendTo($(this));
                }
            });
        });
    </script>
@endsection
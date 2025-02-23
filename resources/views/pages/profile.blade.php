@extends('layout')
@section('content')
        <link rel="stylesheet" href="{{asset('public/frontend/css/styleAccount.css')}}">

    <body>
        
        <div class="container">
            <div id="greeting">
                <h4>Xin Chào</h4>
                {{-- <h4 id="name-customer">Nguyễn Văn A</h4> --}}
                @if(session('isLoggedIn'))
                @php
                    $user = \App\Models\Customer::find(session('userId'));
                @endphp
                <h4 id="name-customer">{{ $user ? $user->name : '' }}</h4>
            @else
                <h4 id="name-customer"></h4>
            @endif
            </div>
            <div id="detail-account">
                <a href="{{URL::to('/account')}}">Thông tin cá nhân</a>
                <hr>
                <a href="{{URL::to('/security')}}">Tài khoản & Bảo mật</a>
                <hr>
                <a href="{{URL::to('/cho-xac-nhan')}}">Lịch sử mua hàng</a>
                <hr>
            </div>
            <div id="btn-signout">
                <form action="{{URL::to('/logout')}}" method="GET">
                    <input type="submit" id="sign-out" name="sign-out" value="Đăng xuất">
                </form>
            </div>
        </div>
    </body>
</html>
 <script>
    window.addEventListener('DOMContentLoaded', () => {
        const updateCartCount = () => {
            fetch('{{ route("cartCount") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('cartCount').innerText = data.cartCount;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        };

        updateCartCount();
    });
 </script>
@endsection
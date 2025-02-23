@extends('layout')
@section('content')
        <link rel="stylesheet" href="{{asset('public/frontend/css/SigninAdmin.css')}}">

    <body>
        
        <div id="container">
            <div id="title-header">
                <a href="{{URL::to('/admin-login')}}" class="set-active">Đăng Nhập</a>
            {{-- <a href="{{URL::to('/admin-signin')}}" class="set-active">Đăng Kí</a> --}}
            </div>
            <hr
                style="
                    width: 35%;
                    border: 1px solid rgb(0, 0, 0);
                    margin: auto;
                    margin-top: 1vw;
                    opacity: 1;
                "
            />
            <div id="infor-customer">
                <form action="{{ url('/admin-login') }}" method="POST">
                    @csrf
                    <p>Email</p>
                    <input
                        type="email"
                        name="email"
                        id="email-customer"
                        placeholder="Hãy nhập địa chỉ email tài khoản của bạn"
                    /><br />
                    <p>Mật Khẩu</p>
                    <input
                    name="password"
                        type="password"
                        id="password-customer"
                        placeholder="Hãy nhập mật khẩu của bạn"
                    />
                    @if ($errors->any())
                    <div class="alert alert-danger" style=" height: 30px;
                    display: flex;
                    align-items: center;
                    margin-top:10px
                    ">
                        <ul style=" margin-top:10px">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                  
                    <input
                        type="submit"
                        name="submit"
                        id="submitt" 
                        value="Đăng Nhập"
                        style="
                        width: max-content;
                        text-align: center;
                        padding: 0.2em 1em;
                        background-color: var(--Primary-Color-Dark-Blue, #003459);
                        color: #ffffff;
                        font-size: 1.3em;
                        font-weight: 700;
                        border-radius: 25px;
                        margin: auto;
                        margin-top: 2vw;
                        display: flex;">
                    />
                </form>
            </div>
        </div>
    </body>
</html>
@endsection
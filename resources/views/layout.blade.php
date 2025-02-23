<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{asset('public/frontend/library/font-awesome/fontawesome-free-6.5.2-web/css/all.css')}}">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.css">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/js/bootstrap.js">
    <link href='https://fonts.googleapis.com/css?family=Inter' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet"
        id="bootstrap-css">
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="{{asset('public/frontend/css/styleHome.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    nav li.active a{
    text-decoration-line: underline;
    }
    ::selection {
    background-color: yellow;
    }
</style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="header">
        <div class="logo">
            <a href=""><img src={{('public/frontend/image/logo.png')}} alt="logo"></a>
        </div>
        <form>
            <div id="search-container">
                <button type="submit" id="submitSearch"><i class="bi bi-search" id="isearch"></i></button>
                <input type="search" name="search" id="input_search" placeholder="Search...">
            </div>
        </form>
        <div id="infor">
            <div id="phone">
                <p id="sty_phone">Phone</p>
              
                    <p id="phone_number">19006068</p>
             
            </div>
            <div id="email">
                <p id="sty_email">Email</p>
              
                    <p id="email_addr">petcarehub@gmail.com</p>
                
            </div>
        </div>
    </div>
    <div class="menu" style="display: flex;justify-content: space-between;">
        <nav class="navbar navbar-expand-lg navbar-light" style="margin-bottom: 0;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{URL::to('/trang-chu')}}">Trang chủ</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{URL::to('/san-pham-abc')}}" id="navbarDropdown"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sản Phẩm
                        </a>
                        @include('category')
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="{{URL::to('/dich-vu')}}" id="navbarDropdownMenuLink"
                            role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Dịch vụ
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="{{URL::to('/dich-vu-spa')}}" style="padding: 0;">Dịch vụ
                                    Spa</a></li>
                            <li><a class="dropdown-item" href="{{URL::to('/dich-vu-khach-san')}}"
                                    style="padding: 0;">Dịch vụ khách sạn</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{URL::to('/gioi-thieu')}}">Giới thiệu</a>
                    </li>
                </ul>
                </li>
                </ul>
            </div>
        </nav>
        <div id="sty-user" style="flex-grow: 1;">
            <li>
            <a href="{{URL::to('/profile')}}" id="account" class="fas fa-user fa-2x"
                 style="color: #003459;padding: 2vw;"></a>
                <a href="{{URL::to("/gio-hang")}}" id="cart" class="bi bi-cart4  fa-2x" style="color: #003459;">
                    <span id="cartCount"></span>
                </a>

            </li>
        </div>
    </div>
    <div class="container" >

        @yield('content')
    </div>
    <div id="footer">
        <div id="footer-body">
            <div id="infor-shop">
                <h3>Liên hệ</h3>
                <p>
                    CỬA HÀNG SẢN PHẨM VÀ DỊCH VỤ THÚ CƯNG PET CARE HUB.
                </p>
                <p>
                    Địa chỉ: Đường Hàn Thuyên, khu phố 6 P, Thủ Đức, Thành phố Hồ Chí Minh, Việt Nam.
                </p>
                <a href="#hotline"><i class="fas fa-phone-alt"></i>Hotline: 19006068</a><br>
                <a href="#shop_email"><i class="bi bi-envelope-fill"></i>Email: petcarehub@gmail.com</a>
                <div id="connect_shop">
                    <a href="#tiktok"><i class="fa-brands fa-tiktok"></i></a>
                    <a href="#facebook" id="facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#youtube" id="youtube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div id="policy">
                <h3>Chính sách khách hàng</h3>
                <a href="{{URL::to('/chinh-sach-doi-tra')}}">Chính sách đổi trả.</a><br>
                <a href="{{URL::to('/chinh-sach-bao-mat')}}">Chính sách bảo mật.</a><br>
                <a href="{{URL::to('/phuong-thuc-thanh-toan')}}">Phương thức thanh toán.</a><br>
                <a href="{{URL::to('/chinh-sach-hoan-tien')}}">Chính sách hoàn tiền</a><br>
                <p>&nbsp;</p>
            </div>   
        </div>
                <div class="logo"><img src="{{('public/frontend/image/logo.png')}}" alt="logo"></div>
    </div>
    <script>
        let items1 = document.querySelectorAll('#productCarousel1 .carousel-item')

        items1.forEach((el) => {
            const minPerSlide = 4
            let next = el.nextElementSibling
            for (var i = 1; i < minPerSlide; i++) {
                if (!next) {
                    next = items1[0]
                }
                let cloneChild = next.cloneNode(true)
                el.appendChild(cloneChild.children[0])
                next = next.nextElementSibling
            }
        })
        let items2 = document.querySelectorAll('#productCarousel2 .carousel-item')

        items2.forEach((el) => {
            const minPerSlide = 4
            let next = el.nextElementSibling
            for (var i = 1; i < minPerSlide; i++) {
                if (!next) {
                    next = items2[0]
                }
                let cloneChild = next.cloneNode(true)
                el.appendChild(cloneChild.children[0])
                next = next.nextElementSibling
            }
        })
        let items3 = document.querySelectorAll('#productCarousel3 .carousel-item')

        items3.forEach((el) => {
            const minPerSlide = 4
            let next = el.nextElementSibling
            for (var i = 1; i < minPerSlide; i++) {
                if (!next) {
                    next = items3[0]
                }
                let cloneChild = next.cloneNode(true)
                el.appendChild(cloneChild.children[0])
                next = next.nextElementSibling
            }
        })
        function convertToK(number) {
                if (number == 1000000) {
                    return (number / 1000000).toFixed(0) + "M";
                }if (number > 1000000) {
                    return (number / 1000000).toFixed(1) + "M";
                } else if (number == 1000) {
                    return (number / 1000).toFixed(0) + "K";
                } else if (number > 1000) {
                    return (number / 1000).toFixed(1) + "K";
                } else {
                    return number.toString();
                }
            }
            const elements = document.getElementsByClassName('number-of-sales');
            for (let i = 0; i < elements.length; i++) {
                const originalValue = parseInt(elements[i].textContent);
                const convertedValue = convertToK(originalValue); 
                elements[i].textContent = convertedValue;
            }
            const currentUrl = window.location.href;
            // Lấy danh sách các menu
            const menuItems = document.querySelectorAll('.nav-item a');

            // Kiểm tra và thêm lớp "active" cho menu đang được truy cập
            menuItems.forEach(item => {
                if (item.href === currentUrl) {
                    item.parentElement.classList.add('active');
                }
    });

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

    $(document).ready(function(){
            $("#submit").click(function(){
                event.preventDefault(); 
                var searchTerm = $("#input_search").val().toLowerCase();

                var searchPopup = window.find(searchTerm);

                // Nếu không tìm thấy từ khóa, hiển thị thông báo
                if (!searchPopup) {
                    alert("Không tìm thấy từ khóa: " + searchTerm);
                }
            });
        });
    </script>
</body>
</html>
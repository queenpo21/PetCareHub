@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/styleAccount.css')}}">

<div id="title">
    <h4>LỊCH SỬ MUA HÀNG</h4>
</div>
<div id="detail-purchase">
    <div id="menu-purchase">
    <ul>
        <li class="menuItem"><a href="{{URL::to('/da-giao')}}">Đã giao</a></li>
        <li class="menuItem"><a href="{{URL::to('/cho-xac-nhan')}}">Chờ xác nhận</a></li>
        <li class="menuItem"><a href="{{URL::to('/dang-giao')}}">Đang giao</a></li>
        <li class="menuItem"><a href="{{URL::to('/da-huy')}}">Đã hủy</a></li>
    </ul>
    </div>
    <div id="products" style="margin: 0 auto">
        <h2 class="title">Sản phẩm</h2>
        @foreach($details as $detail)
        <div class="product" style="display: flex;">
            <div class="img-pro">
                <img src="public/storage/products/{{$detail->image}}" alt="" class="img-product">
            </div>
            <div class="detail-product">
                <div class="text-truncate-container">
                    <p>{{$detail->name}}</p>
                </div>
                <div style="display: flex;">
                    <p>Phân loại:</p>
                    <p class="classify" style="margin-left:5px ;">{{$detail->size}}</p>
                </div>
                <div style="display: flex;">
                    <p>SL:</p>
                    <p class="quantity" style="margin-left:5px ;">{{$detail->num}}</p>
                </div>
            </div>
            <div class="pro-price">{{ number_format($detail->num * $detail->price, 0, '.','.') }}</div>
        </div>
        <hr style="border: 1px solid #656565;width: 90%;margin: auto;margin-bottom: 1vw;">
        @endforeach
        
        <div style="margin: 5vw 2vw;margin-top: 2vw; color: #003459;">
            <div style="display: flex;">
                <h5 style="width: 75%;">Số lượng</h5>
                <h5 id="quantity" style="text-align: end;width:25%;"></h5>
            </div>
            <div style="display: flex;">
                <h5 style="width: 75%;">Phí vận chuyển</h5>
                <h5 id="transport-fee" style="text-align: end;width:25%;">{{ number_format(30000,0,'.','.') }}</h5>
            </div>
            <div style="display: flex;">
                <h3 style="width: 75%;">Tổng tiền</h3>
                <h3 id="total-products" style="text-align: end;width:25%;">{{ number_format($total->total,0,'.','.') }}</h3>
            </div>
        </div>
    </div>
<script>
    const currentUrl = window.location.href;
    const menuItems = document.querySelectorAll('.menuItem a');
    menuItems.forEach(item => {
        if (item.href === currentUrl) {
            item.parentElement.classList.add('active');
        }
    });    
    document.addEventListener('DOMContentLoaded', function() {

    var selectedCount = {{ $details->count() }};
    document.getElementById('quantity').innerText = selectedCount;

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


</script>
@endsection
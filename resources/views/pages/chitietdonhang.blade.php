@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/styleAccount.css')}}">

<div id="title">
    <h4>Chi tiết đơn hàng</h4>
</div>
<div class="orders">
    <div id="infor"></div>

        <div id="detail-order">
        <div style="display: flex;">
            <p><strong>Khách hàng: </strong> </p>
            <p id="name">{{$orderData['name']}}</p>
        </div>
        <div style="display: flex;">
            <p><strong>Số điện thoại: </strong> </p>
            <p id="tel">{{$orderData['phone']}}</p>
        </div>
        <div style="display: flex;">
            <p><strong>Mã đơn hàng:</strong>  </p>
            <p id="id-order">{{$orderData['code']}}</p>
        </div>
        <div style="display: flex;">
            <p><strong>Giao hàng:</strong>  </p>
            <p id="address">{{$orderData['address']}}</p>
        </div>
        @if ($orderData['address'] == 'Cửa hàng PetCareHub')
            <div style="background-color:rgb(252, 241, 230); padding: 2vw; border-radius: 10px">
            <b> Đường Hàn Thuyên, khu phố 6 P, Thủ Đức, Thành phố Hồ Chí Minh</b> 
            </div>
        @endif
        <div style="display: flex; margin-top: 1vw"> 
            <p><strong>Phương thức thanh toán:</strong>  </p>
            <p id="method">{{$orderData['method_payment']}}</p>
            
        </div>
        <br>
        <!-- @if ($orderData['method_payment'] == 'Thanh toán online')
            <a href="{{ URL::to('/quet-ma') }}">
                <button type="button" name="complete" id="complete" value="Thanh toán">Xác nhận</button>
            </a>
        @elseif ($orderData['method_payment'] == 'Tiền mặt')
            <a href="{{ URL::to('/xac-nhan') }}">
                <button type="button" name="complete" id="complete" value="Thanh toán">Xác nhận</button>
            </a>
        @endif -->
        
        <button type="button" name="complete" id="complete" value="Thanh toán">Xác nhận</button>
        <div id="qrCheckOut" style = "padding-left: 50px; display: none">
            <hr>
            <div id="countdown">Mã sẽ hết hiệu lực sau: <span id="timer"></span></div>
            <img id = "img_qr" src="https://img.vietqr.io/image/970415-113366668888-qr_only.png" alt="" style ="width: 300px;
                padding-bottom: 30px; padding-top: 10px;}">
            <p>Chủ tài khoản: NGUYỄN THỊ MỸ DUNG</p>
            <P>Ngân hàng: VietCombank</P>
            <p>Nội dung chuyển khoản: <span id = "paid_content"></span></p>
            <p>Số tiền: <span id = "paid_price"></span></p>
        </div>
    </div>
    <div id="products">
        <h2 class="title">Sản phẩm</h2>
        @foreach($cartItems as $cart)
        <div class="product" style="display: flex;">
            <div class="img-pro">
                <img src="public/storage/products/{{$cart->image}}" alt="" class="img-product">
            </div>
            <div class="detail-product">
                <div class="text-truncate-container">
                    <p>{{$cart->name}}</p>
                </div>
                <div style="display: flex;">
                    <p>Phân loại:</p>
                    <p class="classify" style="margin-left:5px ;">{{$cart->size}}</p>
                </div>
                <div style="display: flex;">
                    <p>SL:</p>
                    <p class="quantity" style="margin-left:5px ;">{{$cart->num}}</p>
                </div>
            </div>
            <div class="pro-price">{{ number_format($cart->price*$cart->num, 0, '.','.') }}</div>
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
                <h3 id="total-products" style="text-align: end;width:25%;">{{ number_format($orderData['total'],0,'.','.') }}</h3>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.3/xlsx.full.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        //Số lượng
        var selectedCount = {{ $cartItems->count() }};
        document.getElementById('quantity').innerText = selectedCount;

    });

    //Thông Tin TK Ngân Hàng
    let MY_BANK ={
        BANK_ID: "Vietcombank",
        ACCOUNT_NO: "1026363484"
    }

    // Giới hạn hiệu lực mã trong vòng 3p
    let timeLeft = 3 * 60;

    function startCountdown() {
        const timerElement = document.getElementById("timer");

        const countdown = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            timerElement.innerHTML = `${minutes}:${seconds < 10 ? "0" + seconds : seconds}`;
            timeLeft--;

            if (timeLeft < 0) {
                clearInterval(countdown);
                timerElement.innerHTML = "Mã đã hết hiệu lực";

                // Hiển thị thông báo và buộc người dùng quay lại
                setTimeout(() => {
                    alert("Mã đã hết hiệu lực. Vui lòng quay lại trang trước.");
                    window.history.back(); 
                }, 500); 
            }
        }, 1000);
    }
    // Lấy dữ liệu đơn hàng từ Controller 
    var orderData = @json($orderData); // Chuyển dữ liệu PHP sang JSON

    // Lắng nghe sự kiện nút 'Xác nhận' được click
    document.getElementById('complete').addEventListener('click', function() {

        //Nếu phương thức thanh toán là 'Tiền mặt' thì đưa đơn hàng vào trạng thái chờ xác nhận
        if (orderData.method_payment === 'Tiền mặt') {
            window.location.href = "{{ url('/xac-nhan') }}";
        } 
        // Nếu ngược lại thì ẩn nút xác nhận, hiện phần thanh toán
        else {                
            document.getElementById("complete").style.display= "none";
            document.getElementById("qrCheckOut").style.display= "block";

            //Lấy ra các phần tử trong html
            const paid_content = document.getElementById("paid_content");
            const paid_price = document.getElementById("paid_price");
            const img_qr = document.getElementById("img_qr");

            //Bật đếm ngược 3 phút
            startCountdown();

            //Truyền Thông tin thanh toán vào mã QR
            let QR = `https://img.vietqr.io/image/${MY_BANK.BANK_ID}-${MY_BANK.ACCOUNT_NO}-qr_only.png?amount=${orderData.total}&addInfo=${orderData.code}`;

            //Gán các giá trị để hiển thị lên màn hình
            paid_content.innerHTML = orderData.code;    //Nội dung thanh toán là Mã Đơn Hàng
            paid_price.innerHTML = orderData.total;     //Giá đơn hàng
            img_qr.src = QR;                            //Mã QR đc gắn thông tin
        }
    });

</script>
@endsection
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
    <div class="detai-order">
        <div id="web">
            <table id="myTable" style="width:100%">
                <thead id="thead">
                    <tr>
                        <th style="width: 20%;">Mã đơn hàng</th>
                        <th style="width: 10%;">Ngày đặt</th>
                        <th style="width: 20%;">Nhận hàng</th>
                        <th style="width: 10%;">Tổng</th>
                        <th style="width: 5%;">Chi tiết</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="width: 20%;">Mã đơn hàng</th>
                        <th style="width: 10%;">Ngày đặt</th>
                        <th style="width: 20%;">Nhận hàng</th>
                        <th style="width: 10%;">Tổng</th>
                        <th style="width: 5%;">Chi tiết</th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach($order as $orderData)
                <tr>
                    <td class="id-order">{{$orderData->code}}</td>
                    <td class="date">{{$orderData->created_at->format('H:i:s d/m/Y')}}</td>
                    <td class="address">{{$orderData->address}}</td>
                    <td class="total">{{$orderData->total}}</td>
                    <td>
                    <div id="btn-detail">
                        @if($orderData->status === "Chờ xác nhận")
                        <button type="button" class="btn btn-primary delete" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" style="background-color: rgb(255, 0, 0);color: white;">
                                        <i class="bi bi-x-circle"></i>
                        </button>
                        @endif
    
                        <a href="{{URL::to('/don-hang-'. $orderData->id)}}"><button type="button" class="btn btn-primary detail" data-bs-toggle="modal"
                                        style="background-color: #1eff00;">
                                        <i class="bi bi-pencil-square"></i>
                        </button></a>

                        @if($orderData->status === "Đã giao")
                        <button type="button" class="btn btn-primary vote" data-bs-toggle="modal"
                                        data-bs-target="#voteModal" style="background-color: yellow; color: black">Đánh giá
                        </button>
                        @endif
                    </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        @foreach($order as $orderData)
        <div id="mobile">
            <table>
                <tr>
                    <th>Mã đơn hàng</th>
                    <td class="id-order">{{$orderData->code}}</td>
                </tr>
                <tr>
                    <th >Ngày đặt</th>
                    <td class="date">{{$orderData->created_at->format('H:i:s d/m/Y') }}</td>
                </tr>
                <tr>
                    <th>Nhận hàng</th>
                    <td class="address">{{$orderData->address}}</td>
                </tr>
                <tr>
                    <th>Tổng</th>
                    <td class="total">{{$orderData->total}}</td>
                </tr>
                <tr>
                    <th>Chi tiết</th>
                    <td><div id="btn-detail">
                        @if($orderData->status === "Chờ xác nhận")
                        <button type="button" class="btn btn-primary delete" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal" style="background-color: rgb(255, 0, 0);color: white;"
                                        data-code="{{$orderData->code}}">
                                        <i class="bi bi-x-circle"></i>
                        </button>
                        @endif
                        <a href="{{URL::to('/don-hang-'. $orderData->id)}}"><button type="button" class="btn btn-primary detail" data-bs-toggle="modal"
                                        data-bs-target="#detailModal" style="background-color: #1eff00;">
                                        <i class="bi bi-pencil-square"></i>
                        </button></a>
                    </div>
                    </td>
                </tr>
            </table>
        </div>
        @endforeach
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(148, 148, 148, 0.326);">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Hủy đơn hàng</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Lý do hủy đơn</h4>
                    <form action="" method="POST" id="deleteForm">
                        {{csrf_field()}}
                        {{ method_field('POST')}}
                        <input type="hidden" name="code" id="order_code" value="">
                        <input type="text" name="reason" id="reason">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                  <button type="submit" class="btn btn-primary" id="submit">Xác nhận</button>
                </form>
                </div>
              </div>
            </div>
        </div>

        <!-- form đánh giá -->
        <div class="modal fade" id="voteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" style="background-color: rgba(148, 148, 148, 0.326);">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Đánh giá đơn hàng</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4></h4>
                    <form action="" method="POST" id="deleteForm">
                        {{csrf_field()}}
                        {{ method_field('POST')}}
                        <input type="hidden" name="code" id="order_code" value="">
                        <input type="text" name="reason" id="reason">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                  <button type="submit" class="btn btn-primary" id="submit">Xác nhận</button>
                </form>
                </div>
              </div>
            </div>
        </div>
        
    </div>  
</div>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script>
    const currentUrl = window.location.href;
    const menuItems = document.querySelectorAll('.menuItem a');
    menuItems.forEach(item => {
        if (item.href === currentUrl) {
            item.parentElement.classList.add('active');
        }
    });  
    // $(document).ready(function(){
    //     var table = $('#myTable').DataTable();

    //     // Đặt sự kiện click cho nút xóa
    //     table.on('click', '.delete', function(){
    //         var $tr = $(this).closest('tr');
    //         if($($tr).hasClass('child')){
    //             $tr = $tr.prev('.parent');
    //         }

    //         var data = table.row($tr).data();
    //         let orderCode = data[0]; // Lấy mã code từ dữ liệu

    //         // Đặt giá trị ban đầu cho cancellation
    //         let cancellation = 'null';

    //         console.log(cancellation);
    //         console.log(orderCode);

    //         // Gán mã đơn hàng vào input hidden
    //         $('#order_code').val(orderCode);

    //         // Lắng nghe sự kiện change của input reason
    //         $('#reason').on('change', function(){
    //             cancellation = $(this).val();
    //             console.log(cancellation);
    //         });

    //         // Lắng nghe sự kiện click của nút submit
    //         $('#deleteForm').on('submit', function(e){
    //             e.preventDefault(); // Ngăn form submit mặc định
    //             $.ajax({
    //                 url: '/DoAn_PetcareHub/cho-xac-nhan',
    //                 type: 'POST',
    //                 data: {
    //                     _token: '{{ csrf_token() }}', // CSRF Token
    //                     code: orderCode,
    //                     cancellation: cancellation // Giá trị của trường cancellation
    //                 },
    //                 success: function(response) {
    //                     // Xử lý phản hồi từ server nếu cần
    //                     alert(response.message);
    //                     window.location.href = response.redirect_url; 
    //                 },
    //                 error: function(xhr, status, error) {
    //                     // Xử lý lỗi nếu có
    //                     console.error(error);
    //                 }
    //             });
    //         });
    //     });
    // });
    // $(document).ready(function() {
    //     $('.delete').click(function() {
    //         var code = $(this).data('code'); // Lấy giá trị của thuộc tính data-code
    //         $('#order_code').val(code); // Đặt giá trị vào input ẩn
    //     });

    //     $('#deleteForm').submit(function(event) {
    //         event.preventDefault(); // Ngăn chặn việc gửi form mặc định

    //         // Thực hiện ajax
    //         $.ajax({
    //             url:'/DoAn_PetcareHub/cho-xac-nhan',
    //             method: 'POST',
    //             data: $(this).serialize(), // Lấy dữ liệu từ form
    //             success: function(response) {
    //                 alert(response.message);
    //                     window.location.href = response.redirect_url; 
    //             },
    //             error: function(xhr, status, error) {
    //                 // Xử lý khi có lỗi
    //             }
    //         });
    //     });
    // });
    $(document).ready(function(){
    if ($('#thead').length>0) {
        var table = $('#myTable').DataTable();

        // Đặt sự kiện click cho nút xóa
        table.on('click', '.delete', function(){
            var $tr = $(this).closest('tr');
            if($($tr).hasClass('child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            let orderCode = data[0]; // Lấy mã code từ dữ liệu

            // Đặt giá trị ban đầu cho cancellation
            let cancellation = 'null';

            console.log(cancellation);
            console.log(orderCode);

            // Gán mã đơn hàng vào input hidden
            $('#order_code').val(orderCode);

            // Lắng nghe sự kiện change của input reason
            $('#reason').on('change', function(){
                cancellation = $(this).val();
                console.log(cancellation);
            });

            // Lắng nghe sự kiện click của nút submit
            $('#deleteForm').on('submit', function(e){
                e.preventDefault(); // Ngăn form submit mặc định
                $.ajax({
                    url: '/DoAn_PetcareHub/cho-xac-nhan',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF Token
                        code: orderCode,
                        cancellation: cancellation // Giá trị của trường cancellation
                    },
                    success: function(response) {
                        // Xử lý phản hồi từ server nếu cần
                        alert(response.message);
                        window.location.href = response.redirect_url; 
                    },
                    error: function(xhr, status, error) {
                        // Xử lý lỗi nếu có
                        console.error(error);
                    }
                });
            });
        });
    } else {
            $('.delete').click(function() {
            var code = $(this).data('code'); // Lấy giá trị của thuộc tính data-code
            console.log(code);
            $('#order_code').val(code); // Đặt giá trị vào input ẩn
        });

        $('#deleteForm').submit(function(event) {
            event.preventDefault(); // Ngăn chặn việc gửi form mặc định

            // Thực hiện ajax
            $.ajax({
                url:'/DoAn_PetcareHub/cho-xac-nhan',
                method: 'POST',
                data: $(this).serialize(), // Lấy dữ liệu từ form
                success: function(response) {
                    alert(response.message);
                    window.location.replace(response.redirect_url);
                },
                error: function(xhr, status, error) {
                    // Xử lý khi có lỗi
                }
            });
        });
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

</script>
@endsection

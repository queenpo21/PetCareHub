@extends('admin_layout')
@section('admin_content')

@if (session('dat_lich'))
    <h2>Thông tin đặt lịch mới:</h2>
    <p>Họ tên: {{ session('dat_lich.ho_ten') }}</p>
    <p>Email: {{ session('dat_lich.email') }}</p>
    <p>Ngày đặt: {{ session('dat_lich.ngay_dat') }}</p>
    <p>Dịch vụ: {{ session('dat_lich.dich_vu') }}</p>
@endif

<link rel="stylesheet" href="{{asset('public/frontend/css/styleOrderadmin.css')}}">

<link rel="stylesheet" href="{{asset('public/frontend/css/quanlynhanvien.css')}}">

<div id="head-container">
                <div id="arrange">
                    <label for="arrange-price">Sắp xếp theo tổng tiền: </label>
                    <select id="arrange-price">
                        <option value="1">Mặc định</option>
                        <option value="2">Tăng dần</option>
                        <option value="3">Giảm dần</option>
                    </select>
                </div>
            </div>
            <table id="myTable">
                <thead>
                    <tr class="head">
                        <th style="width:20%;">Số hóa đơn</th>
                        <th style="width:20%;">Tên khách hàng</th>
                        <th style="width:20%;">Ngày hóa đơn</th>
                        <th style="width:20%;">Tổng tiền</th>
                        <th style="width:10%;">Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($emps as $empdata)
                    <tr>
                        <td style="width:20%;">{{$empdata->id}}</td>
                        <td style="width:20%;">{{$empdata->name}}</td>
                        <td style="width:20%;">{{$empdata->updated_at}}</td>
                        <td style="width:20%;">{{$empdata->total}}</td>
                        <td style="width:10%;">
                            <button type="button" class="btn btn-primary edit" data-bs-toggle="modal"
                                data-bs-target="#editModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger delete" data-bs-toggle="modal"
                            data-bs-target="#deleteModal"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <?php
            $message = Session::get('message');
            if($message){
                echo '<p class="text-alert" style="color:green; text-align:right; margin-right: 2vw"><i>'. $message.'</i></p>';
                Session::put('message',null);
            }
        ?>
 <script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script>
   $(document).ready(function(){
    try {
        var table = $('#myTable').DataTable();
        table.on('click', '.delete', function(){
            $tr = $(this).closest('tr')
            if($($tr).hasClass('Child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
           console.log('1');
            $('#deleteForm').attr('action','/DoAn_PetcareHub/quan-ly-hoa-don/' + data[0]);
            console.log('2');
            $('#deleteModal').modal('show');
            console.log('3');
        });
    } catch (error) {
        console.error("An error occurred:", error);
    }
    table.on('click', '.edit', function(){
            $('#detail-product tbody').empty();
            console.log('Table body emptied');
            
            $tr = $(this).closest('tr')
            if($($tr).hasClass('Child')){
                $tr = $tr.prev('.parent');
            }
            var data = table.row($tr).data();
            var orderId = data[0];
            console.log(orderId);
            $.ajax({
            url: '/DoAn_PetcareHub/chi-tiet-hoa-don/' + orderId,
             method: 'GET',
            success: function(response) {
                console.log('AJAX call successful');
                console.log(response);
                $('#totalpay').text(response[0].total);
                 $('#fee-transfer').text(response[0].ship_cost);
                $('#total').text(response[0].total - response[0].ship_cost);
               
                $('#deatil-customerName').text(response[0].kh_name);
                $('#date-bill').text(response[0].updated_at);
              
                $('#address').text(response[0].address);
             
             var inum=0;
        
             response.forEach(function(item) {
                console.log('Order Total: ' + item.total);
                console.log('Shipping Cost: ' + item.ship_cost);
                console.log('Product Name: ' + item.product_name);
                console.log('Product Price: ' + item.price);
                console.log('Type Product Name: ' + item.typeproduct_name);
                console.log('Number of Items: ' + item.num);
                inum += item.num;
               
            
                var newRow = $('<tr>');
                    console.log('new row')


                // Thêm các cột vào hàng
                newRow.append('<td><p class="name-product">' + item.product_name + '</p></td>');
                newRow.append('<td><p class="classify">' + item.typeproduct_name + '</p></td>'); // Sử dụng product_id như một ví dụ
                newRow.append('<td><p class="price">' + item.price + '</p></td>'); // Giả sử item có thuộc tính price
                newRow.append('<td><p class="quantity-product">' + item.num + '</p></td>');
                newRow.append('<td><p class="total-price">' + (item.price * item.num) + '</p></td>'); // Giả sử item có thuộc tính price
              
                // Thêm hàng mới vào bảng
                $('#detail-product tbody').append(newRow);
                console.log('append new row')
                // ...
            });
            // $('#quantity').text(inum);
            
        
    }
});
$('#detailBill').modal('show');
});
    $('#arrange-price').change(function() {
        var selectedOption = $(this).val();
        if (selectedOption == '2') {
            // Sắp xếp tăng dần theo cột "Tổng tiền" (cột thứ 4, đếm từ 0)
            table.order([3, 'asc']).draw();
        } else if (selectedOption == '3') {
            // Sắp xếp giảm dần theo cột "Tổng tiền"
            table.order([3, 'desc']).draw();
        } else {
            // Sắp xếp mặc định
            table.order([]).draw();
        }
    });
});
</script>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa hóa đơn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            <form  method="POST" id="deleteForm">
                {{ csrf_field() }}
                {{ method_field('DELETE')}}
                <div class="modal-body">
                    <input type="hidden" name="_method" value="DELETE">
                    <p>Bạn chắc chắc chắn muốn xóa?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Xóa!</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="detailBill" tabindex="-1" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Thông tin hóa đơn</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-content">
            <div class="modal-body">
                <div id="detail-infor">
                    <ul>
                        <li>
                            <h5>Tên khách hàng: </h5>
                            <p id="deatil-customerName"></p>
                        </li>
                        <li>
                            <h5>Địa chỉ: </h5>
                            <p id="address">
                               </p>
                        </li>
                        <li>
                            <h5>Ngày hóa đơn: </h5>
                            <p id="date-bill"></p>
                        </li>
                    </ul>
                </div>
                <hr style="border:1px solid rgb(64, 64, 64);">
                <h4 id="title-table">Chi tiết hóa đơn</h4>
                <table id="detail-product">
                   <thead>
                        <tr>
                            <th style="width: 30%;">
                                <p>Tên sản phẩm</p>
                            </th>
                            <th style="width: 15%;">
                                <p>Phân loại</p>
                            </th>
                            <th style="width: 15%;">
                                <p>Giá</p>
                            </th>
                            <th style="width: 13%;">
                                <p>Số lượng</p>
                            </th>
                            <th style="width: 15%;">
                                <p>Tổng tiền</p>
                            </th>
                        </tr>
                   </thead>
                   <tbody>
                    
                   </tbody>
                   
                </table>
              <tfoot>
                    <tr>
                        <td colspan="5">
                            <table id="style-table" style="width: 50%;float: right; border: none;">
                                <tr>
                                    <td>
                                        <p>Tổng cộng</p>
                                    </td>
                                    <td>
                                        <p id="total"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Phí vận chuyển</p>
                                    </td>
                                    <td>
                                        <p id="fee-transfer"></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h3>Tổng</h3>
                                    </td>
                                    <td>
                                        <h3 id="totalpay" class="total-pay"></h3>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
              </tfoot>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

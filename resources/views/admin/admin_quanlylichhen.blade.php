@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="{{asset('public/frontend/css/quanlynhanvien.css')}}">
    <div style="justify-content: space-between; margin-top: 1vw;">
        {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm lịch hẹn</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{URL::to('/quan-ly-lich-hen')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Tên khách hàng</label>
                                <input type="text" class="form-control" id="name"
                                    placeholder="Nhập tên khách hàng" name="name"></input>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="col-form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" placeholder="Nhập số điện thoại khách hàng"
                                     id="phone" name="phone"></input>
                            </div>
                            <div class="mb-3">
                                <label for="appointment_date" class="col-form-label">Ngày hẹn</label>
                                <input type="date" class="form-control" id="appointment_date"
                                    placeholder="Nhập ngày hẹn" name="appointment_date"></input>
                            </div>
                            <div class="mb-3">
                                <label for="timeslot" class="col-form-label">Khung giờ</label>
                                <input type="text" class="form-control" id="timeslot"
                                    placeholder="Nhập số điện thoại" name="timeslot"></input>
                            </div>
                            <div class="mb-3">
                                <label for="total" class="col-form-label">Tổng tiền</label>
                                <input type="" class="form-control" id="total"
                                    placeholder="Tổng tiền" name="total"></input>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="submit" class="btn btn-primary">Lưu</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                <form action="{{URL::to('/quan-ly-lich-hen')}}" method="POST" id="viewForm">
                    {{ csrf_field() }}
                    {{ method_field('PUT')}}
                    <div class="modal-body">
                        Chi tiết lịch hẹn
                    </div>
                </form>
            </div>
        </div>
        <!------------------------------------------------------------------------------->
    </div>
    <br>
    <?php
        $message = Session::get('message');
        if($message){
            echo '<p class="text-alert" style="color:green; text-align:right; margin-right: 2vw"><i>'. $message.'</i></p>';
            Session::put('message',null);
        }
    ?>

    <table id="myTable">
        <thead>
            <tr class="head">
                <th style="width:5%;">Id</th>
                <th style="width:10%;">Mã cuộc hẹn</th>
                <th style="width:25%;">Tên khách hàng</th>
                <th style="width:10%;">Số điện thoại</th>
                <th style="width:10%;">Ngày hẹn</th>
                <th style="width:10%;">Khung giờ</th>
                <th style="width:10%;">Tổng tiền</th>
                <th style="width:20%;">Chi tiết</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style="width:5%;">Id</th>
                <th style="width:10%;">Mã cuộc hẹn</th>
                <th style="width:25%;">Tên khách hàng</th>
                <th style="width:10%;">Số điện thoại</th>
                <th style="width:10%;">Ngày hẹn</th>
                <th style="width:10%;">Khung giờ</th>
                <th style="width:10%;">Tổng tiền</th>
                <th style="width:20%;">Chi tiết</th>
            </tr>
        </thfoot>
        <tbody>
            @foreach ($app as $appdata)
            <tr>
                <td style="width:5%;">{{$appdata->id}}</td>
                <td style="width:10%;">{{$appdata->code}}</td>
                <td style="width:25%;">{{$appdata->customer->name}}</td>
                <td style="width:10%;">{{$appdata->customer->phone}}</td>
                <td style="width:10%;">{{(new Datetime($appdata->appointment_date))->format('d-m-Y')}}</td>
                <td style="width:10%;">{{$appdata->timeslot}}</td>
                <td style="width:10%;">{{$appdata->total}}</td>
                <td style="width:20%;">
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

<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){
        var table = $('#myTable').DataTable();

        // table.on('click', '.edit', function(){  
        //     $tr = $(this).closest('tr')
        //     if($($tr).hasClass('Child')){
        //         $tr = $tr.prev('.parent');
        //     }

        //     var data = table.row($tr).data();
        //     console.log(data);
        //     $('#nameEdit').val(data[1]);
        //     $('#emailEdit').val(data[2]);
        //     $('#phoneEdit').val(data[3]);
        //     $('#roleEdit').val(data[4]);
        //     $('#date_joinEdit').val(data[5]);

        //     $('#editForm').attr('action','/DoAn_PetcareHub/quan-ly-lich-hen/' + data[0]);
        //     $('#editModal').modal('show');
        // });

        table.on('click', '.delete', function(){
            $tr = $(this).closest('tr')
            if($($tr).hasClass('Child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
           
            $('#deleteForm').attr('action','/DoAn_PetcareHub/quan-ly-lich-hen/' + data[0]);
            $('#deleteModal').modal('show');
        });
    })

</script>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            <form action="{{URL::to('/quan-ly-lich-hen')}}" method="POST" id="deleteForm">
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

@endsection
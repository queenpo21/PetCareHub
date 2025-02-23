@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="{{asset('public/frontend/css/quanlynhanvien.css')}}">
    <div style="display: flex; justify-content: space-between; margin-top: 1vw;">
        <button class="add-employee-button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                class="bi bi-plus-square-fill"></i> Thêm nhân viên </button>
        <!--------------------------------------------------------------------------->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm nhân viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{URL::to('/them-nhan-vien')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Tên nhân viên</label>
                                <input type="text" class="form-control" id="name"
                                    placeholder="Nhập tên nhân viên" name="name"></input>
                            </div>
                            <div class="mb-3">
                                <label for="email-text" class="col-form-label">Email</label>
                                <input type="email" class="form-control" id="email"
                                    placeholder="Nhập địa chỉ email sinh viên" name="email"></input>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="col-form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone"
                                    placeholder="Nhập số điện thoại" name="phone"></input>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Vị trí</label>
                                <input type="text" class="form-control" id="role"
                                    placeholder="Nhập vị trí nhân viên" name="role"></input>
                            </div>
                            <div class="mb-3">
                                <label for="datetime" class="col-form-label">Ngày vào làm</label>
                                <input type="date" class="form-control" id="date_join" name="date_join"></input>
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
        </div>
            <!--------------------------------------------------------------------------->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Sửa nhân viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                <form action="{{URL::to('/quan-ly-nhan-vien')}}" method="POST" id="editForm">
                    {{ csrf_field() }}
                    {{ method_field('PUT')}}
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Tên nhân viên</label>
                            <input type="text" class="form-control" id="nameEdit"
                                placeholder="Nhập tên nhân viên" name="name"></input>
                        </div>
                        <div class="mb-3">
                            <label for="email-text" class="col-form-label">Email</label>
                            <input type="email" class="form-control" id="emailEdit"
                                placeholder="Nhập địa chỉ email sinh viên" name="email"></input>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="col-form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phoneEdit"
                                placeholder="Nhập số điện thoại" name="phone"></input>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label">Vị trí</label>
                            <input type="text" class="form-control" id="roleEdit"
                                placeholder="Nhập vị trí nhân viên" name="role"></input>
                        </div>
                        <div class="mb-3">
                            <label for="datetime" class="col-form-label">Ngày vào làm</label>
                            <input type="date" class="form-control" id="date_joinEdit" name="date_join"></input>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
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
    <table id="myTable" style="width:100%;">
        <thead>
            <tr class="head">
                <th style="width:3%;">Id</th>
                <th style="width:15%;">Nhân viên </th>
                <th style="width:20%;">Email</th>
                <th style="width:15%;">Số điện thoại</th>
                <th style="width:10%;">Vị trí</th>
                <th style="width:15%;">Ngày vào làm</th>
                <th style="width:15%;">Chi tiết</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style="width:5%;">Id</th>
                <th style="width:20%;">Nhân viên </th>
                <th style="width:20%;">Email</th>
                <th style="width:10%;">Số điện thoại</th>
                <th style="width:10%;">Vị trí</th>
                <th style="width:15%;">Ngày vào làm</th>
                <th style="width:20%;">Chi tiết</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($emps as $empdata)
            <tr>
                <td style="width:5%;">{{$empdata->id}}</td>
                <td style="width:25%;">{{$empdata->name}}</td>
                <td style="width:20%;">{{$empdata->email}}</td>
                <td style="width:10%;">{{$empdata->phone}}</td>
                <td style="width:10%;">{{$empdata->role}}</td>
                <td style="width:15%;">{{$empdata->date_join}}</td>
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

        table.on('click', '.edit', function(){
            $tr = $(this).closest('tr')
            if($($tr).hasClass('Child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
            $('#nameEdit').val(data[1]);
            $('#emailEdit').val(data[2]);
            $('#phoneEdit').val(data[3]);
            $('#roleEdit').val(data[4]);
            $('#date_joinEdit').val(data[5]);

            $('#editForm').attr('action','/DoAn_PetcareHub/quan-ly-nhan-vien/' + data[0]);
            $('#editModal').modal('show');
        });
        table.on('click', '.delete', function(){
            $tr = $(this).closest('tr')
            if($($tr).hasClass('Child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
           
            $('#deleteForm').attr('action','/DoAn_PetcareHub/quan-ly-nhan-vien/' + data[0]);
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
            <form method="POST" id="deleteForm">
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
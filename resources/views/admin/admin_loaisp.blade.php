@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="{{asset('public/frontend/css/quanlynhanvien.css')}}">
    <div style="display: flex; justify-content: space-between; margin-top: 1vw;">
        <button class="add-employee-button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                class="bi bi-plus-square-fill"></i> Thêm loại sản phẩm </button>
        <!--------------------------------------------------------------------------->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm loại sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{URL::to('/loai-san-pham')}}" method="POST">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="col-form-label">Tên loại</label>
                                <input type="text" class="form-control" id="name"
                                    placeholder="Nhập tên loại sản phẩm" name="name"></input>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="col-form-label">Tên danh mục </label>
                                <select class="form-control" id="category" name="category">
                                    <option value=""></option>
                                    @foreach ($cate as $catedata)
                                        <option value="{{$catedata->name}}">{{$catedata->name}}</option>
                                    @endforeach
                                </select>
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
                        <h5 class="modal-title" id="exampleModalLabel">Sửa loại sản phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                <form action="{{URL::to('/loai-san-pham')}}" method="POST" id="editForm">
                    {{ csrf_field() }}
                    {{ method_field('PUT')}}
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Tên loại sản phẩm</label>
                            <input type="text" class="form-control" id="nameEdit"
                                placeholder="Nhập tên danh mục" name="name"></input>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="col-form-label">Tên danh mục </label>
                            <select class="form-control" id="categoryEdit" name="category">
                                <option id="show"></option>
                                @foreach ($cate as $catedata)
                                    <option value="{{$catedata->name}}">{{$catedata->name}}</option>
                                @endforeach
                            </select>
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
    <table id="myTable">
        <thead>
            <th style="width:20%;">Mã loại</th>
            <th style="width:30%;">Tên loại sản phẩm</th>
            <th style="width:30%;">Tên danh mục</th>
            <th style="width:20%;">Thao tác</th>
        </thead>
        <tfoot>
            <th style="width:20%;">Mã loại</th>
            <th style="width:30%;">Tên loại sản phẩm</th>
            <th style="width:30%;">Tên danh mục</th>
            <th style="width:20%;">Thao tác</th>
        </tfoot>
        <tbody>
            @foreach ($typ as $typdata)
            <tr>
                <td style="width:20%;">{{$typdata->id}}</td>
                <td style="width:30%;">{{$typdata->name}}</td>
                <td style="width:30%;">{{$typdata->category_name}}</td>
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
            $('#categoryEdit').val(data[2]);

            $('#editForm').attr('action','/DoAn_PetcareHub/loai-san-pham/' + data[0]);
            $('#editModal').modal('show');
        });
        table.on('click', '.delete', function(){
            $tr = $(this).closest('tr')
            if($($tr).hasClass('Child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
           
            $('#deleteForm').attr('action','/DoAn_PetcareHub/loai-san-pham/' + data[0]);
            $('#deleteModal').modal('show');
        });
    })

</script>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa loại sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            <form action="{{URL::to('/loai-san-pham')}}" method="POST" id="deleteForm">
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
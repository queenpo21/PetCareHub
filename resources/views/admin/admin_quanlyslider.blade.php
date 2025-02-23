@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="{{asset('public/frontend/css/quanlynhanvien.css')}}">
    <div style="display: flex; justify-content: space-between; margin-top: 1vw;">
        <button class="add-employee-button" data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                class="bi bi-plus-square-fill"></i> Thêm slider </button>
        <!--------------------------------------------------------------------------->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Thêm slider</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <form action="{{URL::to('/quan-ly-slider')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="image" class="col-form-label">Hình ảnh</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*"></input>
                            </div>
                            <div class="mb-3">
                                <label for="message-text" class="col-form-label">Vị trí</label>
                                <input type="text" class="form-control" id="place"
                                    placeholder="Nhập vị trí slider" name="place"></input>
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
        
        <!------------------------------------------------------------------------------->
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
                <th style="width:5%;">ID</th>
                <th style="width:35%;">Hình ảnh</th>
                <th style="width:25%;">Vị trí</th>
                <th style="width:20%;">Ngày tạo</th>
                <th style="width:15%;">Chi tiết</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style="width:5%;">ID</th>
                <th style="width:35%;">Hình ảnh</th>
                <th style="width:25%;">Vị trí</th>
                <th style="width:20%;">Ngày tạo</th>
                <th style="width:15%;">Chi tiết</th>
            </tr>
        </thfoot>
        <tbody>
            @foreach ($sli as $slidata)
            <tr>
                <td style="width:5%;">{{$slidata->id}}</td>
                <td style="width:35%;">
                    <img src="public/storage/sliders/{{$slidata->image}}" alt=" {{$slidata->image}}">
                </td>
                <td style="width:25%;">{{$slidata->place}}</td>
                <td style="width:10%;">{{$slidata->created_at->format('d-m-Y')}}</td>
                <td style="width:15%;">
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
            $('#placeEdit').val(data[2]);
            $('#currentImage').append(data[1]);

            $('#editForm').attr('action','/DoAn_PetcareHub/quan-ly-slider/' + data[0]);
            $('#editModal').modal('show');
        });
        table.on('click', '.delete', function(){
            $tr = $(this).closest('tr')
            if($($tr).hasClass('Child')){
                $tr = $tr.prev('.parent');
            }

            var data = table.row($tr).data();
            console.log(data);
           
            $('#deleteForm').attr('action','/DoAn_PetcareHub/quan-ly-slider/' + data[0]);
            $('#deleteModal').modal('show');
        });
    })

</script>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa slider</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
        <form action="{{URL::to('/quan-ly-slider')}}" method="POST" id="editForm">
            {{ csrf_field() }}
            {{ method_field('PUT')}}
            <div class="modal-body">
                <div class="mb-3">
                    <label for="image" class="col-form-label">Ảnh</label> <br>
                    <input type="file" class="form-control" id="imageEdit" name="image"></input>
                </div>
                <div class="mb-3">
                    <label for="message-text" class="col-form-label">Vị trí</label>
                    <input type="text" class="form-control" id="placeEdit"
                        placeholder="Nhập vị trí slider" name="place"></input>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </div>
        </form>
    </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Xóa nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
            <form action="{{URL::to('/quan-ly-slider')}}" method="POST" id="deleteForm">
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
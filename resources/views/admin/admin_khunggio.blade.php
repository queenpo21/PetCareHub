@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="{{asset('public/frontend/css/quanlynhanvien.css')}}">
    <div style="justify-content: space-between; margin-top: 1vw;">
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

    <table id="myTable">
        <thead>
            <tr class="head">
                <th style="width:30%;">Khung giờ</th>
                <th style="width:25%;">Ngày hẹn</th>
                <th style="width:25%;">Số lượng</th>
                <th style="width:20%;">Chi tiết</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th style="width:30%;">Khung giờ</th>
                <th style="width:25%;">Ngày hẹn</th>
                <th style="width:25%;">Số lượng</th>
                <th style="width:20%;">Chi tiết</th>
            </tr>
        </thfoot>
        <tbody>
            @foreach ($tim as $timdata)
            <tr>
                <td style="width:30%;">{{$timdata->timeslot}}</td>
                <td style="width:25%;">{{ (new Datetime($timdata->appointment_date))->format('d-m-Y')}}</td>
                <td style="width:25%;">{{$timdata->count}}</td>
                <td style="width:20%;">
                    <button type="button" class="btn btn-primary edit" data-bs-toggle="modal"
                        data-bs-target="#editModal" style="background-color:green">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

<script src="https://cdn.datatables.net/2.0.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>

<script type="text/javascript">
    window.onload= function(){
        var table = $('#myTable').DataTable();
        }
</script>
    
</div>

@endsection
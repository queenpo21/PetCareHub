@extends('layout')
@section('content')
        <link rel="stylesheet" href="{{asset('public/frontend/css/styleAccount.css')}}">

    <body>
        <div class="container">
            <div id="title">
                <h4>ĐỊA CHỈ</h4>
            </div>
            <div id="address-detail">
                <table>
                    <tr>
                        <td style="width: 80%;">
                            <p>Địa chỉ 1</p>
                        </td>
                        <td style="width: 10%;">
                            <a href="">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td style="width: 10%;">
                            <button>
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Địa chỉ 2</p>
                        </td>
                        <td>
                            <a href="">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        </td>
                        <td>
                            <button>
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button data-bs-toggle="modal" data-bs-target="#add-address"><i class="bi bi-plus-circle"></i>
                                <p style="margin-left: 1.5vw;margin-top: 0.2vw;">Thêm địa chỉ</p>
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="modal fade" id="add-address" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Sửa địa chỉ</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <select class="form-select form-select-sm mb-3" id="city" aria-label=".form-select-sm">
                                <option value="" selected>Chọn tỉnh thành</option>
                            </select>
                            <select class="form-select form-select-sm mb-3" id="district" aria-label=".form-select-sm">
                                <option value="" selected>Chọn quận huyện</option>
                            </select>
                            <select class="form-select form-select-sm" id="ward" aria-label=".form-select-sm">
                                <option value="" selected>Chọn phường xã</option>
                            </select>
                            <p>Chi tiết*</p>
                            <input type="text" id="address" placeholder="Số 34, Tân Lập">
                            <div id="error-message">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-primary" id="save">Lưu</button>
                        </div>
                    </div>
                </div>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
                <script>
                    var citis = document.getElementById("city");
                    var districts = document.getElementById("district");
                    var wards = document.getElementById("ward");
                    var Parameter = {
                        url: "https://raw.githubusercontent.com/kenzouno1/DiaGioiHanhChinhVN/master/data.json",
                        method: "GET",
                        responseType: "application/json",
                    };
                    var promise = axios(Parameter);
                    promise.then(function (result) {
                        renderCity(result.data);
                    });
    
                    function renderCity(data) {
                        for (const x of data) {
                            citis.options[citis.options.length] = new Option(x.Name, x.Id);
                        }
                        citis.onchange = function () {
                            district.length = 1;
                            ward.length = 1;
                            if (this.value != "") {
                                const result = data.filter(n => n.Id === this.value);
    
                                for (const k of result[0].Districts) {
                                    district.options[district.options.length] = new Option(k.Name, k.Id);
                                }
                            }
                        };
                        district.onchange = function () {
                            ward.length = 1;
                            const dataCity = data.filter((n) => n.Id === citis.value);
                            if (this.value != "") {
                                const dataWards = dataCity[0].Districts.filter(n => n.Id === this.value)[0].Wards;
    
                                for (const w of dataWards) {
                                    wards.options[wards.options.length] = new Option(w.Name, w.Id);
                                }
                            }
                        };
                    }
                    document.getElementById('save').addEventListener('click', function (event) {
                        event.preventDefault();
                        var city = document.getElementById('city');
                        var district = document.getElementById('district');
                        var ward = document.getElementById('ward');
                        var address = document.getElementById('address');
    
                        if (city.value === '' || district.value === '' || ward.value === '' || address.value === ' ') {
                            document.getElementById('error-message').innerHTML = '*Không được để trống thông tin';
                        } else {
                            document.getElementById('error-message').innerHTML = '';
                        }
                    });
                    document.getElementById('save').addEventListener('click', function (event) {
                        event.preventDefault();
                        var address = document.getElementById('address');
    
                        if (address.value === '') {
                            document.getElementById('error-message').innerHTML = '*Không được để trống thông tin';
                        } else {
                            document.getElementById('error-message').innerHTML = '';
                        }
                    });
    
                </script>
            </div>
        </div>
        
    </body>
</html>
@endsection
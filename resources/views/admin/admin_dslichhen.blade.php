@extends('admin_layout')
@section('admin_content')

<link rel="stylesheet" href="{{asset('public/frontend/css/dslichhen.css')}}">
<div class="admin" >
            <div id="style-link">
                <a href="" style="margin-right: 1vw;">Lịch hẹn</a>
                >
                <a href="" style="margin-left: 1vw;">Danh sách lịch hẹn</a>
            </div>
            <div id="container">
                <div id="head-container" >
                    <div id="add-time">
                        <button class="add-employee-button" data-bs-toggle="modal" data-bs-target="#insertModal"><i
                                class="bi bi-plus-square-fill" style="margin-right: 1vw;"></i> Thêm lịch
                            hẹn</button>
                    </div>
                    <div class="search">
                        <button class="search-button" style="height: fit-content;"><strong>Search</strong></button>
                        <input type="search" class="search-box" placeholder="Search...">
                    </div>
                </div>
                <div class="modal fade" id="insertModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>Thông tin đặt lịch</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Tên khách hàng</strong></p>
                                <div class="search-contain">
                                    <input type="text" class="sbox" placeholder="Nhập tên khách hàng">
                                </div>
                                <p><strong>Số điện thoại</strong></p>
                                <div class="search-contain">
                                    <input type="tel" class="sbox" placeholder="Nhập số điện thoại">
                                </div>
                                <p><strong>Chọn ngày</strong></p>
                                <div class="search-contain">
                                    <input type="date" class="sbox">
                                </div>
                                <div class="choose">
                                    <div class="choose-time">
                                        <p ><strong>Chọn khung giờ</strong></p>
                                        <label for="time">Chọn ca :</label>
                                        <select name="time" id="time">
                                            <option value="ca1">Ca1: 7h - 8h30</option>
                                            <option value="ca2">Ca2: 8h30 -10h</option>
                                            <option value="ca3">Ca3: 10h - 11h30</option>
                                            <option value="ca4">Ca4: 1h - 2h30</option>
                                            <option value="ca5">Ca5: 2h30 - 4h</option>
                                            <option value="ca6">Ca6: 4h - 5h30</option>
                                            <option value="ca7">Ca7: 5h30 - 7h</option>
                                        </select>
                                    </div>
                                    <div class="choose-pet">
                                        <p ><strong>Chọn loại thú cưng</strong></p>
                                        <label for="pet">Thú cưng :</label>
                                        <select name="pet" id="pet">
                                            <option value="pet1">Chó</option>
                                            <option value="pet2">Mèo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="choose-service">
                                    <p ><strong>Chọn dịch vụ :</strong></p>
                                    <div class="radio" >
                                        <input type="radio" id="radio1" name="group-radio" /><label
                                            for="radio1">Spa</label><br>
                                        <input type="radio" id="radio2" name="group-radio" /><label for="radio2">Khách
                                            sạn</label><br>
                                        <input type="radio" id="radio3" name="group-radio" /><label for="radio3">Spa &
                                            Khách sạn</label>
                                    </div>
                                </div>
                            </div>
                            <div id="infor-customer">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                <button type="button" class="btn btn-primary">Thêm</button>
                            </div>
                        </div>
                    </div>
                </div>
                </tr>
                </table>

                <table id="myTable">
                    <tr class="head">
                        <th style="width:15%;">Mã lịch hẹn</th>
                        <th style="width:25%;">Tên khách hàng</th>
                        <th style="width:15%;">Ngày đặt lịch</th>
                        <th style="width:15%;">Khung giờ</th>
                        <th style="width:15%;">Tổng tiền</th>
                        <th style="width:20%;">Chi tiết</th>
                    </tr>
                    <tr>
                        <td>A001</td>
                        <td>Nguyễn Văn A</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4> Thay đổi thông tin</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Tên khách hàng</strong></p>
                                        <div class="search-contain">
                                            <input type="text" class="sbox" placeholder="Nhập tên khách hàng">
                                        </div>
                                        <p><strong>Số điện thoại</strong></p>
                                        <div class="search-contain">
                                            <input type="tel" class="sbox" placeholder="Nhập số điện thoại">
                                        </div>
                                        <p><strong>Chọn ngày</strong></p>
                                        <div class="search-contain">
                                            <input type="date" class="sbox">
                                        </div>
                                        <div class="choose">
                                            <div>
                                                <p class="choose-time"><strong>Chọn khung giờ</strong></p>
                                                <label for="time">Chọn ca :</label>
                                                <select name="time" id="time">
                                                    <option value="ca1">Ca1: 7h - 8h30</option>
                                                    <option value="ca2">Ca2: 8h30 -10h</option>
                                                    <option value="ca3">Ca3: 10h - 11h30</option>
                                                    <option value="ca4">Ca4: 1h - 2h30</option>
                                                    <option value="ca5">Ca5: 2h30 - 4h</option>
                                                    <option value="ca6">Ca6: 4h - 5h30</option>
                                                    <option value="ca7">Ca7: 5h30 - 7h</option>
                                                </select>
                                            </div>
                                            <div class="choose-pet">
                                                <p><strong>Chọn loại thú cưng</strong></p>
                                                <label for="pet">Thú cưng :</label>
                                                <select name="pet" id="pet">
                                                    <option value="pet1">Chó</option>
                                                    <option value="pet2">Mèo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="choose-service">
                                            <p ><strong>Chọn dịch vụ :</strong></p>
                                            <div class="radio" >
                                                <input type="radio" id="type1" name="group-radio" /><label
                                                    for="type1">Spa</label><br>
                                                <input type="radio" id="type2" name="group-radio" /><label
                                                    for="type2">Khách
                                                    sạn</label><br>
                                                <input type="radio" id="type3" name="group-radio" /><label
                                                    for="type3">Spa &
                                                    Khách sạn</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="detail-service">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Hủy</button>
                                        <button type="button" class="btn btn-primary">Lưu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                    <tr>
                        <td>A002</td>
                        <td>Nguyễn Văn B</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A003</td>
                        <td>Nguyễn Văn C</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A004</td>
                        <td>Nguyễn Văn D</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A005</td>
                        <td>Nguyễn Văn E</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A006</td>
                        <td>Nguyễn Văn H</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A007</td>
                        <td>Nguyễn Văn G</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A008</td>
                        <td>Nguyễn Văn I</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A009</td>
                        <td>Nguyễn Văn K</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>A010</td>
                        <td>Nguyễn Văn J</td>
                        <td>22/03/2024</td>
                        <td>7:30</td>
                        <td class="total-price">100000</td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#exampleModal" style="background-color:green">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn btn-block btn-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </table>
                <nav aria-label="Page navigation example"
                    style="margin-top: 3vw; display: flex;justify-content: end; margin-right: 2vw; border: none;">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</body>
<script>
    document.getElementById('status').innerHTML = '<h3>Lịch hẹn</h3>'
    document.querySelectorAll('input[type=radio]').forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.id === 'radio1' && radio.checked) {
                document.getElementById('infor-customer').innerHTML = `
                <div class="spa-service">
                    <p ><strong>Dịch vụ Spa :</strong></p>
                    <form >
                        <input type="checkbox" name="spa" value="Spa tắm, vệ sinh">Spa tắm, vệ sinh<br>
                        <input type="checkbox" name="spa" value="Spa, cắt tỉa trọn gói">Spa, cắt tỉa trọn gói<br>
                        <input type="checkbox" name="spa" value="Cắt tỉa, nhuộm lông">Cắt tỉa, nhuộm lông<br>
                        <input type="checkbox" name="spa" value="Cạo lông toàn thân">Cạo lông toàn thân<br>
                    </form>
                </div>
                <div class="pet-size">
                    <p ><strong>Kích thước thú cưng :</strong></p>
                        <select  name="size" id="size">
                            <option value="size1">Dưới 2kg</option>
                            <option value="size2">Dưới 5kg</option>
                            <option value="size3">Dưới 10kg</option>
                            <option value="size4">Dưới 20kg</option>
                            <option value="size5">Trên 20kg</option>
                        </select>
                </div>
               `
            }
            else if (radio.id === 'radio2' && radio.checked) {
                document.getElementById('infor-customer').innerHTML = `
                <div class="hotel-service">
                    <p ><strong>Khách sạn :</strong></p>
                    <select name="hotel" id="hotel" >
                        <option value="hotel1">Khách sạn bình thường</option>
                        <option value="hotel2">Khách sạn phòng vip A</option>
                        <option value="hotel3">Khách sạn phòng vip B</option>
                        <option value="hotel4">Khách sạn phòng vip C</option>
                    </select>
                </div>
                <div class="pet-size">
                    <p ><strong>Kích thước thú cưng :</strong></p>
                        <select  name="sz" id="sz">
                                <option value="sz1">Dưới 10kg</option>
                                <option value="sz2">Dưới 20kg</option>
                                <option value="sz3">Dưới 40kg</option>
                        </select>
                </div>
                <form class="choose-date">
                    <p ><strong>Chọn số ngày :</strong></p>
                    <input  type="number" name="quantity" min="1" placeholder="1">
                </form>
                `
            }
            else if (radio.id === 'radio3' && radio.checked) {
                document.getElementById('infor-customer').innerHTML = `
                <div class="spa-service">
                    <p ><strong>Dịch vụ Spa :</strong></p>
                    <form >
                        <input type="checkbox" name="spa" value="Spa tắm, vệ sinh">Spa tắm, vệ sinh<br>
                        <input type="checkbox" name="spa" value="Spa, cắt tỉa trọn gói">Spa, cắt tỉa trọn gói<br>
                        <input type="checkbox" name="spa" value="Cắt tỉa, nhuộm lông">Cắt tỉa, nhuộm lông<br>
                        <input type="checkbox" name="spa" value="Cạo lông toàn thân">Cạo lông toàn thân<br>
                    </form>
                </div>
                <div class="pet-size">
                    <p ><strong>Kích thước thú cưng :</strong></p>
                        <select  name="size" id="size">
                            <option value="size1">Dưới 2kg</option>
                            <option value="size2">Dưới 5kg</option>
                            <option value="size3">Dưới 10kg</option>
                            <option value="size4">Dưới 20kg</option>
                            <option value="size5">Trên 20kg</option>
                        </select>
                </div>
                <div class="hotel-ser">
                    <p ><strong>Khách sạn :</strong></p>
                    <select name="hotel" id="hotel" >
                        <option value="hotel1">Khách sạn bình thường</option>
                        <option value="hotel2">Khách sạn phòng vip A</option>
                        <option value="hotel3">Khách sạn phòng vip B</option>
                        <option value="hotel4">Khách sạn phòng vip C</option>
                    </select>
                </div>
                <div class="pet-size">
                    <p ><strong>Kích thước thú cưng :</strong></p>
                        <select  name="sz" id="sz">
                                <option value="sz1">Dưới 10kg</option>
                                <option value="sz2">Dưới 20kg</option>
                                <option value="sz3">Dưới 40kg</option>
                        </select>
                </div>
                <form class="choose-date">
                    <p ><strong>Chọn số ngày :</strong></p>
                    <input  type="number" name="quantity" min="1" placeholder="1">
                </form>
                `
            }
        });

    });
    document.querySelectorAll('input[type=radio]').forEach(radio => {
        radio.addEventListener('change', () => {
            if (radio.id === 'type1' && radio.checked) {
                document.getElementById('detail-service').innerHTML = `
                <div class="spa-service">
                    <p ><strong>Dịch vụ Spa :</strong></p>
                    <form >
                        <input type="checkbox" name="spa" value="Spa tắm, vệ sinh">Spa tắm, vệ sinh<br>
                        <input type="checkbox" name="spa" value="Spa, cắt tỉa trọn gói">Spa, cắt tỉa trọn gói<br>
                        <input type="checkbox" name="spa" value="Cắt tỉa, nhuộm lông">Cắt tỉa, nhuộm lông<br>
                        <input type="checkbox" name="spa" value="Cạo lông toàn thân">Cạo lông toàn thân<br>
                    </form>
                </div>
                <div class="pet-size">
                    <p ><strong>Kích thước thú cưng :</strong></p>
                        <select  name="size" id="size">
                            <option value="size1">Dưới 2kg</option>
                            <option value="size2">Dưới 5kg</option>
                            <option value="size3">Dưới 10kg</option>
                            <option value="size4">Dưới 20kg</option>
                            <option value="size5">Trên 20kg</option>
                        </select>
                </div>
               `
            }
            else if (radio.id === 'type2' && radio.checked) {
                document.getElementById('detail-service').innerHTML = `
                <div class="hotel-service">
                    <p ><strong>Khách sạn :</strong></p>
                    <select name="hotel" id="hotel" >
                        <option value="hotel1">Khách sạn bình thường</option>
                        <option value="hotel2">Khách sạn phòng vip A</option>
                        <option value="hotel3">Khách sạn phòng vip B</option>
                        <option value="hotel4">Khách sạn phòng vip C</option>
                    </select>
                </div>
                <div class="pet-size">
                    <p ><strong>Kích thước thú cưng :</strong></p>
                        <select  name="sz" id="sz">
                                <option value="sz1">Dưới 10kg</option>
                                <option value="sz2">Dưới 20kg</option>
                                <option value="sz3">Dưới 40kg</option>
                        </select>
                </div>
                <form class="choose-date">
                    <p ><strong>Chọn số ngày :</strong></p>
                    <input  type="number" name="quantity" min="1" placeholder="1">
                </form>
                `
            }
            else if (radio.id === 'type3' && radio.checked) {
                document.getElementById('detail-service').innerHTML = `
                <div class="spa-service">
                    <p ><strong>Dịch vụ Spa :</strong></p>
                    <form >
                        <input type="checkbox" name="spa" value="Spa tắm, vệ sinh">Spa tắm, vệ sinh<br>
                        <input type="checkbox" name="spa" value="Spa, cắt tỉa trọn gói">Spa, cắt tỉa trọn gói<br>
                        <input type="checkbox" name="spa" value="Cắt tỉa, nhuộm lông">Cắt tỉa, nhuộm lông<br>
                        <input type="checkbox" name="spa" value="Cạo lông toàn thân">Cạo lông toàn thân<br>
                    </form>
                </div>
                <div class="pet-size">
                    <p ><strong>Kích thước thú cưng :</strong></p>
                        <select  name="size" id="size">
                            <option value="size1">Dưới 2kg</option>
                            <option value="size2">Dưới 5kg</option>
                            <option value="size3">Dưới 10kg</option>
                            <option value="size4">Dưới 20kg</option>
                            <option value="size5">Trên 20kg</option>
                        </select>
                </div>
                <div class="hotel-ser">
                    <p ><strong>Khách sạn :</strong></p>
                    <select name="hotel" id="hotel" >
                        <option value="hotel1">Khách sạn bình thường</option>
                        <option value="hotel2">Khách sạn phòng vip A</option>
                        <option value="hotel3">Khách sạn phòng vip B</option>
                        <option value="hotel4">Khách sạn phòng vip C</option>
                    </select>
                </div>
                <div class="pet-size">
                    <p ><strong>Kích thước thú cưng :</strong></p>
                        <select  name="sz" id="sz">
                                <option value="sz1">Dưới 10kg</option>
                                <option value="sz2">Dưới 20kg</option>
                                <option value="sz3">Dưới 40kg</option>
                        </select>
                </div>
                <form class="choose-date">
                    <p ><strong>Chọn số ngày :</strong></p>
                    <input  type="number" name="quantity" min="1" placeholder="1">
                </form>
                `
            }
        });
    });
    const totalPrice = document.getElementsByClassName('total-price');
        function formatPrice(price) {
            return price.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });
        }
        for (let i = 0; i < totalPrice.length; i++) {
            const originalValue = parseInt(totalPrice[i].textContent);
            const price = formatPrice(originalValue);
            totalPrice[i].textContent = price;
        }
</script>
@endsection

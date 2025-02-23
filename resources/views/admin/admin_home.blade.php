@extends('admin_layout')
@section('admin_content')
<link rel="stylesheet" href="{{asset('public/frontend/css/styleHomeadmin.css')}}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<div id="part-1">

    <div id="statistic">
        <div id="date">
            <p>Ngày: </p>
            <input type="date" id="current-time" name="a"
                style="padding: 5px;font-size: 20px;font-weight: 600;color: #003459;">
        </div>
        <div id="style-1">
            <div id="total-revenue">
                <i class="fas fa-chart-line"
                    style="background-color: #FA5A7D;padding: 0.5vw;color: white;border-radius: 20px;"></i>
                <h4 id="detail-revenue"></h4>
                <p>Tổng doanh thu</p>
            </div>
            <div id="total-order">
                <i class="fas fa-clipboard-list"
                    style="background-color: #FF947A;padding: 0.5vw 0.6vw;color: white;border-radius: 20px;"></i>
                <h4 id="detail-order"></h4>
                <p>Tổng đơn</p>
            </div>
            <div id="new-customer">
                <i class="fas fa-user-plus"
                    style="background-color: #BF83FF;padding: 0.5vw 0.4vw;color: white;border-radius: 20px;"></i>
                <h4 id="detail-customer"></h4>
                <p>Khách hàng mới</p>
            </div>
        </div>
    </div>
    <div id="best-seller">
        <div style="display: flex; align-items: center;">
            <h5 class="title">Sản phẩm bán chạy</h5>
            <div id="date" style="margin-bottom: 10px; margin-left:20px">
                <input type="month" id="top" name="a"
                    style="padding: 5px;font-size: 20px;font-weight: 600;color: #003459;">
            </div>
        </div>
        <table style="width: 100%;">
            <tr>
                <th style="width: 10%;">#</th>
                <th style="width: 70%;">Sản Phẩm</th>
                <th style="width: 20%;">Số lượng</th>
            </tr>
            <tr>
                <td>
                    <p>1</p>
                </td>
                <td>
                    <p id="product-1" class="text-truncate-container"></p>
                </td>
                <td>
                    <p id="ratio-1"></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>2</p>
                </td>
                <td>
                    <p id="product-2" class="text-truncate-container"></p>
                </td>
                <td>
                    <p id="ratio-2"></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>3</p>
                </td>
                <td>
                    <p id="product-3" class="text-truncate-container"></p>
                </td>
                <td>
                    <p id="ratio-3"></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>4</p>
                </td>
                <td>
                    <p id="product-4" class="text-truncate-container"></p>
                </td>
                <td>
                    <p id="ratio-4"></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>5</p>
                </td>
                <td>
                    <p id="product-5" class="text-truncate-container"></p>
                </td>
                <td>
                    <p id="ratio-5"></p>
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- biểu đồ cột --}}
<div class="chartRevenue">
    <div id="date">
        <p>Ngày: </p>
        <input type="date" id="current-time-doanhthu" name="a"
            style="padding: 5px;font-size: 20px;font-weight: 600;color: #003459;">
    </div>
    <h5 class="title">Tổng doanh thu</h5>
    <p style="color: #96A5B8;">(VNĐ)</p>
    <div class="chartBox">
        <canvas id="venueChart"></canvas>
    </div>
</div>
<script>

</script>
{{-- Sự kiện thay đổi ngày --}}
<script>
    $('#current-time').on('change', function() {
    var selectedDate = $(this).val();
    console.log('Selected date: ' + selectedDate);
    $.ajax({
       
    url: '/DoAn_PetcareHub/thong-ke/' + selectedDate,
    method: 'GET',
    success: function(response) {
        try {
            console.log(response);
            if(response.total<1000000)
            {
                $('#detail-revenue').text(response.total + ' Nghìn');
            }
            else if(response.total<1000000000)
            {
                $('#detail-revenue').text((response.total/1000000).toFixed(2) + ' Triệu');
            }
            else if(response.total<1000000000000)
            {
                $('#detail-revenue').text((response.total/1000000).toFixed(2) + ' Tỷ');
            }
    
            $('#detail-order').text(response.count);
            $('#detail-customer').text(response.user);
        } catch (error) {
            console.error('Có lỗi xảy ra khi xử lý phản hồi từ server:', error);
        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.error('Có lỗi xảy ra khi thực hiện yêu cầu AJAX:', textStatus, errorThrown);
    }
});
    });
</script>
{{--Biểu đồ khách hàng đơn hàng--}}
<div class="chartOrder">
    <div id="date">
        <p>Ngày: </p>
        <input type="date" id="current-time-donhang" name="a"
            style="padding: 5px;font-size: 20px;font-weight: 600;color: #003459;">
    </div>
                <h5 class="title">Đơn hàng </h5>
                <div class="chartBox">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.min.js"></script>
<script>
    // window.onload = (function loadDate() {
    //     let date = new Date(),
    //         day = date.getDate(),
    //         month = date.getMonth() + 1,
    //         year = date.getFullYear();

    //     if (month < 10) month = "0" + month;
    //     if (day < 10) day = "0" + day;

    //     const todayDate = `${year}-${month}-${day}`;
    //     const currentMonthYear = `${year}-${month}`;

    //     document.getElementById("current-time").value = todayDate;
    //     document.getElementById("current-time-doanhthu").value = todayDate;
    //     document.getElementById("current-time-donhang").value = todayDate;
    //     document.getElementById("current-year").innerHTML = year;
    //     document.getElementById("top").value = currentMonthYear;
    // });
    window.onload = function() {
    let date = new Date(),
        day = date.getDate(),
        month = date.getMonth() + 1,
        year = date.getFullYear();

    if (month < 10) month = "0" + month;
    if (day < 10) day = "0" + day;

    const todayDate = `${year}-${month}-${day}`;
    const currentMonthYear = `${year}-${month}`;
    document.getElementById("top").value = currentMonthYear;
    document.getElementById("current-time").value = todayDate;
    document.getElementById("current-time-doanhthu").value = todayDate;
    document.getElementById("current-time-donhang").value = todayDate;
    document.getElementById("current-year").innerHTML = year;

    
};


    
    let venueChart;
    let serviceChart;
    let dataOrder;
   
    $('#current-time-donhang').on('change', function() {
        // console.log("Su kien thay doi ngay");
        var data1;
        var data2;
    
    if (serviceChart) {
        serviceChart.destroy();
    }
    let newLabels = [];
   
    var selectedDateValue = $(this).val();
    // console.log('Selected date: ' + selectedDateValue);
    let selectedDate = new Date(selectedDateValue);
    let day = selectedDate.getDay();
    let diffToMonday = selectedDate.getDate() - day + (day === 0 ? -6:1);
    let startOfWeek = new Date(selectedDate.setDate(diffToMonday));
    let endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(endOfWeek.getDate() + 6);
    let formattedStartOfWeek = startOfWeek.getFullYear() + '-' + String(startOfWeek.getMonth() + 1).padStart(2, '0') + '-' + String(startOfWeek.getDate()).padStart(2, '0');
    let formattedEndOfWeek = endOfWeek.getFullYear() + '-' + String(endOfWeek.getMonth() + 1).padStart(2, '0') + '-' + String(endOfWeek.getDate()).padStart(2, '0');

    // console.log('Start of week: ' + formattedStartOfWeek);
    // console.log('End of week: ' + formattedEndOfWeek); 
    let start = new Date(startOfWeek); // replace with your startOfWeek date
    let end = new Date(endOfWeek); // replace with your endOfWeek date
   
    for(let date = start; date <= end; date.setDate(date.getDate() + 1)) {
    let formattedDate = String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' + String(date.getFullYear()).slice(-2);
    //  console.log(formattedDate); // Print the date before pushing it
        newLabels.push(String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' + String(date.getFullYear()).slice(-2));
       
    }
    $.ajax({
       
       
    url: '/DoAn_PetcareHub/thong-ke-don-hang/' + formattedStartOfWeek + '/' + formattedEndOfWeek,
    method: 'GET',
    success: function(response) {
      console.log(response)
    var allDays = newLabels;
    var allDays1=newLabels;
    // console.log("allDays:");
    // console.log(allDays);
    var counts = {};
    var counts1={};
   

    // Khởi tạo counts cho tất cả các ngày là 0
    allDays.forEach(function(day) {
        counts[day] = 0;
    });
    allDays1.forEach(function(day) {
        counts1[day] = 0;
    });
    

    // Kiểm tra nếu response là một mảng trước khi cố gắng lặp qua nó
    if (Array.isArray(response.orderofweek)) {
        // Điền counts với dữ liệu từ response
        response.orderofweek.forEach(function(item) {
            let date = new Date(item.date);
        let formattedDate = String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' + String(date.getFullYear()).slice(-2);
        counts[formattedDate] = item.count;
        });
    } else {
        console.error('Response không phải là một mảng:', response);
    }

    if (Array.isArray(response.totalPerDay)) {
        // Điền counts với dữ liệu từ response
        response.totalPerDay.forEach(function(item) {
            let date = new Date(item.date);
        let formattedDate = String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' + String(date.getFullYear()).slice(-2);
        counts1[formattedDate] = item.count;
        });
    } else {
        console.error('Response không phải là một mảng:', response);
    }

    var countsArray = Object.keys(counts).map(function(day) {
    return [day, counts[day]];
    
});

var countsArray1 = Object.keys(counts).map(function(day) {
    return [day, counts1[day]];
    
});

// Sắp xếp mảng dựa trên ngày
countsArray.sort(function(a, b) {
    let dateA = new Date(a[0].split('/').reverse().join('-'));
    let dateB = new Date(b[0].split('/').reverse().join('-'));
    return dateA - dateB;
});

countsArray1.sort(function(a, b) {
    let dateA = new Date(a[0].split('/').reverse().join('-'));
    let dateB = new Date(b[0].split('/').reverse().join('-'));
    return dateA - dateB;
});

// In ra mỗi ngày và số lượng tương ứng
// countsArray.forEach(function(item) {
//     console.log(item[0] + ': ' + item[1]);
// });
countsArray1.forEach(function(item) {
    console.log(item[0] + ': ' + item[1]);
});
 data1 = countsArray.map(function(item) {
    return item[1];

});
data2 = countsArray.map(function(item) {
    return item[1];

});
// console.log("Tao du lieu cho bieu do 2");
     dataOrder = {
        labels: newLabels,
        datasets: [
        {
            label: 'Đơn hàng',
            data:  data1,
            backgroundColor: [
                'rgba(255, 26, 104, 0.2)'
            ],
            borderColor: [
                'rgba(255, 26, 104, 1)'
            ],
            borderWidth: 1,
            barPercentage: 0.9,
            categoryPercentage: 0.5
        }]
    };
    console.log(data1);
    console.log("Tao xong du lieu cho bieu do 2");
    var config2 = {
        data: dataOrder,
        type :'bar',
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '5%',
                    height: '5%'
                }
            },
            plugins: {
                legend: {
                    position: 'right',
                    align: 'start',
                }
            },
        }
    };
    serviceChart = new Chart(
        document.getElementById('orderChart'),
        config2
    );

    }
});
//    console.log("chay xong ajax");
   
    const chartVersion = document.getElementById('chartVersion');
    chartVersion.innerText = Chart.version;
    });

    $('#current-time-doanhthu').on('change', function() {
        console.log("Su kien thay doi ngay cua doanh thu");
        var data1;
        var data2;
        if (venueChart) {
        venueChart.destroy();
    }

    let newLabels = [];
   
    var selectedDateValue = $(this).val();
    console.log('Selected date: ' + selectedDateValue);
    let selectedDate = new Date(selectedDateValue);
    let day = selectedDate.getDay();
    let diffToMonday = selectedDate.getDate() - day + (day === 0 ? -6:1);
    let startOfWeek = new Date(selectedDate.setDate(diffToMonday));
    let endOfWeek = new Date(startOfWeek);
    endOfWeek.setDate(endOfWeek.getDate() + 6);
    let formattedStartOfWeek = startOfWeek.getFullYear() + '-' + String(startOfWeek.getMonth() + 1).padStart(2, '0') + '-' + String(startOfWeek.getDate()).padStart(2, '0');
    let formattedEndOfWeek = endOfWeek.getFullYear() + '-' + String(endOfWeek.getMonth() + 1).padStart(2, '0') + '-' + String(endOfWeek.getDate()).padStart(2, '0');

    // console.log('Start of week: ' + formattedStartOfWeek);
    // console.log('End of week: ' + formattedEndOfWeek); 
    let start = new Date(startOfWeek); // replace with your startOfWeek date
    let end = new Date(endOfWeek); // replace with your endOfWeek date
   
    for(let date = start; date <= end; date.setDate(date.getDate() + 1)) {
    let formattedDate = String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' + String(date.getFullYear()).slice(-2);
    //  console.log(formattedDate); // Print the date before pushing it
        newLabels.push(String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' + String(date.getFullYear()).slice(-2));
       
    }
    $.ajax({
       
    url: '/DoAn_PetcareHub/thong-ke-doanh-thu/' + formattedStartOfWeek + '/' + formattedEndOfWeek,
    method: 'GET',
    success: function(response) {
      console.log(response)
    var allDays1=newLabels;
    var counts1={};
   

    // Khởi tạo counts cho tất cả các ngày là 0
  
    allDays1.forEach(function(day) {
        counts1[day] = 0;
    });
    

    // Kiểm tra nếu response là một mảng trước khi cố gắng lặp qua nó

    if (Array.isArray(response.totalPerDay)) {
        // Điền counts với dữ liệu từ response
        response.totalPerDay.forEach(function(item) {
            let date = new Date(item.date);
        let formattedDate = String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' + String(date.getFullYear()).slice(-2);
        counts1[formattedDate] = item.total;
        });
    } else {
        console.error('Response không phải là một mảng:', response);
    }


var countsArray1 = Object.keys(counts1).map(function(day) {
    return [day, counts1[day]];
    
});

// Sắp xếp mảng dựa trên ngày
countsArray1.sort(function(a, b) {
    let dateA = new Date(a[0].split('/').reverse().join('-'));
    let dateB = new Date(b[0].split('/').reverse().join('-'));
    return dateA - dateB;
});

// In ra mỗi ngày và số lượng tương ứng
countsArray1.forEach(function(item) {
    console.log(item[0] + ': ' + item[1]);
});
 data1 = countsArray1.map(function(item) {
    return item[1];

});
data2 = countsArray1.map(function(item) {
    return item[1];

});
console.log("Tao du lieu cho bieu do 1");
const dataRevenue = {
        labels: newLabels ,
        datasets: [{
            label: 'Sản phẩm',
            data: data1,
            backgroundColor: [
                '#9bd5ff'
            ],
            borderColor: [
                '#003459'
            ],
            borderWidth: 1,
            barPercentage: 0.9,
            categoryPercentage: 0.5
        },]
    };
    console.log("Tao xong du lieu cho bieu do 1");
    const config1 = {
        type: 'bar',
        data: dataRevenue,
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '5%',
                    height: '5%'
                }
            },
            plugins: {
                legend: {
                    position: 'right',
                    align: 'start',
                }
            }
        }
    };
     venueChart = new Chart(
        document.getElementById('venueChart'),
        config1
    );
    const chartVersion = document.getElementById('chartVersion');
    chartVersion.innerText = Chart.version;

    }
});
   console.log("chay xong ajax cho doanh thu");
   
    });
$('#top').on('change', function() {
    let selectedMonth = document.getElementById("top").value;
    console.log("Selected month: " + selectedMonth);
    $.ajax({
       
       url: '/DoAn_PetcareHub/top',
       method: 'POST',
       data: {
              month: selectedMonth,
                    _token: $('meta[name="csrf-token"]').attr('content')
        },
       success: function(response) {
        console.log(response);
        for (let i = 1; i <= 5; i++) {
        if (response[i - 1]) {
            document.getElementById(`product-${i}`).innerHTML = response[i - 1].product_name;
            document.getElementById(`ratio-${i}`).innerHTML = response[i - 1].total;
        } else {
            document.getElementById(`product-${i}`).innerHTML = "";
            document.getElementById(`ratio-${i}`).innerHTML = "";
        }
    }
        
       }
    });
})
    document.getElementById('status').innerHTML= '<h3>Trang chủ</h3>'
</script>
@endsection

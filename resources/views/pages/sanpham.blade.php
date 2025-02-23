@extends('layout')
@section('content')
<link rel="stylesheet" href="{{asset('public/frontend/css/sanpham.css')}}">
    <div class="poster" style="margin-top: 1vw">
        <img src="{{asset('public/frontend/image/banner-gt.png')}}" alt="poster">
    </div>
    <div>
        <br>
        <br>
        <h3 style="color: #024c81;text-align: center;"> <b>SẢN PHẨM </b></h3>
    </div>
    <div id="container-body">
        <div id="filter-button" onclick="toggleFilter()"><i class="bi bi-funnel"></i></div>
        <div id="filter">

            <form action="{{URL::to('/loc-san-pham-'.$cate_id)}}" class="tieu_de_loc" method="POST" id="filterForm"> 
                {{ csrf_field() }}
                <b>Loại Sản phẩm</b><br> <br>
                @foreach($types as $typPro)
                    <input type="checkbox" name="typeProduct[]" value="{{$typPro->id}}" id="loai{{$typPro->id}}"
                    @if(in_array($typPro->id, old('typeProduct', $filterData['typeProduct'] ?? []))) checked @endif/>
                    <label for="loai{{$typPro->id}}">{{$typPro->name}} </label><br>  
                @endforeach
                <br>
                <b>Phân loại pet</b> <br> <br>
                    <input type="checkbox" name="pett[]" value="Chó"  id="cho"
                    @if(in_array('Chó', old('pett', $filterData['pett'] ?? []))) checked @endif />
                    <label for="cho">Chó</label><br />
                    <input type="checkbox" name="pett[]" value="Mèo" id="meo"
                    @if(in_array('Mèo', old('pett', $filterData['pett'] ?? []))) checked @endif/>
                    <label for="meo">Mèo
                </label><br> <br>

                <b>Giá</b><br>
                <td>
                    <input type="number" id="quanlity_tu" name="min_price" min="0" 
                        placeholder="Từ" value="{{ old('min_price', $filterData['min_price'] ?? '0') }}" oninput="validateMinMaxPrice()"/>
                </td>
                <td>
                    <input type="number" id="quanlity_den" name="max_price" placeholder="Đến" min="0"
                        step="1000" placeholder="Đến" value="{{ old('max_price', $filterData['max_price'] ?? '1000000') }}" oninput="validateMinMaxPrice()"/>
                </td><br><br> <br>
                <b>Sắp xếp theo</b><br />

                <input type="radio" id="sap_xep_theo_mac_dinh" name="sap_xep" value="Mặc định" 
                @if(old('sap_xep', $filterData['sap_xep'] ?? '') == 'Mặc định') checked @endif/>
                <label for="sap_xep_theo_mac_dinh">Mặc định</label><br />

                <input type="radio" id="sap_xep_theo_a_den_z" name="sap_xep" value="A đến Z" 
                @if(old('sap_xep', $filterData['sap_xep'] ?? '') == 'A đến Z') checked @endif/>
                <label for="sap_xep_theo_a_den_z">A<span>&#10230; </span>Z</label><br />

                <input type="radio" id="sap_xep_theo_z_den_a" name="sap_xep" value="Z đến A" 
                @if(old('sap_xep', $filterData['sap_xep'] ?? '') == 'Z đến A') checked @endif/>
                <label for="sap_xep_theo_z_den_a">Z<span>&#10230; </span>A</label><br />

                <input type="radio" id="sap_xep_theo_giam_dan" name="sap_xep" value="Giảm dần" 
                @if(old('sap_xep', $filterData['sap_xep'] ?? '') == 'Giảm dần') checked @endif/>
                <label for="sap_xep_theo_giam_dan">Giảm dần</label><br />

                <input type="radio" id="sap_xep_theo_tang_dan" name="sap_xep" value="Tăng dần" 
                @if(old('sap_xep', $filterData['sap_xep'] ?? '') == 'Tăng dần') checked @endif/>
                <label for="sap_xep_theo_tang_dan">Tăng dần</label><br><br> <br>

                <button id="loc" type="submit">Lọc</button>
            </form>
        </div>
        <!-------------------------------------------------------------------------sản phẩm-------------------------------------------------------------------->
        <div class="container-item">
            @foreach($pro as $prodata)
            <div class="item ">
                <a href="{{URL::to('/chi-tiet-san-pham-' . $prodata->id)}}" method="GET">
                    <div>
                        <img src="{{asset('public/storage/products/' . $prodata->image)}}" alt="{{$prodata->name}}">
                        <div class="text-truncate-container">
                            <p>{{$prodata->name}}</p>
                        </div>
                        <div class="pro-price">
                            @if ($prodata->min_price == $prodata->max_price)
                                {{ number_format($prodata->min_price, 0, '.', '.') }} VNĐ
                            @else
                                {{ number_format($prodata->min_price, 0, '.', '.') }} - {{ number_format($prodata->max_price, 0, '.', '.') }} VNĐ
                            @endif                        
                        </div>
                        <div style="display: flex;justify-content: space-between;">
                            <div style="display: flex;width:8em">
                                <p class="star-rating" style="color: #000;">{{ number_format($prodata->rating, 1)}}</p>
                                <p class="star-rating">
                                    @php
                                        // Làm tròn số với 1 chữ số thập phân
                                        $roundedRating = round($prodata->rating, 1);
                                        // Số sao đầy
                                        $fullStars = floor($roundedRating);
                                        // Kiểm tra nếu có sao nửa
                                        $halfStar = ($roundedRating - $fullStars) >= 0.5;
                                    @endphp

                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $fullStars)
                                            {{-- Đổ sao đầy --}}
                                            <i class="fas fa-star"></i>
                                        @elseif ($halfStar && $i == $fullStars + 1)
                                            {{-- Đổ sao nửa --}}
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            {{-- Đổ sao rỗng --}}
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </p>
                            </div>
                            Lượt bán:<p class="number-of-sales"> {{$prodata->number_of_sale}}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    <script>
        function validateMinMaxPrice() {
            var minPrice = parseFloat(document.getElementById("min_price").value);
            var maxPrice = parseFloat(document.getElementById("max_price").value);
    
            if (maxPrice < minPrice) {
                document.getElementById("max_price").value = minPrice;
            }
        }
        function toggleFilter() {
            const filter = document.getElementById('filter');
            filter.classList.toggle('show');
        }
    </script>
@endsection

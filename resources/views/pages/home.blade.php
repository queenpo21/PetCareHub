@extends('layout')
@section('content')
{{-- banner --}}
    <div id="slide-show" class="carousel slide" data-bs-ride="carousel" style="margin: 2vw 0;">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{('public/frontend/image/Pet Care Hub (1).png')}}" class="d-block w-100" alt="..."
                    style="border-radius: 10px">
            </div>
            <div class="carousel-item">
                <img src="{{('public/frontend/image/banner2.png')}}" class="d-block w-100" alt="..."
                    style="border-radius: 10px">
            </div>
            <div class="carousel-item">
                <img src="{{('public/frontend/image/slide-show-3.png')}}" class="d-block w-100" alt="..."
                    style="border-radius: 10px">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#slide-show" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#slide-show" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    {{-- mua sắm theo giống thú cưng --}}
    <p class="title">Mua sắm theo giống thú cưng</p>
    <div id="shopify-section">
        <div class="sub-section">
            <a href="#cho">
                <img src="{{('public/frontend/image/dog_banner.webp')}}" alt="dog">
            </a>
        </div>
        <div class="sub-section">
            <a href="meo">
                <img src="{{('public/frontend/image/cat_banner.webp')}}" alt="cat">
            </a>
        </div>

    </div>{{-- được boss yêu thích --}}
    <div id="best-seller">
            <p class="title">Được Boss yêu thích</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="carousel carousel-showmanymoveone slide" id="itemslider">
                            <div class="carousel-inner">
                                <div class="item active">
                                    @if(isset($first->id))
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="product">
                                            <a href="{{URL::to('/chi-tiet-san-pham-'.$first->id)}}">
                                                <div class="img-products">
                                                    <img src="public/storage/products/{{$first->image}}" alt="">
                                                </div>
                                                <div class="text-truncate-container">
                                                    <p>{{$first->name}}
                                                    </p>
                                                </div>
                                                <div class="pro-price">
                                                    @if ($first->min_price == $first->max_price)
                                                        {{ number_format($first->min_price, 0, '.', '.') }} VNĐ
                                                    @else
                                                        {{ number_format($first->min_price, 0, '.', '.') }} - {{ number_format($first->max_price, 0, '.', '.') }} VNĐ
                                                    @endif
                                                </div>
                                                <div class="sales">
                                                    Lượt bán: <p class="number-of-sales">{{ number_format($first->number_of_sale, 0, '.', '.') }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                @foreach($topSales as $top)
                                <div class="item">
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="product">
                                            <a href="{{URL::to('/chi-tiet-san-pham-'.$top->id)}}">
                                                <div class="img-products">
                                                    <img src="public/storage/products/{{$top->image}}" alt="">
                                                </div>
                                                <div class="text-truncate-container">
                                                    <p>{{$top->name}}</p>
                                                </div>
                                                <div class="pro-price">
                                                    @if ($top->min_price == $top->max_price)
                                                        {{ number_format($top->min_price, 0, '.', '.') }} VNĐ
                                                    @else
                                                        {{ number_format($top->min_price, 0, '.', '.') }} - {{ number_format($top->max_price, 0, '.', '.') }} VNĐ
                                                    @endif
                                                </div>
                                                <div class="sales">
                                                    Lượt bán: <p class="number-of-sales"> {{ number_format($top->number_of_sale, 0, '.', '.') }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            <!-- left,right control -->
                            <div id="slider-control">
                                <a class="left carousel-control" href="#itemslider" data-slide="prev"><i
                                        class="bi bi-chevron-left" style="color: black;"></i></a>
                                <a class="right carousel-control" href="#itemslider" data-slide="next"><i
                                        class="bi bi-chevron-right" style="color: black;margin-left: 1.5vw;"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="banner">
            <img src="{{('public/frontend/image/banner3.png')}}" alt="banner"
                style="border-radius: 10px;border: 10px solid #003459;width: 100%;">
        </div>
        <div id="new-products">
            <p class="title">Sản Phẩm Mới Nhất</p>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="carousel carousel-showmanymoveone slide" id="itemsliderx">
                            <div class="carousel-inner">
                                <div class="item active">
                                    @if(isset($second->id))
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="product">
                                            <a href="{{URL::to('/chi-tiet-san-pham-'.$second->id)}}">
                                                <div class="img-products">
                                                    <img src="public/storage/products/{{$second->image}}" alt="">
                                                </div>
                                                <div class="text-truncate-container">
                                                    <p>{{$second->name}}</p>
                                                </div>
                                                <div class="pro-price">
                                                    @if ($second->min_price == $second->max_price)
                                                        {{ number_format($second->min_price, 0, '.', '.') }} VNĐ
                                                    @else
                                                        {{ number_format($second->min_price, 0, '.', '.') }} - {{ number_format($second->max_price, 0, '.', '.') }} VNĐ
                                                    @endif
                                                </div>
                                                <div class="sales">
                                                    Lượt bán: <p class="number-of-sales"> {{ number_format($second->number_of_sale, 0, '.', '.') }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    @endif;
                                </div>
                                @foreach($newProducts as $new)
                                <div class="item">
                                    <div class="col-xs-6 col-sm-6 col-md-3">
                                        <div class="product">
                                            <a href="{{URL::to('/chi-tiet-san-pham-'.$new->id)}}">
                                                <div class="img-products">
                                                    <img src="public/storage/products/{{$new->image}}" alt="">
                                                </div>
                                                <div class="text-truncate-container">
                                                    <p>{{$new->name}}</p>
                                                </div>
                                                <div class="pro-price">
                                                    @if ($new->min_price == $new->max_price)
                                                    {{ number_format($new->min_price, 0, '.', '.') }} VNĐ
                                                @else
                                                    {{ number_format($new->min_price, 0, '.', '.') }} - {{ number_format($new->max_price, 0, '.', '.') }} VNĐ
                                                @endif
                                                </div>
                                                <div class="sales">
                                                    Lượt bán: <p class="number-of-sales"> {{ number_format($new->number_of_sale, 0, '.', '.') }} </p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <!-- left,right control -->
                            <div id="slider-control">
                                <a class="left carousel-control" href="#itemsliderx" data-slide="prev"><i
                                        class="bi bi-chevron-left" style="color: black;"></i></a>
                                <a class="right carousel-control" href="#itemsliderx" data-slide="next"><i
                                        class="bi bi-chevron-right" style="color: black;margin-left: 1.5vw;"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- địa chỉ --}}
    <div id="shop-address">
        <div class="title">
            <hr style="border: 1px solid black">
            <p>Mua Trực Tiếp Tại Cửa Hàng</p>
            <hr style="border: 1px solid black">
        </div>
        <div class="img-shop">
            <div class="sub-section">
                <img src="{{('public/frontend/image/img_shop1.webp')}}" alt="dog">
            </div>
            <div class="sub-section">
                <img src="{{('public/frontend/image/img_shop2.webp')}}" alt="cat">
            </div>
        </div>
        <div id="shop-address-detail">
            <h3>Pet Care Hub</h3>
            <p>Đường Hàn Thuyên, khu phố 6 P, Thủ Đức, Thành phố Hồ Chí Minh, Việt Nam.</p>
            <input type="submit" value="Chỉ Đường" onclick="ggmap()">
        </div>
        <div id="map">

        </div>
    </div>
    </div>
    <script>
        function ggmap() {
            document.getElementById('map').innerHTML = `<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d979.555835745229!2d106.80202446500843!3d10.870610263566327!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317527e7e8abb0eb%3A0xec43e4b99472c18a!2zVUlUIC0gQ-G7lW5nIEE!5e0!3m2!1svi!2s!4v1715435890137!5m2!1svi!2s" width="100%" height="450" style="border:0;margin-bottom: 5vw" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>`
        }
    </script>
    <script type="text/javascript">
        function myFunction(x) {
            if (x.matches) { // If media query matches
                $(document).ready(function () {
                    $('#itemslider').carousel({ interval: 3000 });
                    $('.carousel-showmanymoveone .item').each(function () {
                        var itemToClone = $(this);

                        for (var i = 1; i < 2; i++) {
                            itemToClone = itemToClone.next();

                            if (!itemToClone.length) {
                                itemToClone = $(this).siblings(':first');
                            }
                            itemToClone.children(':first-child').clone()
                                .addClass("cloneditem-" + (i))
                                .appendTo($(this));
                        }
                    });
                });
            } else {
                $(document).ready(function () {
                    $('#itemslider').carousel({ interval: 3000 });
                    $('.carousel-showmanymoveone .item').each(function () {
                        var itemToClone = $(this);

                        for (var i = 1; i < 4; i++) {
                            itemToClone = itemToClone.next();

                            if (!itemToClone.length) {
                                itemToClone = $(this).siblings(':first');
                            }
                            itemToClone.children(':first-child').clone()
                                .addClass("cloneditem-" + (i))
                                .appendTo($(this));
                        }
                    });
                });
            }
        }
        var x = window.matchMedia("(max-width: 900px)")

        // Call listener function at run time
        myFunction(x);

        // Attach listener function on state changes
        x.addEventListener("change", function () {
            myFunction(x);
        });
    </script>
@endsection
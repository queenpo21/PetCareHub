@extends('layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-123456789..." crossorigin="anonymous" />
<link rel="stylesheet" href="{{asset('public/frontend/css/detail.css')}}">
<link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.css" />
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/js/bootstrap.js" />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script src="data/data.js"></script>
    <script src="./js/slide.js"></script>
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <style>
      .star-icon {
          color: gold; /* Màu vàng */
          font-size: 24px; /* Kích thước icon */
      }
  </style>

<div class="price-detail-container" style="margin-top: 2vw">
    <div class="image-product-container">
        <img
          class="mySlides"
          src="{{asset('public/storage/products/' . $pro->image)}}" 
          alt="cho1"
          style="width: 100%"
        />
        @foreach($pro->galleries as $gallery)
          <img
          class="mySlides"
          src="{{ asset('public/storage/gallery/' . $gallery->image) }}" 
          alt="cho1"
          style="width: 100%; display: none"
          />
        @endforeach
      <div class="row-padding section">
        @foreach($pro->galleries as $gallery)
          <div class="col s4">
            <img
              class="demo opacity hover-opacity-off"
              src="{{ asset('public/storage/gallery/' . $gallery->image) }}" 
              style="width: 100%; cursor: pointer"
              onclick="currentDiv(1)"
            />
          </div>
        @endforeach
        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a class="next" onclick="plusSlides(1)">&#10095;</a>
      </div>
    </div>
    <div class="detail-product-container">
      <p class="name-product">{{$pro->name}}</p>
      <div class="evaluate" style="display: flex;">
        <div class="img-evaluate" style="display: flex;">
          {{ number_format($pro->rating, 1) }} <p class="star-rating1">
            @php
                // Làm tròn số với 1 chữ số thập phân
                $roundedRating = round($pro->rating, 1);
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
        <p class="text-evaluate">| {{$numRating}} đánh giá</p>
        <p class="text-evaluate">| Đã bán {{ $pro->number_of_sale}}</p>
      </div>
      <div class="price-container">
        <p class="text-price" id= "priceRange">
          @if ($pro->min_price == $pro->max_price)
              {{ number_format($pro->min_price, 0, '.', '.') }} VNĐ
          @else
              {{ number_format($pro->min_price, 0, '.', '.') }} - {{ number_format($pro->max_price, 0, '.', '.') }} VNĐ
          @endif   
        </p>
      </div>
      <div class="return-policy-container">
        <p class="text-return-policy">Chính Sách Trả Hàng:</p>
        <div class="box-date-infor">
          <i class="bi bi-box-seam"></i>
          <p class="text-return-policy-date">Trả hàng 15 ngày</p>
          <span class="span-infor" onmouseover="showInfo(event)"
            ><i class="bi bi-info-circle"></i
          ></span>
          <script src="./js/infor.js"></script>
        </div>
      </div>
      <form action="{{ route('addToCart', ['id' => $pro->id]) }}" method="POST" id="cartForm">
        {{ csrf_field() }}
      <div class="size-container">
        <p class="text-size">Phân loại:</p>
          <div class="size-box">
            @foreach($sizes as $sizeData)
              <input type="radio" class="btn-check" name="size" id="size{{$sizeData->id}}" data-price="{{$sizeData->price}}" value="{{$sizeData->size}}" autocomplete="off">
              <label class="btn btn-outline-primary " for="size{{$sizeData->id}}">{{$sizeData->size}}</label>
            @endforeach
          </div>
      </div>
      <div class="quantity-container">
        <p class="text-quantity">Số lượng:</p>
        <div class="quantity-box">
          <button type="button" class="quantity-button" onclick="decreaseQuantity()" style="border-radius: 10px 0 0 10px;">
            -
          </button>
          <input
            type="text"
            class="quantity-input"
            id="quantity"
            name= "quantity"
            value="1"
            style="width: 50px"
          />
          <button type="button" class="quantity-button" onclick="increaseQuantity()" style="border-radius: 0 10px 10px 0;">
            +
          </button>
        </div>
      </div>
      <div class="buy-cart-container">
        <div class="cart-container">
          <i class="bi bi-cart4"></i>
          <button type="button" class="cart-button" onclick="addToCart(event)" value="add_to_cart">Thêm vào giỏ hàng</button>
        </div>
        <div class="buy-container" style="margin-left: 1vw">
          <button  type="button" class="buy-button" onclick="buyNow(event)" name="action" value="buy_now" >Mua ngay</button>
        </div>
      </div>
    </form>
    <form id="checkout-form" action="{{ route('checkoutnow') }}" method="POST" hidden="true">
      {{csrf_field()}}
      <input name="selected_items" id="selected_items" value={{$pro->id}}>
      <button type="submit" name="pay" id="pay">Mua hàng</button>
    </form>
    </div>
  </div>
  <!----------------------------------- detail infor -------------------------------------------------------------------------->
  <div class="detail-infor-container">
    <p class="text-detail-in">Chi tiết sản phẩm</p>
    <p class="text-detail-in-size">{{ $pro->description }}</p>
  </div>
  <!-------------------------------------------------------- product reviews----------------------------------------------------------- -->
  <div class="product-reviews-container">
    <p class="text-detail-in">Đánh giá sản phẩm</p>
    <div class="list-start">
      <div>
        <div class="fiveUpfive">
          <p class="text-quantity-big">{{ number_format($pro->rating, 1) }}</p>
          <p class="text-quantity-small">trên 5 sao</p>
        </div>
        <div style="display: flex;">
        <p class="star-rating1">
            @php
                // Làm tròn số với 1 chữ số thập phân
                $roundedRating = round($pro->rating, 1);
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
      </div>
    </div>
    <div class="reviews-comment-container" >
      @forEach($feedback as $feed)
      <p>{{$feed->name}}</p>
      <div style="display: flex;">
        <p class="star-rating2">
            @php
                // Làm tròn số với 1 chữ số thập phân
                $roundedRating = round($feed->rating, 1);
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
      <div class="evaluate" style="display: flex;margin-left: 0vw;" >
        <p class="text-evaluate">Phân loại hàng: {{$feed->size}}</p>
      </div>
      <p>{{$feed->feedback}}</p>
      <br>
      @endforeach
    </div>
  </div>
  <!------------------------------------------------------ other products -------------------------------------------------------------------->
  <div class="container-item">
    @foreach( $relatedProducts as $relatedProductsData)
        <div class="item ">
          <a href="{{URL::to('/chi-tiet-san-pham-'.$relatedProductsData->id)}}" method="GET">
            <div>
                <img src="{{asset('public/storage/products/' . $relatedProductsData->image)}}" alt="">
                <div class="text-truncate-container">
                    <p>{{$relatedProductsData->name}}</p>
                </div>
            </div>
        <div class="pro-price">
          @if ($relatedProductsData->min_price == $relatedProductsData->max_price)
              {{ number_format($relatedProductsData->min_price, 0, '.', '.') }} VNĐ
          @else
              {{ number_format($relatedProductsData->min_price, 0, '.', '.') }} - {{ number_format($relatedProductsData->max_price, 0, '.', '.') }} VNĐ
          @endif  
        </div>
        <div style="display: flex;">
           <p style="display: flex; margin-left:0.5vw ;">{{ number_format($relatedProductsData->rating, 1) }}</p>
           <p class="star-rating1">
            @php
                // Làm tròn số với 1 chữ số thập phân
                $roundedRating = round($relatedProductsData->rating, 1);
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
           <span>Lượt bán: <p class="number-of-sales">{{ number_format($relatedProductsData->number_of_sale, 0) }}</p></span>
        </div>
      </a>
      </div>
    @endforeach
  </div>
<script>

    function increaseQuantity() {
      let input = document.getElementById("quantity");
      let value = parseInt(input.value);
      input.value = value + 1;
    }
    
    function decreaseQuantity() {
      let input = document.getElementById("quantity");
      let value = parseInt(input.value);
      if (value > 1) {
        input.value = value - 1;
      }
    }

    function showInfo(event) {
      const infoText =
        "Miên phí Trả hàng trong 15 ngày nếu Đổi ý (hàng trả phải còn nguyên seal, tem, hộp sản phẩm). Ngoài ra, tại thời điểm nhận hàng, bạn có thể đóng kiểm và được trả hàng miễn phí.";
      event.target.setAttribute("title", infoText);
    }
  </script>
  <script>
    let slideIndex = 1;
    showSlides(slideIndex);
  
    function plusSlides(n) {
      showSlides((slideIndex += n));
    }
  
    function currentDiv(n) {
      showDivs((slideIndex = n));
    }
  
    function showSlides(n) {
      let i;
      let slides = document.getElementsByClassName("mySlides");
      if (n > slides.length) {
        slideIndex = 1;
      }
      if (n < 1) {
        slideIndex = slides.length;
      }
      for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slides[slideIndex - 1].style.display = "block";
    }
  
    function showDivs(n) {
      var i;
      var x = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      if (n > x.length) {
        slideIndex = 1;
      }
      if (n < 1) {
        slideIndex = x.length;
      }
      for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace("opacity-off", "");
      }
      x[slideIndex - 1].style.display = "block";
      dots[slideIndex - 1].className += "opacity-off";
    }
  </script>
  <script>
    // Lắng nghe sự kiện khi người dùng chọn kích thước
    var sizeButtons = document.querySelectorAll('.btn-check');
    sizeButtons.forEach(function(button) {
        button.addEventListener('change', function() {
            var priceRange = document.getElementById('priceRange');
            var selectedSize = document.querySelector('input[name="size"]:checked');
            if (selectedSize) {
                var price = parseFloat(selectedSize.getAttribute('data-price'));
                priceRange.textContent = price.toLocaleString('vi-VN') + ' VNĐ';
            } else {
                priceRange.textContent = '';
            }
        });
    });

    function addToCart(event) {
      event.preventDefault();
      
      let form = document.getElementById('cartForm');
      let formData = new FormData(form);
      formData.append('cart_action', 'add_to_cart');
      
      let url = '{{ route("addToCart", ["id" => $pro->id]) }}';

      let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      fetch(url, {
          method: 'POST',
          body: formData,
          headers: {
              'X-Requested-With': 'XMLHttpRequest',
              'X-CSRF-TOKEN': csrfToken
          }
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              document.getElementById('cartCount').innerText = data.cartCount;
              alert(data.message);
          } else {
              alert('Có lỗi xảy ra, vui lòng thử lại.');
          }
      })
      .catch(error => {
          console.error('Error:', error);
    });
}
    function buyNow(event) {
      event.preventDefault();

      let form = document.getElementById('cartForm');
      let formData = new FormData(form);
      formData.append('cart_action', 'buy_now');

      let url = '{{ route("addToCart", ["id" => $pro->id]) }}';

      let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': csrfToken
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          document.getElementById('checkout-form').submit();
        } else {
          alert('Có lỗi xảy ra, vui lòng thử lại.');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
    }
</script>
  
@endsection


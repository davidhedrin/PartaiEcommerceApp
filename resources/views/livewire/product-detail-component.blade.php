<div>
  <style>
    .carous_img_product {
      height: 90px;
      object-fit: cover !important;
    }

    .fam_img_product {
      height: 150px;
      object-fit: cover !important;
    }

    @media only screen and (max-width: 600px) {
      .carous_img_product {
        width: 100%;
        height: 45px;
      }
    }
  </style>

  @if (Session::has('msgAlert'))
  <div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 show" role="alert" aria-live="assertive"
    aria-atomic="true" data-delay="2000" style="background-color: white !important;">
    <div class="toast-header">
      <img src="{{ asset('assets/img/logo.png') }}" class="rounded mr-2" alt="" width="50px">
      <div class="me-auto fw-semibold"></div>
      <small class="text-{{ strtolower(Session::get('msgStatus')) }}">{{ Session::get('msgStatus') }}</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      {{ Session::get('msgAlert') }}
    </div>
  </div>
  @endif

  <div class="row mt-3">
    <div class="col-lg-12">
      <div class="section-title from-blog__title">
        <h2>Detail Product</h2>
      </div>
    </div>
  </div>

  <div class="container mb-5">
    <div class="row">
      <div class="col-lg-6 col-md-6">
        <div class="product__details__pic">
          <div class="product__details__pic__item">
            <img class="product__details__pic__item--large"
              src="{{ asset('storage/'. colName('pr') . $product->image->image) }}" alt="{{ $product->name }}">
          </div>
          <div class="product__details__pic__slider owl-carousel">
            @if (count(json_decode($product->image->images, true)) > 0)
            <img class="carous_img_product"
              data-imgbigurl="{{ asset('storage/'. colName('pr') . $product->image->image) }}"
              src="{{ asset('storage/'. colName('pr') . $product->image->image) }}" alt="{{ $product->name }}">
            @endif
            @foreach (json_decode($product->image->images, true) as $img)
            <img class="carous_img_product"
              data-imgbigurl="{{ asset('storage/'. colName('pr') . $product->image->folder_name . '/' . $img) }}"
              src="{{ asset('storage/'. colName('pr') . $product->image->folder_name . '/' . $img) }}"
              alt="{{ $product->name }}">
            @endforeach
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <div class="product__details__text">
          <h3><strong>{{ $product->name }}</strong></h3>
          <div class="product__details__rating">
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-half-o"></i>
            <span>(18 reviews)</span>
          </div>
          <div class="product__details__price">{{ currency_IDR($product->regular_price) }} <small>/Kg</small></div>
          <p>{{ $product->short_desc }}.</p>
          <div class="product__details__quantity">
            <div class="quantity">
              <div class="pro-qty">
                <input type="text" value="1">
              </div>
            </div>
          </div>
          <a href="#" class="primary-btn">ADD TO CARD</a>
          <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
          <ul>
            <li><b>Availability</b> <span>In Stock</span></li>
            <li><b>Product</b> <span>{{ $product->product_for == "i" ? "Import" : "Export" }}</span></li>
            <li><b>Weight</b> <span>0.5 kg</span></li>
            <li><b>Share on</b>
              <div class="share">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
                <a href="#"><i class="fa fa-instagram"></i></a>
                <a href="#"><i class="fa fa-pinterest"></i></a>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="product__details__tab">
          <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" data-toggle="tab" href="#tabs-desc" role="tab"
                aria-selected="true">Description</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-toggle="tab" href="#tabs-review" role="tab" aria-selected="false">Reviews
                <span>(1)</span></a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tabs-desc" role="tabpanel">
              <div class="product__details__tab__desc">
                <h6>Products Description</h6>
                <p>{{ $product->description }}</p>
              </div>
            </div>
            <div class="tab-pane" id="tabs-review" role="tabpanel">
              <div class="product__details__tab__desc">
                <h6>Products Infomation</h6>
                <p>Vestibulum ac diam sit amet quam vehicula elementum sed sit amet dui.
                  Pellentesque in ipsum id orci porta dapibus. Proin eget tortor risus.
                  Vivamus suscipit tortor eget felis porttitor volutpat. Vestibulum ac diam
                  sit amet quam vehicula elementum sed sit amet dui. Donec rutrum congue leo
                  eget malesuada. Vivamus suscipit tortor eget felis porttitor volutpat.
                  Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Praesent
                  sapien massa, convallis a pellentesque nec, egestas non nisi. Vestibulum ac
                  diam sit amet quam vehicula elementum sed sit amet dui. Vestibulum ante
                  ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae;
                  Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit amet ligula.
                  Proin eget tortor risus.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-5">
    <div class="col-lg-12">
      <div class="section-title from-blog__title">
        <h2>Related Product</h2>
      </div>
    </div>
  </div>

  <div class="row mt-1 mb-5">
    <div class="categories__slider owl-carousel">
      @foreach ($randomProduct as $product)
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="product__item mb-0">
          <div class="product__item__pic2 set-bg" data-setbg="{{ asset('storage/'. colName('pr') . $product->image->image) }}"
            style="background-image: url(&quot;{{ asset('storage/'. colName('pr') . $product->image->image) }}&quot;);">
            <ul class="product__item__pic__hover">
              <li><a href="#"><i class="fa fa-heart"></i></a></li>
              <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
          </div>
          <div class="product__item__text">
            <h6><a href="{{ route('product.detail', ['product_id' => $product->id]) }}">{{ $product->name }}</a></h6>
            <h5>{{ currency_IDR($product->regular_price) }}</h5>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
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

      .product__details__pic__item img {
        min-width: 100%;
        height: 250px;
        object-fit: cover !important;
      }
    }
  </style>

  @include('livewire.component.toast-alert')

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
          <div class="product__details__pic__slider owl-carousel" wire:ignore>
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
                <a href="javascript:void(0)" class="dec qtybtn" wire:click.prevent='decreaseQty'>-</a>
                <input wire:model="quntity" type="text">
                <a href="javascript:void(0)" class="inc qtybtn" wire:click.prevent='increaseQty'>+</a>
              </div>
            </div>
          </div>
          @if ($product->stock_status)
            <a href="javascript:void(0)" wire:click.prevent="addProductToCart" class="primary-btn">ADD TO CART</a>
          @else
            <a href="javascript:void(0)" class="disabled-btn" style="cursor: not-allowed">ADD TO CART</a>
          @endif
          <a href="#" class="heart-icon"><span class="icon_heart_alt"></span></a>
          <ul>
            <li><b>Availability</b> <span class="text-{{ !!$product->stock_status ? " success" : "warning"
                }}"><strong>{{ !!$product->stock_status ? "In Stock" : "Out Stock" }}</strong></span></li>
            <li><b>Product</b> <span>{{ $product->product_for == "i" ? "Import" : "Export" }}</span></li>
            <li><b>Expired</b> <span style="font-style: {{ !$product->exp_date ? 'italic' : '' }}">{{ $product->exp_date
                ? formatDate("in", $product->exp_date) : "No Expired" }}</span></li>
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

  <div class="row mt-1 mb-5" wire:ignore>
    <div class="categories__slider owl-carousel">
      @foreach ($randomProduct as $product)
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="product__item mb-0">
          <div style="cursor: pointer"
            class="product__item__pic2 set-bg"
            data-setbg="{{ asset('storage/'. colName('pr') . $product->image->image) }}"
            style="background-image: url(&quot;{{ asset('storage/'. colName('pr') . $product->image->image) }}&quot;);">
            <ul class="product__item__pic__hover">
              <li><a href="#"><i class="fa fa-heart"></i></a></li>
              <li><a wire:click.prevent='addNewToCart({{ $product->id }})' href="javascript:void(0)"><i class="fa fa-shopping-cart"></i></a></li>
              <li><a href="{{ route('product.detail', ['product_id' => $product->id]) }}"><i class="fa fa-share"></i></a></li>
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
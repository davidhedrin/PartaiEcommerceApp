<div>
  <style>
    .latest-img{
      object-fit: cover;
      width: 100px !important;
      height: 100px !important;
    }
    
    .set-icon-whitelist {
      background: #17966b !important;
      background-color: #17966b !important;
      border: none !important;
    }
    .set-icon-whitelist i {
      color:white !important;
    }
  </style>

  @include('livewire.component.toast-alert')

  <section class="breadcrumb-section set-bg" data-setbg="{{ asset('banner/banner.png') }}">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="breadcrumb__text">
            <h2 class="text-dark">{{ env('APP_NAME') }} Shop</h2>
            <div class="breadcrumb__option">
              <span class="text-dark">Shop</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="row mt-5">
    <div wire:ignore class="col-lg-3 col-md-5">
      <div class="sidebar">
        <div class="sidebar__item">
          <h4>Type Product</h4>
          <div class="sidebar__item__size">
            <label for="import">
              Import
              <input type="radio" id="import">
            </label>
          </div>
          <div class="sidebar__item__size">
            <label for="export">
              Export
              <input type="radio" id="export">
            </label>
          </div>
        </div>
        <div class="sidebar__item">
          <h4>Department</h4>
          <ul>
            <li><a href="#">Fresh Meat</a></li>
            <li><a href="#">Vegetables</a></li>
            <li><a href="#">Fruit & Nut Gifts</a></li>
            <li><a href="#">Fresh Berries</a></li>
            <li><a href="#">Ocean Foods</a></li>
            <li><a href="#">Butter & Eggs</a></li>
            <li><a href="#">Fastfood</a></li>
            <li><a href="#">Fresh Onion</a></li>
            <li><a href="#">Papayaya & Crisps</a></li>
            <li><a href="#">Oatmeal</a></li>
          </ul>
        </div>
        <div class="sidebar__item">
          <h4>Price</h4>
          <div class="price-range-wrap">
            <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
              data-min="10" data-max="540">
              <div class="ui-slider-range ui-corner-all ui-widget-header"></div>
              <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
              <span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
            </div>
            <div class="range-slider">
              <div class="price-input">
                <input type="text" id="minamount">
                <input type="text" id="maxamount">
              </div>
            </div>
          </div>
        </div>
        <div class="sidebar__item">
          <div class="latest-product__text">
            <h4>Latest Products</h4>
            <div class="latest-product__slider owl-carousel">
              <div class="latest-prdouct__slider__item">
                @foreach ($ltsProd1 as $product)
                <a href="{{ route('product.detail', ['product_id' => $product->id]) }}" class="latest-product__item">
                  <div class="latest-product__item__pic">
                    <img src="{{ asset('storage/' . colName('pr') . $product->image->image) }}" class="latest-img" alt="">
                  </div>
                  <div class="latest-product__item__text">
                    <h6>{{ $product->name }}</h6>
                    <span>{{ currency_IDR($product->regular_price) }}</span>
                  </div>
                </a>
                @endforeach
              </div>
              <div class="latest-prdouct__slider__item">
                @foreach ($ltsProd2 as $product)
                <a href="{{ route('product.detail', ['product_id' => $product->id]) }}" class="latest-product__item">
                  <div class="latest-product__item__pic">
                    <img src="{{ asset('storage/' . colName('pr') . $product->image->image) }}" class="latest-img" alt="">
                  </div>
                  <div class="latest-product__item__text">
                    <h6>{{ $product->name }}</h6>
                    <span>{{ currency_IDR($product->regular_price) }}</span>
                  </div>
                </a>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-9 col-md-7">
      @if ($saleOffProducts->count() > 0)
      <div class="product__discount">
        <div class="section-title product__discount__title" style="margin-bottom: 40px">
          <h2>Sale Off</h2>
        </div>
        <div wire:ignore class="filter__item" style="border-top: none; padding-top: 0; padding-bottom: 20px">
          <div class="row">
            <div class="col-lg-4 col-md-5">
              <div class="filter__sort">
                <span>Sort By</span>
                <select>
                  <option value="">Default</option>
                  <option value="1">Name</option>
                  <option value="2">Price</option>
                </select>
              </div>
            </div>
            <div class="col-lg-4 col-md-4">
              <div class="filter__found">
                <h6><span>16</span> Products found</h6>
              </div>
            </div>
            <div class="col-lg-4 col-md-3">
              <div class="filter__option">
                <span class="icon_grid-2x2"></span>
                <span class="icon_ul"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-4">
          @foreach ($saleOffProducts as $product)
            <div class="col-lg-4 col-md-6 col-sm-6">
              <div class="product__discount__item">
                <div class="product__discount__item__pic set-bg"
                  data-setbg="{{ asset('storage/' . colName('pr') . $product->image->image) }}"
                  style="background-image: url('{{ asset('storage/' . colName('pr') . $product->image->image) }}')">
                  <div class="product__discount__percent">
                    -{{ round(($product->sale_price / $product->regular_price) * 100) }}%
                  </div>
                  <ul class="product__item__pic__hover">
                    <li><a class="{{ $product->whitelist ? "set-icon-whitelist" : "" }}" wire:click.prevent='addRemoveWhitelist({{ $product->id }}, {{ $product->whitelist != null ? $product->whitelist : 0 }})' href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
                    <li><a wire:click.prevent='addProductToCart({{ $product->id }})' href="javascript:void(0)"><i class="fa fa-shopping-cart"></i></a></li>
                    <li><a href="{{ route('product.detail', ['product_id' => $product->id]) }}"><i class="fa fa-share"></i></a></li>
                  </ul>
                </div>
                <div class="product__discount__item__text">
                  <span>{{ $product->product_for == "i" ? "Import" : "Export" }}</span>
                  <h5><a href="{{ route('product.detail', ['product_id' => $product->id]) }}">{{ $product->name }}</a></h5>
                  <div class="product__item__price">
                    {{ currency_IDR($product->regular_price-$product->sale_price) }}
                    <span>{{ currency_IDR($product->regular_price) }}</span>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div>
          {{ $saleOffProducts->links() }}
        </div>
      </div>
      @endif
      <div wire:ignore class="filter__item" style="padding-top: 25px;">
        <div class="section-title product__discount__title" style="margin-bottom: 40px">
          <h2>Products</h2>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-5">
            <div class="filter__sort">
              <span>Sort By</span>
              <select>
                <option value="">Default</option>
                <option value="1">Name</option>
                <option value="2">Price</option>
              </select>
            </div>
          </div>
          <div class="col-lg-4 col-md-4">
            <div class="filter__found">
              <h6><span>16</span> Products found</h6>
            </div>
          </div>
          <div class="col-lg-4 col-md-3">
            <div class="filter__option">
              <span class="icon_grid-2x2"></span>
              <span class="icon_ul"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        @foreach ($allProducts as $product)
          <div class="col-lg-4 col-md-6 col-sm-6 mb-5">
            <div class="product__discount__item">
              <div class="product__discount__item__pic set-bg" data-setbg="{{ asset('storage/' . colName('pr') . $product->image->image) }}" style="background-image: url('{{ asset('storage/' . colName('pr') . $product->image->image) }}');">
                @if ($product->sale_price)
                <div class="product__discount__percent">
                  -{{ round(($product->sale_price / $product->regular_price) * 100) }}%
                </div>
                @endif
                <ul class="product__item__pic__hover">
                  <li><a href="#"><i class="fa fa-heart"></i></a></li>
                  <li><a wire:click.prevent='addProductToCart({{ $product->id }})' href="javascript:void(0)"><i class="fa fa-shopping-cart"></i></a></li>
                  <li><a href="{{ route('product.detail', ['product_id' => $product->id]) }}"><i class="fa fa-share"></i></a></li>
                </ul>
              </div>
              <div class="product__discount__item__text">
                <span>{{ $product->product_for == "i" ? "Import" : "Export" }}</span>
                <h5><a href="{{ route('product.detail', ['product_id' => $product->id]) }}">{{ $product->name }}</a></h5>
                <div class="product__item__price">
                  @if ($product->sale_price)
                  {{ currency_IDR($product->regular_price-$product->sale_price) }}
                  <span>{{ currency_IDR($product->regular_price) }}</span>
                  @else
                  {{ currency_IDR($product->regular_price) }}
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div>
        {{ $allProducts->links() }}
      </div>
    </div>
  </div>
</div>
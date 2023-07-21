<div>
  <style>
    .latest-img{
      object-fit: cover;
      width: 100px !important;
      height: 100px !important;
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
      <div wire:ignore class="product__discount">
        <div class="section-title product__discount__title">
          <h2>Sale Off</h2>
        </div>
        <div class="row">
          <div class="product__discount__slider owl-carousel">
            <div class="col-lg-4">
              <div class="product__discount__item">
                <div class="product__discount__item__pic set-bg"
                  data-setbg="{{ asset('assets/img/product/discount/pd-1.jpg') }}">
                  <div class="product__discount__percent">-20%</div>
                  <ul class="product__item__pic__hover">
                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                  </ul>
                </div>
                <div class="product__discount__item__text">
                  <span>Dried Fruit</span>
                  <h5><a href="#">Raisin’n’nuts</a></h5>
                  <div class="product__item__price">$30.00 <span>$36.00</span></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="product__discount__item">
                <div class="product__discount__item__pic set-bg"
                  data-setbg="{{ asset('assets/img/product/discount/pd-2.jpg') }}">
                  <div class="product__discount__percent">-20%</div>
                  <ul class="product__item__pic__hover">
                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                  </ul>
                </div>
                <div class="product__discount__item__text">
                  <span>Vegetables</span>
                  <h5><a href="#">Vegetables’package</a></h5>
                  <div class="product__item__price">$30.00 <span>$36.00</span></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="product__discount__item">
                <div class="product__discount__item__pic set-bg"
                  data-setbg="{{ asset('assets/img/product/discount/pd-3.jpg') }}">
                  <div class="product__discount__percent">-20%</div>
                  <ul class="product__item__pic__hover">
                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                  </ul>
                </div>
                <div class="product__discount__item__text">
                  <span>Dried Fruit</span>
                  <h5><a href="#">Mixed Fruitss</a></h5>
                  <div class="product__item__price">$30.00 <span>$36.00</span></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="product__discount__item">
                <div class="product__discount__item__pic set-bg"
                  data-setbg="{{ asset('assets/img/product/discount/pd-4.jpg') }}">
                  <div class="product__discount__percent">-20%</div>
                  <ul class="product__item__pic__hover">
                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                  </ul>
                </div>
                <div class="product__discount__item__text">
                  <span>Dried Fruit</span>
                  <h5><a href="#">Raisin’n’nuts</a></h5>
                  <div class="product__item__price">$30.00 <span>$36.00</span></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="product__discount__item">
                <div class="product__discount__item__pic set-bg"
                  data-setbg="{{ asset('assets/img/product/discount/pd-5.jpg') }}">
                  <div class="product__discount__percent">-20%</div>
                  <ul class="product__item__pic__hover">
                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                  </ul>
                </div>
                <div class="product__discount__item__text">
                  <span>Dried Fruit</span>
                  <h5><a href="#">Raisin’n’nuts</a></h5>
                  <div class="product__item__price">$30.00 <span>$36.00</span></div>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="product__discount__item">
                <div class="product__discount__item__pic set-bg"
                  data-setbg="{{ asset('assets/img/product/discount/pd-6.jpg') }}">
                  <div class="product__discount__percent">-20%</div>
                  <ul class="product__item__pic__hover">
                    <li><a href="#"><i class="fa fa-heart"></i></a></li>
                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                  </ul>
                </div>
                <div class="product__discount__item__text">
                  <span>Dried Fruit</span>
                  <h5><a href="#">Raisin’n’nuts</a></h5>
                  <div class="product__item__price">$30.00 <span>$36.00</span></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div wire:ignore class="filter__item">
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
                <ul class="product__item__pic__hover">
                  <li><a href="#"><i class="fa fa-heart"></i></a></li>
                  <li><a wire:click.prevent='addProductToCart({{ $product->id }})' href="javascript:void(0)"><i class="fa fa-shopping-cart"></i></a></li>
                  <li><a href="{{ route('product.detail', ['product_id' => $product->id]) }}"><i class="fa fa-share"></i></a></li>
                </ul>
              </div>
              <div class="product__discount__item__text">
                <span>{{ $product->product_for == "i" ? "Import" : "Export" }}</span>
                <h5><a href="{{ route('product.detail', ['product_id' => $product->id]) }}">{{ $product->name }}</a></h5>
                <div class="product__item__price">{{ currency_IDR($product->regular_price) }}</div>
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
<div>
  <style>
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

  <div wire:ignore class="hero__item__right set-bg" data-setbg="{{ asset('banner/banner.png') }}">
    <div class="hero__text">
      <span>Welcome To</span>
      <h2>JAKARTA TRADING</h2>
      <p>Good Price, Good Quality, and Good Service</p>
      <a href="#" class="primary-btn">SHOP NOW</a>
    </div>
  </div>

  {{-- Import section --}}
  <div class="row mt-5">
    <div class="col-lg-12">
      <div class="section-title from-blog__title">
        <h2>Featured Import</h2>
      </div>
    </div>
  </div>
  {{-- Slider product --}}
  @if (count($allProductImport) > 0)
  <div wire:ignore class="row pb-4">
    <div class="categories__slider owl-carousel">
      @foreach ($allProductImport as $product)
      <div class="col-lg-3">
        <div class="categories__item set-bg" data-setbg="{{ asset('storage/'. colName('pr') . $product->image->image) }}">
          <h5><a href="{{ route('product.detail', ['product_id' =>$product->id]) }}">{{ $product->name }}</a></h5>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  <div class="text-center pb-2">
    <a href="#" class="primary-btn">MORE</a>
  </div>
  @endif

  @if (count($allProductExport) > 0)
  {{-- Future Product --}}
  <div class="row mt-5">
    <div class="col-lg-12">
      <div class="section-title">
        <h2>Featured Export</h2>
      </div>
      <div class="featured__controls">
        <ul>
          <li class="active" data-filter="*">All</li>
          <li data-filter=".oranges">Oranges</li>
          <li data-filter=".fresh-meat">Fresh Meat</li>
          <li data-filter=".vegetables">Vegetables</li>
          <li data-filter=".fastfood">Fastfood</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="row featured__filter" style="justify-content: center">
    @foreach ($allProductExport as $product)
    <div class="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
      <div class="featured__item">
        <div style="background-image: url({{ asset('storage/'. colName('pr') . $product->image->image) }});" class="featured__item__pic set-bg" data-setbg="{{ asset('storage/'. colName('pr') . $product->image->image) }}">
          <ul class="featured__item__pic__hover">
            <li><a class="{{ $product->whitelist ? "set-icon-whitelist" : "" }}" wire:click.prevent='addRemoveWhitelist({{ $product->id }}, {{ $product->whitelist != null ? $product->whitelist : 0 }})' href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
            <li><a wire:click.prevent='addProductToCart({{ $product->id }})' href="javascript:vodi(0)"><i class="fa fa-shopping-cart"></i></a></li>
            <li><a href="{{ route('product.detail', ['product_id' =>$product->id]) }}"><i class="fa fa-share"></i></a></li>
          </ul>
        </div>
        <div class="featured__item__text">
          <h6><a href="{{ route('product.detail', ['product_id' =>$product->id]) }}">{{ $product->name }}</a></h6>
          <h5>{{ currency_IDR($product->regular_price) }}</h5>
        </div>
      </div>
    </div>
    @endforeach
  </div>
  <div style="display: grid; justify-content: center">
    {{ $allProductExport->links() }}
  </div>
  @endif

  {{-- Two Banner --}}
  <div class="row mt-5">
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="banner__pic">
        <img src="{{ asset('assets/img/banner/banner-1.jpg') }}" alt="">
      </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="banner__pic">
        <img src="{{ asset('assets/img/banner/banner-2.jpg') }}" alt="">
      </div>
    </div>
  </div>

  {{-- Latest and other --}}
  <div class="row mt-5">
    <div class="col-lg-4 col-md-6">
      <div class="latest-product__text">
        <h4>Latest Products</h4>
        <div class="latest-product__slider owl-carousel">
          <div class="latest-prdouct__slider__item">
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-1.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-2.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-3.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
          </div>
          <div class="latest-prdouct__slider__item">
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-1.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-2.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-3.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="latest-product__text">
        <h4>Top Rated Products</h4>
        <div class="latest-product__slider owl-carousel">
          <div class="latest-prdouct__slider__item">
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-1.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-2.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-3.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
          </div>
          <div class="latest-prdouct__slider__item">
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-1.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-2.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-3.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="latest-product__text">
        <h4>Review Products</h4>
        <div class="latest-product__slider owl-carousel">
          <div class="latest-prdouct__slider__item">
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-1.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-2.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-3.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
          </div>
          <div class="latest-prdouct__slider__item">
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-1.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-2.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
            <a href="#" class="latest-product__item">
              <div class="latest-product__item__pic">
                <img src="{{ asset('assets/img/latest-product/lp-3.jpg') }}" alt="">
              </div>
              <div class="latest-product__item__text">
                <h6>Crab Pool Security</h6>
                <span>$30.00</span>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Blog section --}}
  <div class="row mt-5">
    <div class="col-lg-12">
      <div class="section-title from-blog__title">
        <h2>From The Blog</h2>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="categories__slider owl-carousel">
      <div class="col-lg-3">
        <div class="blog__item">
          <div class="blog__item__pic">
            <img src="{{ asset('assets/img/blog/blog-1.jpg') }}" alt="">
          </div>
          <div class="blog__item__text">
            <ul>
              <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
              <li><i class="fa fa-comment-o"></i> 5</li>
            </ul>
            <h5><a href="#">Cooking tips make cooking simple</a></h5>
            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="blog__item">
          <div class="blog__item__pic">
            <img src="{{ asset('assets/img/blog/blog-2.jpg') }}" alt="">
          </div>
          <div class="blog__item__text">
            <ul>
              <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
              <li><i class="fa fa-comment-o"></i> 5</li>
            </ul>
            <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="blog__item">
          <div class="blog__item__pic">
            <img src="{{ asset('assets/img/blog/blog-3.jpg') }}" alt="">
          </div>
          <div class="blog__item__text">
            <ul>
              <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
              <li><i class="fa fa-comment-o"></i> 5</li>
            </ul>
            <h5><a href="#">Visit the clean farm in the US</a></h5>
            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="blog__item">
          <div class="blog__item__pic">
            <img src="{{ asset('assets/img/blog/blog-3.jpg') }}" alt="">
          </div>
          <div class="blog__item__text">
            <ul>
              <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
              <li><i class="fa fa-comment-o"></i> 5</li>
            </ul>
            <h5><a href="#">Visit the clean farm in the US</a></h5>
            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="blog__item">
          <div class="blog__item__pic">
            <img src="{{ asset('assets/img/blog/blog-2.jpg') }}" alt="">
          </div>
          <div class="blog__item__text">
            <ul>
              <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
              <li><i class="fa fa-comment-o"></i> 5</li>
            </ul>
            <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
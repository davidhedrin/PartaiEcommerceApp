<div>
  <style>
    .image-product {
      width: 80px;
      height: 80px;
      object-fit: cover;
    }

    .set-icon-whitelist {
      background: #17966b !important;
      background-color: #17966b !important;
      border: none !important;
    }
    .set-icon-whitelist i {
      color:white !important;
    }

    @media only screen and (max-width: 600px) {
      .image-product {
        width: 60px;
        height: 60px;
        object-fit: cover;
      }
    }
  </style>

  @include('livewire.component.toast-alert')

  <section class="breadcrumb-section set-bg mb-3">{{-- data-setbg="{{ asset('banner/banner.png') }}" --}}
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="breadcrumb__text">
            <h2 class="text-dark">Your Whitelist <i class="fa fa-heart"></i></h2>
            <a href="{{ route('shop') }}" class="text-dark" style="text-decoration: underline">Continue Shopping &rarr;</a>
            {{-- <div class="shoping__cart__btns">
              <a href="{{ route('shop') }}" class="primary-btn">CONTINUE SHOPPING</a>
            </div> --}}
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <div class="container">
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
            <h6><span>{{ $totalWhitelist }}</span> Products found</h6>
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
    <div class="row d-flex justify-content-center">
      @forelse ($allProducts as $product)
        <div class="col-lg-3 col-md-6 col-sm-6 mb-5">
          <div class="product__discount__item">
            <div class="product__discount__item__pic set-bg" data-setbg="{{ asset('storage/' . colName('pr') . $product->product->image->image) }}" style="background-image: url('{{ asset('storage/' . colName('pr') . $product->product->image->image) }}');">
              <ul class="product__item__pic__hover">
                <li><a wire:click.prevent='removeWhitelist({{ $product->product_id }})' href="javascript:void(0)" class="set-icon-whitelist"><i class="fa fa-heart"></i></a></li>
                <li><a wire:click.prevent='addProductToCart({{ $product->product_id }})' href="javascript:void(0)"><i class="fa fa-shopping-cart"></i></a></li>
                <li><a href="{{ route('product.detail', ['product_id' => $product->product_id]) }}"><i class="fa fa-share"></i></a></li>
              </ul>
            </div>
            <div class="product__discount__item__text">
              <span>{{ $product->product->product_for == "i" ? "Import" : "Export" }}</span>
              <h5><a href="{{ route('product.detail', ['product_id' => $product->product_id]) }}">{{ $product->product->name }}</a></h5>
              <div class="product__item__price">{{ currency_IDR($product->product->regular_price) }}</div>
            </div>
          </div>
        </div>
      @empty
        <p style="font-style: italic">No Product In Whitelist</p>
      @endforelse
    </div>
  </div>

  <hr>
  
  <div class="row mt-5">
    <div class="col-lg-12">
      <div class="section-title from-blog__title">
        <h2>Recomendation Product</h2>
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
              <li><a wire:click.prevent='addToWhitelist({{ $product->id }})' href="javascript:void(0)"><i class="fa fa-heart"></i></a></li>
              <li><a wire:click.prevent='addProductToCart({{ $product->id }})' href="javascript:void(0)"><i class="fa fa-shopping-cart"></i></a></li>
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
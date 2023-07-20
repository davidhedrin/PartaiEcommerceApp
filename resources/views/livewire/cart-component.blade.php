<div>
  <style>
    .image-product{
      width: 80px;
      height: 80px;
      object-fit: cover;
    }

    @media only screen and (max-width: 600px) {
      .image-product{
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
            <h2 class="text-dark">Your Cart <i class="fa fa-shopping-bag"></i></h2>
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
    <div class="row">
      <div class="col-lg-12">
        <div class="shoping__cart__table">
          <table>
            <thead>
              <tr>
                <th class="shoping__product">Products</th>
                <th>Price</th>
                <th>Quantity/Kg</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @php
                  $totalPrice = 0;
              @endphp
              @forelse ($products as $item)
                <tr>
                  <td class="shoping__cart__item">
                    <a href="{{ route('product.detail', ['product_id' => $item->product->id]) }}">
                      <img src="{{ asset('storage/' . colName('pr') . $item->product->image->image) }}" alt="" class="image-product">
                      <span style="color: black">{{ $item->product->name }}</span>
                    </a>
                  </td>
                  <td>
                    {{ currency_IDR($item->product->regular_price) }}
                  </td>
                  <td class="shoping__cart__quantity">
                    <div class="quantity">
                      <div class="pro-qty">
                        <a wire:click='decreaseQty({{ $item->id }}, {{ $item->qty }})' href="javascript:void(0)" class="dec qtybtn">-</a>
                        <input type="text" value="{{ $item->qty }}">
                        <a wire:click='increaseQty({{ $item->id }}, {{ $item->qty }})' href="javascript:void(0)" class="inc qtybtn">+</a>
                      </div>
                    </div>
                  </td>
                  <td>
                    {{ currency_IDR($item->product->regular_price * $item->qty) }}
                  </td>
                  <td class="shoping__cart__item__close">
                    <span wire:click='deleteProductCart({{ $item->id }})' class="icon_close"></span>
                  </td>
                </tr>
                @php
                    $totalPrice += $item->product->regular_price * $item->qty;
                @endphp
              @empty
                <tr>
                  <td colspan="4" class="text-center">
                    No Product In Cart
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-6">
        <div class="shoping__continue">
          <div class="shoping__discount mt-0">
            <h5 class="mb-2">Discount Codes: </h5>
            <form action="#">
              <input type="text" placeholder="Enter your coupon code">
              <button type="submit" class="site-btn">APPLY COUPON</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="shoping__checkout">
          <h5>Cart Total</h5>
          <ul>
            <li class="none">Subtotal <span>{{ currency_IDR($totalPrice) }}</span></li>
            <li class="need">PPN 5&#37; <span>{{ currency_IDR($totalPrice * 0.05) }}</span></li>
            <li class="need">Total <span class="text-danger">{{ currency_IDR($totalPrice + $totalPrice * 0.05) }}</span></li>
          </ul>
          @if ($products->count() > 0)
            <a href="javascript:void(0)" class="primary-btn">PROCEED TO CHECKOUT</a>
          @else
            <a href="javascript:void(0)" class="primary-btn" style="background: grey; cursor: not-allowed">PROCEED TO CHECKOUT</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
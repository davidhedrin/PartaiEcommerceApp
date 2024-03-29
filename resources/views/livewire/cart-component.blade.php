<div>
  <style>
    .image-product{
      width: 80px;
      height: 80px;
      object-fit: cover;
    }
    
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"] {
        -webkit-appearance: none;
        margin: 0;
    }

    .delete-voucher{
      color: grey;
      cursor: pointer;
    }
    .delete-voucher:hover{
      color: red;
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
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($products as $item)
                <tr>
                  <td class="shoping__cart__item">
                    <a href="{{ route('product.detail', ['product_id' => $item->product->id]) }}">
                      <img src="{{ asset('storage/' . colName('pr') . $item->product->image->image) }}" alt="" class="image-product">
                      <span style="color: black">
                        {{ $item->product->name }}
                        @if ($item->product->sale_price)
                        <span class="badge badge-pill badge-danger" style="font-size: small">
                          -{{ round(($item->product->sale_price / $item->product->regular_price) * 100) }}%
                        </span>
                        @endif
                      </span>
                    </a>
                  </td>
                  <td>
                    @if ($item->product->sale_price)
                    <s style="font-size: small;">{{ currency_IDR($item->product->regular_price) }}</s><br/>
                    {{ currency_IDR($item->product->regular_price-$item->product->sale_price) }}
                    @else
                    {{ currency_IDR($item->product->regular_price) }}
                    @endif
                  </td>
                  <td class="shoping__cart__quantity">
                    <div class="quantity">
                      <div class="pro-qty">
                        <a wire:click='decreaseQty({{ $item->id }}, {{ $item->qty }})' href="javascript:void(0)" class="dec qtybtn">-</a>
                        <input wire:change='changeQtyManual({{ $item->id }}, $event.target.value)' wire:keyup='changeQtyManual({{ $item->id }}, $event.target.value)' type="number" value="{{ $item->qty }}" onchange="return preventEmptyInput(event)">
                        <a wire:click='increaseQty({{ $item->id }}, {{ $item->qty }})' href="javascript:void(0)" class="inc qtybtn">+</a>
                      </div>
                    </div>
                  </td>
                  <td>
                    {{ currency_IDR(($item->product->regular_price-$item->product->sale_price) * $item->qty) }}
                  </td>
                  <td class="shoping__cart__item__close">
                    <span wire:click='deleteProductCart({{ $item->id }})' class="icon_close"></span>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="text-center">
                    <span style="font-style: italic">No Product In Cart</span>
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
            <h5 class="mb-2">Voucher Codes: </h5>
            <form>
              <input wire:model="inputCouponCode" type="text" placeholder="Enter your coupon code">
              <button wire:click="applayCouponCode" type="button" class="site-btn" style="background: #31708F">APPLY COUPON</button>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="shoping__checkout">
          <h5>Cart Total</h5>
          <ul>
            <li class="none">Subtotal <span>{{ currency_IDR($subTotalPriveAll) }}</span></li>
            @if ($voucherCode)
              <li class="none">Voucher :</li>
              <li class="none">"{{ $voucherCode }}" <i class="fa fa-times delete-voucher" aria-hidden="true" wire:click="deleteCodeVocuher"></i> <span>- {{ currency_IDR($voucherVal) }}</span></li>
            @endif
            <li class="need">PPN 5&#37; <span>{{ currency_IDR($ppn) }}</span></li>
            <li class="need">Total <span class="text-danger">{{ currency_IDR($totalPriceToCheckout) }}</span></li>
          </ul>
          @if ($products->count() > 0)
            <a href="{{ route('checkout-cart', ["voucher" => $voucherCode]) }}" class="primary-btn">PROCEED TO CHECKOUT</a>
          @else
            <a href="javascript:void(0)" class="primary-btn" style="background: grey; cursor: not-allowed">PROCEED TO CHECKOUT</a>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  function preventEmptyInput(event) {
    const inputElement = event.target;
    const currentValue = inputElement.value;

    if (currentValue.length === 0) {
      inputElement.value = 1;
    }
  }
</script>
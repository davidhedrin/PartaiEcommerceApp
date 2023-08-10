<div>
  @include('livewire.component.toast-alert')

  <div class="checkout mt-4">
    <div class="container">
      <div class="row mb-4">
        <div class="col-lg-12">
          <h6>
            <div class="breadcrumb__text">
              <h2 class="text-dark">Checkout <i class="fa fa-shopping-cart"></i></h2>
              <a href="{{ route('shoping-cart') }}" class="text-dark" style="text-decoration: underline">&larr; back to cart</a>
            </div>
          </h6>
        </div>
      </div>
      <div class="checkout__form">
        <h4>Billing Details</h4>
        <div class="row">
          <div class="col-lg-7">
            <div class="hero__categories mb-3" id="select_billing">
              <div class="hero__categories__all" id="select_all_billing" style="background: #f5f5f5">
                <i class="fa fa-bars text-dark"></i>
                <span class="text-dark">Arrival</span>
              </div>
              <ul class="billing">
                <li>
                  <a href="#" class="d-flex align-items-center justify-content-between">
                    <div>
                      <strong>David Hendrin Simbolon</strong>
                      <p style="line-height: 0">0821-1086-3133</p>
                      <p style="margin-top: 20px; line-height: 18px">Perumahan alamanda 2, Blok EF RT.003/RW.006, Mustika jaya, Bekasi Timur, Jawa Barat, Indonesia, 13170.</p>
                    </div>
                    <div>
                      <i class="fa fa-check"></i>
                    </div>
                  </a>
                </li>
                <li style="background: lightgray">
                  <a href="{{ route('account-setting', ["activeId" => 3]) }}" class="text-center"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add More Address</a>
                </li>
              </ul>
            </div>

            <div class="checkout__input">
              <p class="mb-2">Order notes: </p>
              <input type="text" placeholder="Notes about your order, e.g. special notes for delivery.">
            </div>
          </div>
          <div class="col-lg-5">
            <div class="checkout__order">
              <h4>Your Order</h4>
              <div class="checkout__order__products">Products <span>Total</span></div>
              <ul>
                @forelse ($products as $item)
                  <li>{{ $item->product->name }} x {{ $item->qty }} <span>{{ currency_IDR(($item->product->regular_price-$item->product->sale_price) * $item->qty) }}</span></li>
                @empty
                  <li>No product to checkout</li>
                @endforelse
              </ul>
              <div class="checkout__order__subtotal">Subtotal <span>{{ currency_IDR($subTotalPriveAll) }}</span></div>
              @if ($voucherCode)
                <strong style="font-size: 18px;">"{{ $voucherCode }}"<span style="float: right">- {{ currency_IDR($voucherVal) }}</span></strong>
              @endif
              <div class="checkout__order__ppn">PPN 5% <span>{{ currency_IDR($ppn) }}</span></div>
              <div class="checkout__order__total">Total <span>{{ currency_IDR($totalPriceToCheckout) }}</span></div>
              
              <strong style="font-size: 18px">Payment Method</strong>
              <p>Select your payment method.</p>
              <div class="checkout__input__checkbox">
                <label for="payment">
                  Check Payment
                  <input type="checkbox" id="payment">
                  <span class="checkmark"></span>
                </label>
              </div>
              <div class="checkout__input__checkbox">
                <label for="paypal">
                  Paypal
                  <input type="checkbox" id="paypal">
                  <span class="checkmark"></span>
                </label>
              </div>
              <button type="submit" class="site-btn">PLACE ORDER</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
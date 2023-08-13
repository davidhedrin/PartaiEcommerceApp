<div>
  <style>
    .img-icon-po{
      height: 20px;
      object-fit: cover;
    }
  </style>

  @include('livewire.component.toast-alert')

  <div class="checkout mt-4">
    <div class="container">
      <div class="row mb-4">
        <div class="col-lg-12">
          <h6>
            <div class="breadcrumb__text">
              <h2 class="text-dark">Checkout <i class="fa fa-shopping-cart"></i></h2>
              <a href="{{ route('shoping-cart') }}" class="text-dark" style="text-decoration: underline">&larr; back to
                cart</a>
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
                <span class="text-dark">Select Arrival</span>
              </div>
              <ul class="billing">
                @forelse ($allAddress as $address)
                <li class="pb-0" style="background: {{ $address->id == $activeIdAddress ? " #00784f1c" : "" }}">
                  <a wire:click="$set('activeIdAddress', {{ $address->id }})" href="javascript:void(0)"
                    class="d-flex align-items-center justify-content-between">
                    <div>
                      <strong>
                        {{ $address->name }}
                        @if ($address->mark_as)
                        <span class="badge badge-secondary ml-1">
                          {{ $address->mark_as == "h" ? "Home" : "Office" }}
                        </span>
                        @endif
                      </strong>
                      <p style="line-height: 0">{{ $address->contact }}</p>
                      <p style="margin-top: 15px; line-height: 18px">
                        {{ $address->address }} {{ $address->city }}, {{ $address->country }}, {{ $address->post_code
                        }}.
                      </p>
                    </div>
                    <div>
                      @if ($address->id == $activeIdAddress)
                      <i class="fa fa-check"></i>
                      @endif
                    </div>
                  </a>
                </li>
                @empty
                <li class="d-flex align-items-center justify-content-center">
                  <div class="text-center py-2 mt-4">
                    <i class="fa fa-address-card-o" aria-hidden="true" style="font-size: 40px;"></i>
                    <p><em>Address is empty, No address has been registered yet.</em></p>
                  </div>
                </li>
                @endforelse

                <li style="background: lightgray">
                  <a href="{{ route('account-setting', ["activeId"=> 3]) }}" class="text-center"><i
                      class="fa fa-plus-circle" aria-hidden="true"></i> Add More Address</a>
                </li>
              </ul>

              @error('activeIdAddress')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="checkout__input pt-2">
              <p class="mb-2">Payment Method: </p>
              <select wire:model="select_payment_medhod" class="form-control">
                <option value="">Select Payment Method</option>
                <option value="1">Transfer VA (Indonesia)</option>
                @if ($po_creditCard)
                <option value="{{ $po_creditCard->id }}">{{ $po_creditCard->name }}</option>
                @endif
              </select>
              @error('select_payment_medhod')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div>
              <div class="row">
                @if ($select_payment_medhod == "1")
                @foreach ($allPayment1 as $paymet)
                <div class="col-md-6">
                  <div class="checkout__input__checkbox">
                    <label for="{{ $paymet->code }}">
                      <img src="{{ asset('po-img/' . $paymet->img) }}" class="img-icon-po" alt="{{ $paymet->code }}">
                      <input wire:model="selected_va" type="radio" id="{{ $paymet->code }}" value="{{ $paymet->id }}" name="select_payment">
                      <span class="checkmark"></span>
                    </label>
                  </div>
                </div>
                @endforeach
                @endif
              </div>
              @error('selected_va')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="checkout__input mt-2">
              <p class="mb-2">Order notes: </p>
              <input wire:model='order_notes' type="text" style="border: 1px solid #a7a7a7;"
                placeholder="Notes about your order, e.g. special notes for delivery.">
            </div>
          </div>
          <div class="col-lg-5">
            <div class="checkout__order">
              <h4>Your Order</h4>
              <div class="checkout__order__products">Products <span>Total</span></div>
              <ul>
                @forelse ($products as $item)
                <li>{{ $item->product->name }} x {{ $item->qty }} <span>{{
                    currency_IDR(($item->product->regular_price-$item->product->sale_price) * $item->qty) }}</span></li>
                @empty
                <li>No product to checkout</li>
                @endforelse
              </ul>
              <div class="checkout__order__subtotal">Subtotal <span>{{ currency_IDR($subTotalPriveAll) }}</span></div>
              @if ($voucherCode)
              <strong style="font-size: 18px;">"{{ $voucherCode }}"<span style="float: right">- {{
                  currency_IDR($voucherVal) }}</span></strong>
              @endif
              <div class="checkout__order__ppn">PPN 5% <span>{{ currency_IDR($ppn) }}</span></div>
              <div class="checkout__order__total">Total <span>{{ currency_IDR($totalPriceToCheckout) }}</span></div>

              <strong style="font-size: 18px">Finish Order</strong>
              <p class="mb-1">Receipt invoice will be sent to the email address.</p>
              <div class="checkout__input__checkbox">
                <label for="invoice_recipt">
                  Recipt Invoice
                  <input wire:model='recipt_invoice' type="checkbox" id="invoice_recipt">
                  <span class="checkmark"></span>
                </label>
              </div>
              <button wire:click='placeOrderCart' type="submit" class="site-btn">PLACE ORDER</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div>
  <style>
    .image-product {
      width: 55px;
      height: 55px;
      object-fit: cover;
    }

    .img-icon-po {
      height: 20px;
      object-fit: cover;
    }

    .img-icon-po2 {
      height: 40px;
      object-fit: cover;
    }

    .back-to-orders:hover {
      color: gray;
    }
    
    @media only screen and (max-width: 600px) {
      .pay-detail-col-right{
        margin-top: 1.5rem !important;
      }
    }
  </style>

  @include('livewire.component.toast-alert')

  <section class="breadcrumb-section set-bg mb-3" style="padding: 30px 0 0px;">{{-- data-setbg="{{
    asset('banner/banner.png') }}" --}}
    <div class="breadcrumb__text">
      <a class="back-to-orders" href="{{ route('ordered-transaction') }}">&larr; back to orders</a>
      <h2 class="text-dark mt-2" style="font-size: 36px">Transaction Detail</h2>
      <span class="text-dark">No. Order: {{ $findTrans ? $findTrans->trans_code : "-" }}</span>
    </div>
  </section>

  <hr class="mb-4">

  <h5><strong>Overview:</strong></h5>
  <div class="card mt-2 mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-md-4 mb-2 mt-1 text-center">
          <p class="mb-0">No. Order:</p>
          @if ($findTrans)
          <h5>{{ $findTrans->trans_code }} <i class='bx bx-copy-alt' style="cursor: pointer"
              wire:click.prevent="copyToClipboard('{{ $findTrans->trans_code }}')"></i></h5>
          @else
          -
          @endif
        </div>
        <div class="col-md-3 mb-2 mt-1 text-center">
          <p class="mb-0">Order Date:</p>
          @if ($findTrans)
          <h5>
            {{ formatDate("in", $findTrans->created_at, true) }}
          </h5>
          @else
          -
          @endif
        </div>
        <div class="col-md-2 mb-2 mt-1 text-center">
          <p class="mb-0">Amounts:</p>
          <h5>
            <strong>
              {{ currency_IDR($totalAmountsPrice) }}
            </strong>
          </h5>
        </div>
        <div class="col-md-3 mb-2 mt-1 text-center">
          <p class="mb-0">Order Status:</p>
          @if ($findTrans)
          <span
            class="badge {{ $findTrans->status == 1 ? 'badge-secondary' : ($findTrans->status == 5 ? 'badge-success' : 'badge-primary') }}">
            <h6 class="text-light ml-1 mr-1">
              @if ($findTrans->status == 1)
              Waiting Payment
              @elseif ($findTrans->status == 2)
              Paid
              @elseif ($findTrans->status == 3)
              Packing
              @elseif ($findTrans->status == 4)
              Shipment
              @elseif ($findTrans->status == 5)
              Finished
              @else
              -
              @endif
            </h6>
          </span>
          @else
          <h5>
            -
          </h5>
          @endif
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <h5><strong>Payment Detail:</strong></h5>
      <div class="card mt-2 mb-4">
        <div class="card-body">
          @if ($findTrans)
          @php
          $responJson = $findTrans->transaction ? json_decode($findTrans->transaction->midtrans_response) : null;
          @endphp

          {{-- Gopay Template --}}
          @if ($findTrans->payment->code == "po-001")
          <div>
            <div class="row">
              <div class="col-md-6 text-center">
                <div class="mb-3">
                  <p class="mb-0">Payment Type:</p>
                  <img src="{{ asset('po-img/' . $findTrans->payment->img) }}"  style="object-fit: contain; height: 30px" alt="{{ $findTrans->payment->code }}">
                </div>
                <div>
                  <p class="mb-0">Total Payment:</p>
                  <h4 class="text-success">
                    <strong>
                      {{ currency_IDR($totalAmountsPrice) }}
                      <i class='bx bx-copy-alt text-dark' style="cursor: pointer" wire:click.prevent="copyToClipboard('{{ $totalAmountsPrice }}')"></i>
                    </strong>
                  </h4>
                  Enter corresponding to the last digit
                </div>
              </div>
              <div class="col-md-6 text-center pay-detail-col-right">
                {{-- Generate QR Code Img {{ $responJson->actions[0]->url }} --}}
                <img src="{{ asset('po-img/qr_icon.png') }}" alt="QR ICON" style="object-fit: contain; width: 120px">
                <div class="mt-2">
                  <a href="javascript:void(0)" class="text-info">Show QR</a>
                  <span class="px-1">or</span>
                  <a href="{{ $responJson ? $responJson->actions[1]->url : "javascript:void(0)" }}" target="_blank" class="text-info">Gopay App</a>
                </div>
              </div>
            </div>
          </div>

          {{-- BNI, BRI, CIMB, Permata --}}
          @elseif ($findTrans->payment->code == "po-002" || $findTrans->payment->code == "po-003" || $findTrans->payment->code == "po-004" || $findTrans->payment->code == "po-006")
          <div>
            <div class="row">
              <div class="col-md-6 mb-3 text-center">
                <p class="mb-0">Payment Type:</p>
                <h5>
                  Bank Transfer
                </h5>
              </div>
              <div class="col-md-6 mb-4 text-center">
                <img src="{{ asset('po-img/' . $findTrans->payment->img) }}" class="img-icon-po2" alt="{{ $findTrans->payment->code }}">
              </div>
            </div>
  
            <div class="row">
              <div class="col-md-6 text-center">
                <p class="mb-0">Total Payment:</p>
                <h4 class="text-success">
                  <strong>
                    {{ currency_IDR($totalAmountsPrice) }}
                    <i class='bx bx-copy-alt text-dark' style="cursor: pointer" wire:click.prevent="copyToClipboard('{{ $totalAmountsPrice }}')"></i>
                  </strong>
                </h4>
                Enter corresponding to the last digit
              </div>
              <div class="col-md-6 text-center pay-detail-col-right">
                <div>
                  <p class="mb-0">Virtual Number:</p>
                  @if($findTrans->transaction)
                  <h4>
                    <strong>
                      {{ $findTrans->transaction->va }}
                      <i class='bx bx-copy-alt' style="cursor: pointer" wire:click.prevent="copyToClipboard('{{ $findTrans->transaction->va }}')"></i>
                    </strong>
                  </h4>
                  Until - {{ formatDateFormal($findTrans->transaction->expiry_time, true) }}
                  @else
                  -
                  @endif
                </div>
              </div>
            </div>
          </div>

          {{-- Mandiri --}}
          @elseif ($findTrans->payment->code == "po-005")
          <div>
            <div class="row">
              <div class="col-md-5 mb-3 text-center">
                <p class="mb-0">Payment Type:</p>
                <h5>
                  Bank Transfer
                </h5>
              </div>
              <div class="col-md-7 mb-4 text-center">
                <img src="{{ asset('po-img/' . $findTrans->payment->img) }}" class="img-icon-po2" alt="{{ $findTrans->payment->code }}">
              </div>
            </div>
            
            <div class="row">
              <div class="col-md-5 text-center">
                <p class="mb-0">Total Payment:</p>
                <h4 class="text-success">
                  <strong>
                    {{ currency_IDR($totalAmountsPrice) }}
                    <i class='bx bx-copy-alt text-dark' style="cursor: pointer" wire:click.prevent="copyToClipboard('{{ $totalAmountsPrice }}')"></i>
                  </strong>
                </h4>
                Enter corresponding to the last digit
              </div>
              <div class="col-md-7 pay-detail-col-right">
                <div class="row">
                  <div class="col-md-5 text-center">
                    <p class="mb-0">Bill Code:</p>
                    @if($findTrans->transaction)
                    <h4>
                      <strong>
                        {{ $responJson->biller_code }}
                      </strong>
                    </h4>
                    Midtrans
                    @else
                    -
                    @endif
                  </div>
                  <div class="col-md-7 text-center">
                    <p class="mb-0">Virtual Number:</p>
                    @if($findTrans->transaction)
                    <h4>
                      <strong>
                        {{ $responJson->bill_key }}
                        <i class='bx bx-copy-alt' style="cursor: pointer" wire:click.prevent="copyToClipboard('{{ $responJson->bill_key }}')"></i>
                      </strong>
                    </h4>
                    Until - {{ formatDateFormal($findTrans->transaction->expiry_time, true) }}
                    @else
                    -
                    @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
          @endif

          @else
          <div class="mb-3 d-flex align-items-center justify-content-between">
            <div>
              <p class="mb-0">Payment Type:</p>
              -
            </div>
            <div>
            </div>
          </div>
          <div class="mb-3">
            <p class="mb-0">Virtual Number:</p>
            -
          </div>
          <div>
            <p class="mb-0">Total Payment:</p>
            -
          </div>
          @endif
        </div>
      </div>

      <h5><strong>Billing Details:</strong></h5>
      <div class="card mt-2 mb-4">
        <div class="card-header">
          Arrival
        </div>
        <div class="card-body">
          @if ($findTrans)
          <div>
            <strong>
              {{ $findTrans->address->name }}
              @if ($findTrans->address->mark_as)
              <span class="badge badge-secondary ml-1">
                {{ $findTrans->address->mark_as == "h" ? "Home" : "Office" }}
              </span>
              @endif
            </strong>
            <p class="mb-0">{{ $findTrans->address->contact }}</p>
            <p class="mb-0">
              {{ $findTrans->address->address }}. {{ $findTrans->address->city }}, {{ $findTrans->address->country->name
              }}, {{ $findTrans->address->post_code }}.
            </p>
          </div>
          @endif
        </div>
      </div>

      <h5><strong>Product Items:</strong></h5>
      <div class="card mt-2">
        <div class="card-body" style="padding-top: 10px; padding-bottom: 0px">
          <div class="table-responsive">
            <table class="table ">
              <thead>
                <tr>
                  <th style="border-top: none">#</th>
                  <th style="border-top: none" class="shoping__product">Item</th>
                  <th style="border-top: none">Price</th>
                  <th style="border-top: none">Total</th>
                </tr>
              </thead>
              <tbody>
                @if ($findTrans)
                @foreach ($findTrans->products as $product)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>
                    <a href="{{ route('product.detail', ['product_id' => $product->product_id]) }}" target="_blank">
                      <img src="{{ asset('storage/' . colName('pr') . $product->product->image->image) }}" alt=""
                        class="image-product">
                    </a>
                    <span class="ml-2">{{ $product->product->name }} x {{ $product->qty }}</span>
                  </td>
                  <td>{{ currency_IDR($product->price) }}</td>
                  <td>{{ currency_IDR($product->price * $product->qty) }}</td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="checkout__order mt-4">
        <h4>Order Summary</h4>
        <ul>
          <li>
            Subtotal
            <span>{{ currency_IDR($getTotalProducts) }}</span>
          </li>
          @if ($voucherName)
          <li>
            Voucher "{{ $voucherName }}"
            <span>- {{ currency_IDR($dicountVoucher) }}</span>
          </li>
          @endif
          <li>
            PPN 5%
            <span>{{ currency_IDR($ppn) }}</span>
          </li>
          <li>
            Fee {{ $payment_fee_name }}
            <span>{{ currency_IDR($payment_fee_value) }}</span>
          </li>
        </ul>

        <div class="mb-3">
          <h4>Amounts<span style="float: right">{{ currency_IDR($totalAmountsPrice) }}</span></h4>
        </div>

        <div class="checkout__order__ppn mb-0 pb-0" style="border-bottom: none">Track Recording: </div>
        @if ($findTrans)
        <div class="d-flex justify-content-between">
          <div>Ordered</div>
          <div>{{ formatDate("in", $findTrans->created_at, true) }}</div>
        </div>
        <div class="d-flex justify-content-between">
          <div>Payed</div>
          <div>
            @if ($findTrans->transaction)
              {{ $findTrans->transaction->payed_date ? formatDate("in", $findTrans->transaction->payed_date, true) : "-" }}
            @endif
          </div>
        </div>
        <div class="d-flex justify-content-between">
          <div>Shipment</div>
          @if ($findTrans->transaction)
            {{ $findTrans->transaction->shipment_date ? formatDate("in", $findTrans->transaction->shipment_date, true) : "-" }}
          @endif
        </div>
        <div class="d-flex justify-content-between">
          <div>Finished</div>
          @if ($findTrans->transaction)
            {{ $findTrans->transaction->finish_date ? formatDate("in", $findTrans->transaction->finish_date, true) : "-" }}
          @endif
        </div>
        @endif

        <button type="submit" class="site-btn mt-2">PLACE ORDER</button>
      </div>
    </div>
  </div>
</div>
<script>
  window.addEventListener('hit-function-copy', event => {
    var getCode = event.detail.code;
    copyTextClipboard(getCode);
  });
</script>
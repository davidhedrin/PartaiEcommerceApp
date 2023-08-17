<div>
  <style>
    .button-content-delivered i {
      color: #17966b;
      font-size: 40px;
      transition: transform 0.1s ease;
    }

    .button-content-delivered {
      cursor: pointer;
      padding: 25px 0;
      /* border-radius: 10px;
      background: rgb(232, 232, 232); */
      margin-bottom: 0 !important;
    }

    .button-content-delivered:hover {
      border-radius: 12px;
      background: rgb(232, 232, 232);
    }

    .button-content-delivered:hover i {
      transform: scale(1.2);
    }

    .active-page {
      border-radius: 12px;
      background: rgb(232, 232, 232);
    }
  </style>

  @include('livewire.component.toast-alert')

  <section class="breadcrumb-section set-bg mb-3">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="breadcrumb__text">
            <h2 class="text-dark">All Ordered <i class="fa fa-truck"></i></h2>
            <a href="{{ route('shop') }}" class="text-dark" style="text-decoration: underline">Continue Shopping
              &rarr;</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <hr>
  <div class="row">
    <div class="col-lg-3 text-center mb-3">
      <div class="contact__widget button-content-delivered {{ $activePage == 1 ? " active-page" : "" }}"> {{-- --}}
        <i class='bx bx-wallet'></i>
        <h4>Paying</h4>
      </div>
    </div>
    <div class="col-lg-3 text-center mb-3">
      <div class="contact__widget button-content-delivered">
        <i class='bx bx-package'></i>
        <h4>Packaged</h4>
      </div>
    </div>
    <div class="col-lg-3 text-center mb-3">
      <div class="contact__widget button-content-delivered">
        <i class='bx bxs-truck'></i>
        <h4>Deliver</h4>
      </div>
    </div>
    <div class="col-lg-3 text-center mb-3">
      <div class="contact__widget button-content-delivered">
        <i class='bx bx-donate-heart'></i>
        <h4>Arrived</h4>
      </div>
    </div>
  </div>
  <hr>

  <div class="d-flex justify-content-between">
    <h5 class="mb-3"><strong>Need to Paid</strong></h5>
    <h5><strong>{{ count($allTransaction) }} Item</strong></h5>
  </div>
  
  @forelse ($allTransaction as $trans)
  @php
  $totalCheckOut = totalCheckoutProduct($trans->products);
  $ifVoucher = transactionWithVoucher($totalCheckOut, $trans->voucher);
  @endphp
  <a href="{{ route('transaction-detail', ['trans_id' => $trans->id]) }}">
    <div class="card mb-4">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 mb-2">
            <p class="mb-0">No. Order:</p>
            <strong class="text-dark">{{ $trans->trans_code }}</strong>
          </div>
          <div class="col-md-3 mb-2">
            <p class="mb-0">Items:</p>
            @foreach ($trans->products as $product)
            <span class="badge badge-secondary" style="font-size: small">{{ $product->product->name }} x{{ $product->qty }}</span>
            @endforeach
          </div>
          <div class="col-md-3 mb-2">
            <p class="mb-0">Order Time:</p>
            <span class="text-dark">{{ formatDate("in", $trans->created_at) }}</span>
          </div>
          <div class="col-md-3 mb-2">
            <p class="mb-0">Total:</p>
            @php
            $totalPaymentFee = 0;
            if($trans->payment->fee_fixed) {
            $totalPaymentFee += $trans->payment->fee_fixed;
            }
            if($trans->payment->fee_percent) {
            $totalPaymentFee += $totalCheckOut * ($trans->payment->fee_percent/100);
            }
            @endphp
            <strong class="text-dark">{{ currency_IDR(($totalCheckOut - $ifVoucher) + ($totalCheckOut * 0.05) + $totalPaymentFee) }}</strong>
          </div>
        </div>
      </div>
    </div>
  </a>
  @empty
  <div class="card mb-4">
    <div class="card-body text-center">
      <em>No transaction found</em>
    </div>
  </div>
  @endforelse
</div>
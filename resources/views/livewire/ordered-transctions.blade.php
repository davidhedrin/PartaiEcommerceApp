<div>
  <style>
    .button-content-delivered i {
      color: #17966b;
      font-size: 40px;
    }

    .button-content-delivered{
      cursor: pointer;
    }
    .button-content-delivered:hover{
      border-radius: 12px;
      background: rgb(232, 232, 232);
      transition: transform 1 ease;
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

  <div class="row">
    <div class="col-lg-3 text-center button-content-delivered">
      <div class="contact__widget">
        <i class='bx bx-wallet mt-4'></i>
        <h4>Paying</h4>
      </div>
    </div>
    <div class="col-lg-3 text-center button-content-delivered">
      <div class="contact__widget">
        <i class='bx bx-package mt-4'></i>
        <h4>Packaged</h4>
      </div>
    </div>
    <div class="col-lg-3 text-center button-content-delivered">
      <div class="contact__widget">
        <i class='bx bxs-truck mt-4'></i>
        <h4>Deliver</h4>
      </div>
    </div>
    <div class="col-lg-3 text-center button-content-delivered">
      <div class="contact__widget">
        <i class='bx bx-donate-heart mt-4'></i>
        <h4>Arrived</h4>
      </div>
    </div>
  </div>
</div>
</div>
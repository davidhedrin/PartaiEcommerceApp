<div>
  <style>
    .checkout__input p {
      margin-bottom: 0.2rem !important;
    }

    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"] {
      -webkit-appearance: none;
      margin: 0;
    }
  </style>

  @include('livewire.component.toast-alert')

  <section wire:ignore class="breadcrumb-section set-bg mb-4" data-setbg="{{ asset('banner/banner.png') }}">{{-- --}}
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <div class="breadcrumb__text">
            <h2 class="text-dark">Profile</h2>
            <span href="{{ route('shop') }}" class="text-dark">{{ $user->email }}</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="row">
    <div wire:ignore class="col-md-3">
      <div class="hero__categories">
        <ul class="billing" style="padding-top: 10px;">
          <li><a href="#"><i class="fa fa-address-book-o" aria-hidden="true"></i> Profile</a></li>
          <li><a href="#"><i class="fa fa-unlock-alt" aria-hidden="true"></i> Password</a></li>
          <li><a href="#"><i class="fa fa-address-card-o" aria-hidden="true"></i> Address</a></li>
          <hr class="mt-0">
          <li><a href="#"><i class="fa fa-chain-broken" aria-hidden="true"></i> Delete Account</a></li>
          <li><a href="javascript:void(0)" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out"></i> Logout</a></li>
        </ul>
      </div>
    </div>
    <div wire:ignore class="col-md-9">
      <div class="row">
        <div class="col-lg-6">
          <div class="checkout__input">
            <p>Full Name<span>*</span></p>
            <input wire:model='fullName' type="text" placeholder="Enter your fullname">
            @error('fullName')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="col-lg-6">
          <div class="checkout__input">
            <p>Phone Number<span>*</span></p>
            <input wire:model='phoneNumber' type="number" placeholder="Enter your phone number">
            @error('phoneNumber')
              <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="col-lg-12 mb-4">
          <div class="checkout__input">
            <p>Gender<span>*</span></p>
            <select wire:model="gender" class="form-select" id="select_gender">
              <option value="">Select gender</option>
              <option value="m">Male</option>
              <option value="l">Female</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="checkout__input">
            <p>Birth Plece<span>*</span></p>
            <input wire:model="birth_place" type="text" placeholder="Enter your birth plece">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="checkout__input">
            <p>Birth Date<span>*</span></p>
            <input wire:model="birth_date" type="date">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="checkout__input">
            <p>Nationality<span>*</span></p>
            <input wire:model="nationality" type="text" placeholder="Enter your national">
          </div>
        </div>
        <div class="col-lg-6">
          <div class="checkout__input">
            <p>Raligion<span>*</span></p>
            <input wire:model="religion" type="text" placeholder="Enter your raligion">
          </div>
        </div>
        <div class="col-lg-12" style="text-align: end">
          <button wire:click='saveUserDetail' type="button" class="site-btn">Save</button>
        </div>
      </div>
    </div>
  </div>
</div>
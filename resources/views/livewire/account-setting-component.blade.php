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
    <div class="col-md-3">
      <div class="hero__categories">
        <ul class="billing" style="padding-top: 10px;">
          <li><a href="javascript:void(0)" wire:click="changeActiveSetting(1)"><i class="fa fa-address-book-o"
                aria-hidden="true"></i> Profile</a></li>
          <li><a href="javascript:void(0)" wire:click="changeActiveSetting(2)"><i class="fa fa-unlock-alt"
                aria-hidden="true"></i> Password</a></li>
          <li><a href="javascript:void(0)" wire:click="changeActiveSetting(3)"><i class="fa fa-address-card-o"
                aria-hidden="true"></i> Address</a></li>
          <hr class="mt-0">
          <li><a href="javascript:void(0)" wire:click="changeActiveSetting(4)"><i class="fa fa-chain-broken"
                aria-hidden="true"></i> Delete Account</a></li>
          <li><a href="javascript:void(0)" data-toggle="modal" data-target="#logoutModal"><i class="fa fa-sign-out"></i>
              Logout</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9">
      {{-- Profile setting --}}
      @if ($activeSetting == 1)
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
            <p>Gender<span>*</span></p>
            <select wire:model="gender" class="custom-select">
              <option value="">Select gender</option>
              <option value="m">Male</option>
              <option value="f">Female</option>
            </select>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="checkout__input">
            <p>Nationality<span>*</span></p>
            <select wire:model="country_id" class="custom-select">
              <option value="">Select your country</option>
              @foreach ($countries as $country)
              <option value="{{ $country->id }}">{{ $country->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-lg-12" style="text-align: end">
          <button wire:click='saveUserDetail' type="button" class="site-btn">Save</button>
        </div>
      </div>
      {{-- Password setting --}}
      @elseif ($activeSetting == 2)
      <div class="row">
        <div class="col-lg-12">
          <div class="checkout__input">
            <p>Old Password<span>*</span></p>
            <input wire:model='oldPassword' type="password" placeholder="Enter your old password">
            @error('oldPassword')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="col-lg-12">
          <hr class="mt-3 mb-4">
        </div>
        <div class="col-lg-12">
          <div class="checkout__input">
            <p>New Password<span>*</span></p>
            <input wire:model='newPassword' type="password" placeholder="Enter your old password">
            @error('newPassword')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="col-lg-12">
          <div class="checkout__input">
            <p>Confirm Password<span>*</span></p>
            <input wire:model='confirmNewPassword' type="password" placeholder="Enter your old password">
            @error('confirmNewPassword')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="col-lg-12" style="text-align: end">
          <button wire:click='saveChangePassword' type="button" class="site-btn">Save</button>
        </div>
      </div>
      {{-- Address setting --}}
      @elseif ($activeSetting == 3)
      <div class="hero__categories mb-3" id="select_address">
        <div class="hero__categories__all black__arrow" id="select_all_address" style="background: #f5f5f5">
          <i class="fa fa-bars text-dark"></i>
          <span class="text-dark">All Address</span>
        </div>
        <ul class="billing">
          @forelse ($allAddress as $address)
          <li class="d-flex align-items-center justify-content-between">
            <a href="javascript:void(0)">
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
                <p style="margin-top: 15px; margin-bottom: 0px; line-height: 20px">
                  {{ $address->address }} {{ $address->city }}, {{ $address->country }}, {{ $address->post_code }}.
                </p>
              </div>
            </a>
            <div>
              <a href="javascript:void(0)" wire:click="$set('idDeleteAddress', {{ $address->id }})" data-toggle="modal"
                data-target="#deleteAddressModal">
                <i class="fa fa-times"></i>
              </a>
            </div>
          </li>
          @if (count($allAddress) > 1)
          <hr class="mt-2 mb-0">
          @endif
          @empty
          <li class="d-flex align-items-center justify-content-center">
            <div class="text-center py-2 mt-4">
              <i class="fa fa-address-card-o" aria-hidden="true" style="font-size: 40px;"></i>
              <p><em>Address is empty, No address has been registered yet.</em></p>
            </div>
          </li>
          @endforelse
          <li class="mt-0" style="background: lightgray">
            <a href="javascript:void(0)" class="text-center" data-toggle="modal" data-target="#modalAddAddress"><i
                class="fa fa-plus-circle" aria-hidden="true"></i> Add More Address</a>
          </li>
        </ul>
      </div>
      @elseif ($activeSetting == 4)
      @endif
    </div>
  </div>

  <div wire:ignore.self class="modal fade bd-example-modal-lg" id="modalAddAddress" tabindex="-1" role="dialog"
    aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="max-width: 900px">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add Address</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-lg-6">
              <div class="checkout__input">
                <p>Fist Name<span>*</span></p>
                <input wire:model="address_fname" type="text" placeholder="Enter first name">
                @error("address_fname")
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="col-lg-6">
              <div class="checkout__input">
                <p>Last Name<span>*</span></p>
                <input wire:model="address_lname" type="text" placeholder="Enter last name">
                @error("address_lname")
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
          <div class="checkout__input">
            <p>Phone<span>*</span></p>
            <input wire:model="address_contact" type="number" placeholder="Enter number phone">
            @error("address_contact")
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="checkout__input">
            <p>Address<span>*</span></p>
            <input wire:model="address_address" type="text"
              placeholder="Street Address, Province, Subdistrict, Apartment, Housing Area, etc...">
            @error("address_address")
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="checkout__input">
            <p>Country<span>*</span></p>
            <select wire:model="address_country" class="custom-select mt-0">
              <option value="">Select your country</option>
              @foreach ($countries as $country)
              <option value="{{ $country->name }}">{{ $country->name }}</option>
              @endforeach
            </select>
            @error("address_country")
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="checkout__input">
            <p>Town/City<span>*</span></p>
            <input wire:model="address_city" type="text" placeholder="Enter town or city">
            @error("address_city")
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="checkout__input">
            <p>Postcode/ZIP<span>*</span></p>
            <input wire:model="address_post_code" type="text" placeholder="Enter postcode or ZIP">
            @error("address_post_code")
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div>
            <p class="mb-2">Address Mark</p>
            <div class="custom-control custom-radio custom-control-inline">
              <input wire:model="address_mark_as" type="radio" id="radioMarkHome" name="radioAddressMark"
                class="custom-control-input" value="h">
              <label class="custom-control-label" for="radioMarkHome">Home</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input wire:model="address_mark_as" type="radio" id="radioMarkOffice" name="radioAddressMark"
                class="custom-control-input" value="o">
              <label class="custom-control-label" for="radioMarkOffice">Office</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button wire:click='saveNewAddress' type="button" class="btn btn-primary">Save address</button>
        </div>
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade" id="deleteAddressModal" tabindex="-1" role="dialog"
    aria-labelledby="logoutModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <img src="{{ asset('logo/logo2.png') }}" class="rounded mr-2" alt="" width="160px">
          <button wire:click="$set('idDeleteAddress', null)" type="button" class="close" data-dismiss="modal"
            aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          Are you sure you want to delete this address?
        </div>
        <div class="modal-footer">
          <button wire:click="$set('idDeleteAddress', null)" type="button" class="btn btn-primary btn-sm"
            data-dismiss="modal">Batal</button>
          <button wire:click="deleteAddress" type="button" class="btn btn-danger btn-sm">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.addEventListener('close-form-modal', event => {
    $('#modalAddAddress').modal('hide');
    $('#deleteAddressModal').modal('hide');
  });
</script>
<div>
  @if (Session::has('msgAlert'))
    <div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 show" role="alert" aria-live="assertive"
      aria-atomic="true" data-delay="2000" style="background-color: white !important;">
      <div class="toast-header">
        <img src="{{ asset('assets/img/logo.png') }}" class="rounded mr-2" alt="" width="50px">
        <div class="me-auto fw-semibold"></div>
        <small class="text-{{ strtolower(Session::get('msgStatus')) }}">{{ Session::get('msgStatus') }}</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        {{ Session::get('msgAlert') }}
      </div>
    </div>
  @endif

  <div wire:ignore class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
      <li class="nav-item">
        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
          aria-controls="navs-pills-top-home" aria-selected="false">Home</button>
      </li>
      <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
          data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
          aria-selected="true">Profile</button>
      </li>
      <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages"
          aria-controls="navs-pills-top-messages" aria-selected="false">Messages</button>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade active show" id="navs-pills-top-home" role="tabpanel">
        <h5>Company Details</h5>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="company_email">Email</label>
            <div class="input-group input-group-merge">
              <span id="company_email2" class="input-group-text"><i class='bx bx-envelope'></i></span>
              <input wire:model="email" type="text" id="company_email" class="form-control" placeholder="Enter email address"
                aria-label="Enter email address" aria-describedby="company_email2">
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="no_ponsel">No Phone</label>
            <div class="input-group input-group-merge">
              <span id="no_ponsel2" class="input-group-text"><i class="bx bx-phone"></i></span>
              <input wire:model="contact" type="text" id="no_ponsel" class="form-control" placeholder="082112341234"
                aria-label="082112341234" aria-describedby="no_ponsel2">
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <label class="form-label" for="company_address">Address</label>
            <div class="input-group input-group-merge">
              <span id="company_address2" class="input-group-text"><i class='bx bx-map-pin'></i></span>
              <textarea wire:model="address" class="form-control" name="" id="company_address" rows="1" placeholder="Enter company address"
              aria-label="Enter company address" aria-describedby="company_address2"></textarea>
            </div>
          </div>
        </div>

        <hr>

        <h5>Social Media</h5>
        <div class="d-flex mb-3">
          <div class="flex-shrink-0">
            <img src="{{ asset('assetz/img/icons/brands/facebook.png') }}" alt="facebook" class="me-3" height="30">
          </div>
          <div class="flex-grow-1 row">
            <div class="col-2 mb-sm-0 mb-2">
              <h6 class="mb-0">Facebook</h6>
              <small class="text-muted">Not Connected</small>
            </div>
            <div class="col-10 text-end">
              <div class="input-group">
                <input wire:model="sosmedFb" type="text" class="form-control" placeholder="https://example.url" aria-describedby="button_link_sosmed">
                <a href="{{ $sosmedFb ? $sosmedFb : "javascript:void(0)" }}" class="btn btn-outline-secondary" id="button_link_sosmed">
                  <i class="bx bx-link-alt"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex mb-3">
          <div class="flex-shrink-0">
            <img src="{{ asset('assetz/img/icons/brands/twitter.png') }}" alt="twitter" class="me-3" height="30">
          </div>
          <div class="flex-grow-1 row">
            <div class="col-2 mb-sm-0 mb-2">
              <h6 class="mb-0">Twitter</h6>
              <small class="text-muted">Not Connected</small>
            </div>
            <div class="col-10 text-end">
              <div class="input-group">
                <input wire:model="sosmedTw" type="text" class="form-control" placeholder="https://example.url" aria-describedby="button_link_sosmed">
                <a href="{{ $sosmedTw ? $sosmedTw : "javascript:void(0)" }}" class="btn btn-outline-secondary" id="button_link_sosmed">
                  <i class="bx bx-link-alt"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex mb-3">
          <div class="flex-shrink-0">
            <img src="{{ asset('assetz/img/icons/brands/linkedin.png') }}" alt="linkedin" class="me-3" height="30">
          </div>
          <div class="flex-grow-1 row">
            <div class="col-2 mb-sm-0 mb-2">
              <h6 class="mb-0">LinkedIn</h6>
              <small class="text-muted">Not Connected</small>
            </div>
            <div class="col-10 text-end">
              <div class="input-group">
                <input wire:model="sosmedLi" type="text" class="form-control" placeholder="https://example.url" aria-describedby="button_link_sosmed">
                <a href="{{ $sosmedLi ? $sosmedLi : "javascript:void(0)" }}" class="btn btn-outline-secondary" id="button_link_sosmed">
                  <i class="bx bx-link-alt"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        
        <hr>
        
        <h5>Confirm Change</h5>
        <div class="mb-3 col-12 mb-0">
          <div class="alert alert-warning">
            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to change information?</h6>
            <p class="mb-0">Changes to information will be logged. And it will <strong>NOT</strong> be changed again in the next <strong>7 days</strong>. Please be certain!</p>
          </div>
        </div>
        <div class="mb-3">
          <div class="form-check">
            <input wire:model="confirm" class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation">
            <label class="form-check-label" for="accountActivation">I confirm to change information</label>
          </div>
          @error("confirm")
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>

        <button type="button" class="btn btn-primary deactivate-account">Save Change</button>
      </div>
      <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
        <p>
          Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice cream. Gummies
          halvah
          tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream cheesecake fruitcake.
        </p>
        <p class="mb-0">
          Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah cotton candy
          liquorice caramels.
        </p>
      </div>
      <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
        <p>
          Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies cupcake gummi
          bears
          cake chocolate.
        </p>
        <p class="mb-0">
          Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet roll icing
          sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly jelly-o tart brownie
          jelly.
        </p>
      </div>
    </div>
  </div>
  
  <div id="confirm_modal" class="modal fade" tabindex="-1" style="display: none; z-index: 9999;" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Save Confirmation
            <i class='bx bx-save'></i>
          </h5>
        </div>
        <div class="modal-body text-center">
          <span>Enter your password</span>
          <p>Confirm with your password to continue</p>
          <input wire:model="pass_confirm" type="password" class="form-control" placeholder="Enter your password">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button wire:click.prevent="saveChangeInfo" type="button" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>
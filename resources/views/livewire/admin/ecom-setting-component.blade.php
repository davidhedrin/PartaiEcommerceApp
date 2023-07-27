<div>
  @include('livewire.component.toast-alert-admin')
  
  <div class="card">
    <div class="card-body">
      <h5>Company Details</h5>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label" for="company_email">Email</label>
          <div class="input-group input-group-merge">
            <span id="company_email2" class="input-group-text"><i class='bx bx-envelope'></i></span>
            <input wire:model="email" type="text" id="company_email" class="form-control" placeholder="Enter email address"
              aria-label="Enter email address" aria-describedby="company_email2">
          </div>
          @error("email")
            <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label" for="no_ponsel">No Phone</label>
          <div class="input-group input-group-merge">
            <span id="no_ponsel2" class="input-group-text"><i class="bx bx-phone"></i></span>
            <input wire:model="contact" type="text" id="no_ponsel" class="form-control" placeholder="082112341234"
              aria-label="082112341234" aria-describedby="no_ponsel2">
          </div>
          @error("contact")
            <span class="text-danger">{{ $message }}</span>
          @enderror
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
            {{-- <small class="text-warning"></small> --}}
          </div>
          <div class="col-10 text-end">
            <div class="input-group">
              <input wire:model="sosmedFb" type="text" class="form-control" placeholder="https://example.url" aria-describedby="button_link_sosmed">
              <a href="{{ $sosmedFb ? $sosmedFb : "javascript:void(0)" }}" class="btn btn-outline-secondary" id="button_link_sosmed" target="{{ $sosmedFb ? '_blank' : '' }}">
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
          </div>
          <div class="col-10 text-end">
            <div class="input-group">
              <input wire:model="sosmedTw" type="text" class="form-control" placeholder="https://example.url" aria-describedby="button_link_sosmed">
              <a href="{{ $sosmedTw ? $sosmedTw : "javascript:void(0)" }}" class="btn btn-outline-secondary" id="button_link_sosmed" target="{{ $sosmedTw ? '_blank' : '' }}">
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
          </div>
          <div class="col-10 text-end">
            <div class="input-group">
              <input wire:model="sosmedLi" type="text" class="form-control" placeholder="https://example.url" aria-describedby="button_link_sosmed">
              <a href="{{ $sosmedLi ? $sosmedLi : "javascript:void(0)" }}" class="btn btn-outline-secondary" id="button_link_sosmed" target="{{ $sosmedLi ? '_blank' : '' }}">
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
          <p class="mb-0">Changes to information will be logged. Please be certain!</p>
        </div>
      </div>

      <button type="button" class="btn btn-primary deactivate-account" data-bs-toggle="modal" data-bs-target="#confirm_modal">Save Change</button>
    </div>
  </div>
  
  <div wire:ignore.self id="confirm_modal" class="modal fade" data-bs-backdrop="static" tabindex="-1" style="display: none; z-index: 9999;" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Save Confirmation
          </h5>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <span>Enter your password</span>
            <p>Confirm with your password to continue</p>
          </div>
          <input wire:model="pass_confirm" type="password" class="form-control" placeholder="Enter your password">
          @error("pass_confirm")
            <span class="text-danger text-start">{{ $message }}</span>
          @enderror
        </div>
        <div class="modal-footer">
          <button wire:click="clearConfirmPass" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button wire:click.prevent="saveChangeInfo" type="button" class="btn btn-primary">Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.addEventListener('close-form-modal', event => {
    $("#confirm_modal").modal("hide");
  });
</script>
<div>
  <style>
    /* .color-href {
      color: rgb(24, 109, 255) !important;
    } */
    .color-href:hover{
      text-decoration: underline;
    }
  </style>

  @include('livewire.component.toast-alert')

  <div class="row justify-content-center mt-5">
    <div class="col-md-5">
      <div class="text-center mb-3">
        <a href="{{ route('home') }}">
          <img src="{{ asset('logo/logo1.png') }}" width="400px" alt="">
        </a>
      </div>
      <div class="section-title">
        <h2>System OTP Verification</h2>
      </div>
      <div class="text-center mb-4">
        <span>Kode otp yang dikirim melalui email digunakan untuk periode dalam 1 hari. Kode dapat dikirim <strong>1x</strong> dalam sehari.</span>
      </div>

      <h5 class="text-center mb-2" style="font-weight: bold; text-decoration: underline">{{ Auth::user()->email }}</h5>
      <div class="text-center">
        <a wire:click.prevent='sendMailOtp' class="text-dark color-href" href="javascript:void()">Kirim ulang otp</a>
      </div>
      <div class="form-group">
        <input wire:model="" type="text" class="form-control mt-3 text-center" id="email_login" placeholder="Masukkan 6 digit kode OTP">
        <button type="button" class="btn btn-primary btn-block mt-3" wire:click=''>
          <span wire:loading.remove>Konfirmasi</span>
          <span wire:loading>Verifikasi...</span>
        </button>
      </div>
    </div>
  </div>
</div>
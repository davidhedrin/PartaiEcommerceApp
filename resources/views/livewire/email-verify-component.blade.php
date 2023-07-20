<div>
  <style>
    .color-href {
      color: rgb(24, 109, 255) !important;
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
        <h2>Verifikasi Email</h2>
      </div>
      <div class="text-center mb-4">
        <span>Terimakasih telah mendaftar, verifikasi email untuk melanjutkan proses pendaftaran.</span>
      </div>

      <h5 class="text-center mb-3" style="font-weight: bold; text-decoration: underline">{{ Auth::user()->email }}</h5>
      <div class="form-group">
        <button type="button" class="btn btn-primary btn-block" wire:click='sendEmailVerify'>
          <span wire:loading.remove>Kirim Verifikasi</span>
          <span wire:loading>Mengirim Email...</span>
        </button>
      </div>
    </div>
  </div>
</div>
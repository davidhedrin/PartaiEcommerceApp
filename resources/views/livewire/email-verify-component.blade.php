<div>
  <style>
    .color-href {
      color: rgb(24, 109, 255) !important;
    }
  </style>

  @if (Session::has('msgAlert'))
  {{-- <div id="overlay-bg-toast"></div> --}}
  <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true"
    style="position: fixed; z-index: 99999; top: 25px; right: 20px;">
    <div class="toast-header d-flex justify-content-between">
      <img src="{{ asset('logo/logo2.png') }}" class="rounded mr-2" alt="" width="160px">
      <button onclick="hideToastAlert()" type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      <span class="text-{{ strtolower(Session::get('msgStatus')) }}">{{ Session::get('msgStatus') }}</span><br>
      {{ Session::get('msgAlert') }}
    </div>
  </div>
  @endif

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
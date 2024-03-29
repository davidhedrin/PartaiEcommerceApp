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
        <h2>Lupa Password</h2>
      </div>
      <div class="text-center mb-4">
        <span>Jika email terdaftar, maka kami akan kirimkan link untuk merubah password melalui email.</span>
      </div>
      <form wire:submit.prevent='sendLinkResetPass' wire:ignore.self>
        <div class="form-group">
          <input wire:model="email" type="text" class="form-control" id="email_login"
            placeholder="Masukkan alamat email">
          @error('email')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">
            <span wire:loading.remove wire:loading.attr='disabled' wire:target='sendLinkResetPass'>
              Kirim
            </span>
            <span wire:loading wire:target='sendLinkResetPass'>
              Verifikasi...
            </span>
          </button>
        </div>
        <div class="form-group">
          <p>Kembali kehalaman <a class="color-href" href="{{ route('login') }}">Login</a></p>
        </div>
      </form>
    </div>
  </div>
</div>
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
        <h2>Ubah Password</h2>
      </div>

      <h5 class="text-center mb-4" style="font-weight: bold; text-decoration: underline">{{ $email }}</h5>

      <div class="text-center mb-4">
        <span>Atur Ulang Password 🚀</span><br>
        <span>Pastikan untuk mengingat password baru!</span>
      </div>
      <form wire:submit.prevent='saveNewPassword' wire:ignore.self>
        <div class="form-group">
          <div class="form-group">
            <label for="new_password">Password Baru</label>
            <input wire:model="newPassword" type="password" class="form-control" id="new_password"
              placeholder="********">
            @error('newPassword')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
          <div class="form-group">
            <label for="co_new_password">Konfirmasi Password</label>
            <input wire:model="coNewPassword" type="password" class="form-control" id="co_new_password"
              placeholder="********">
            @error('coNewPassword')
            <span class="text-danger">{{ $message }}</span>
            @enderror
          </div>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">
            <span wire:loading.remove wire:loading.attr='disabled' wire:target='saveNewPassword'>
              Simpan Password
            </span>
            <span wire:loading wire:target='saveNewPassword'>
              Menyimpan...
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
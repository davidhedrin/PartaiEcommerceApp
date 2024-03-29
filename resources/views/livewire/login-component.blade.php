<div>
  <style>
    .color-href {
      color: rgb(24, 109, 255) !important;
    }
  </style>

  @include('livewire.component.toast-alert')

  <div class="row justify-content-center mt-5">
    <div class="col-md-5" wire:ignore.self>
      <div class="text-center mb-3">
        <a href="{{ route('home') }}">
          <img src="{{ asset('logo/logo1.png') }}" width="400px" alt="">
        </a>
      </div>
      <div class="section-title">
        @if ($loginOrRegis)
        <h2>Login</h2>
        @else
        <h2>Register</h2>
        @endif
      </div>
      <div class="text-center mb-4">
        <span>Selamat datang di Jakarta Trading.</span><br>
        @if ($loginOrRegis)
        <span>Masukkan Email dan Password.</span>
        @else
        <span>Mulailah jadi bagian dari kami dan nikmati pelayanan terbaik dari Jakarta Trading.</span>
        @endif
      </div>
      @if ($loginOrRegis)
      <form wire:submit.prevent='loginUser()'>
        <div class="form-group">
          <label for="email_login">Email</label>
          <input wire:model="emailLogin" type="text" class="form-control" id="email_login"
            placeholder="Masukkan alamat email">
          @error('emailLogin')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="password_login">Password</label>
          <input wire:model="passwordLogin" type="password" class="form-control" id="password_login"
            placeholder="********">
          @error('passwordLogin')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <a href="{{ route('forgot.pass') }}" class="color-href">Lupa Password?</a>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
        <div class="form-group">
          <p>Belum mempunya akun? <a class="color-href" href="javascript:void(0)" wire:click="changeLoginOrRegis">Daftar
              disini</a></p>
        </div>
      </form>
      @else
      <form wire:submit.prevent='addRegisterData()'>
        <div class="form-group">
          <label for="nama_lengkap">Nama Lengkap</label>
          <input wire:model="name" type="text" class="form-control" id="nama_lengkap"
            placeholder="Masukkan nama lengkap">
          @error('name')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email_regis">Email</label>
          <input wire:model="email" type="text" class="form-control" id="email_regis"
            placeholder="Masukkan alamat email">
          @error('email')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="no_ponsel">No Ponsel</label>
          <input wire:model="no_ponsel" type="text" class="form-control" id="no_ponsel"
            placeholder="Masukkan nomor ponsel">
          @error('no_ponsel')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="password_regis">Password</label>
          <input wire:model="password" type="password" class="form-control" id="password_regis" placeholder="********">
          @error('password')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="co_password_regis">Konfrimasi Password</label>
          <input wire:model="co_password" type="password" class="form-control" id="co_password_regis"
            placeholder="********">
          @error('co_password')
          <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </div>
        <div class="form-group">
          <p>Sudah mempunya akun? <a class="color-href" href="javascript:void(0)"
              wire:click="changeLoginOrRegis">Login</a></p>
        </div>
      </form>
      @endif
    </div>
  </div>
</div>
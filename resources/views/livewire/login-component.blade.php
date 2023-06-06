<div>
  <style>
    .color-href {
      color: rgb(24, 109, 255) !important;
    }
  </style>
  
  @if (Session::has('msgAlert'))
    <div id="overlay-bg-toast"></div>
    <div class="show-toast-alert toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
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

  <div class="row justify-content-center mt-3">
    <div class="col-md-5" wire:ignore.self>
      <div class="section-title from-blog__title">
        @if ($loginOrRegis)
        <h2>Login</h2>
        @else
        <h2>Register</h2>
        @endif
      </div>
      @if ($loginOrRegis)
      <form wire:submit.prevent='loginUser()'>
        <div class="form-group">
          <label for="email_login">Email</label>
          <input wire:model="emailLogin" type="text" class="form-control" id="email_login" placeholder="Masukkan alamat email">
          @error('emailLogin')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="password_login">Password</label>
          <input wire:model="passwordLogin" type="password" class="form-control" id="password_login" placeholder="********">
          @error('passwordLogin')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <a href="#" class="color-href">Lupa Password?</a>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">Login</button>
        </div>
        <div class="form-group">
          <p>Belum mempunya akun? <a class="color-href" href="javascript:void(0)" wire:click="changeLoginOrRegis">Daftar disini</a></p>
        </div>
      </form>
      @else
      <form wire:submit.prevent='addRegisterData()'>
        <div class="form-group">
          <label for="nama_lengkap">Nama Lengkap</label>
          <input wire:model="name" type="text" class="form-control" id="nama_lengkap" placeholder="Masukkan nama lengkap">
          @error('name')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="email_regis">Email</label>
          <input wire:model="email" type="text" class="form-control" id="email_regis" placeholder="Masukkan alamat email">
          @error('email')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="no_ponsel">No Ponsel</label>
          <input wire:model="no_ponsel" type="text" class="form-control" id="no_ponsel" placeholder="Masukkan nomor ponsel">
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
          <input wire:model="co_password" type="password" class="form-control" id="co_password_regis" placeholder="********">
          @error('co_password')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="alamat_regis">Alamat</label>
          <textarea wire:model="alamat" class="form-control" id="alamat_regis" rows="3" placeholder="Masukkan alamat rumah"></textarea>
          @error('alamat')
              <span class="text-danger">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </div>
        <div class="form-group">
          <p>Sudah mempunya akun? <a class="color-href" href="javascript:void(0)" wire:click="changeLoginOrRegis">Login</a></p>
        </div>
      </form>
      @endif
    </div>
  </div>
</div>
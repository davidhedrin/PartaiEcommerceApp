<div>
  <style>
    .color-href {
      color: rgb(24, 109, 255) !important;
    }
  </style>
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
      <form>
        <div class="form-group">
          <label for="email_login">Email</label>
          <input type="text" class="form-control" id="email_login" placeholder="Masukkan alamat email">
        </div>
        <div class="form-group">
          <label for="password_login">Password</label>
          <input type="password" class="form-control" id="password_login" placeholder="********">
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
      <form>
        <div class="form-group">
          <label for="nama_lengkap">Nama Lengkap</label>
          <input type="text" class="form-control" id="nama_lengkap" placeholder="Masukkan nama lengkap">
        </div>
        <div class="form-group">
          <label for="email_regis">Email</label>
          <input type="text" class="form-control" id="email_regis" placeholder="Masukkan alamat email">
        </div>
        <div class="form-group">
          <label for="no_ponsel">No Ponsel</label>
          <input type="text" class="form-control" id="no_ponsel" placeholder="Masukkan nomor ponsel">
        </div>
        <div class="form-group">
          <label for="password_regis">Password</label>
          <input type="password" class="form-control" id="password_regis" placeholder="********">
        </div>
        <div class="form-group">
          <label for="co_password_regis">Konfrimasi Password</label>
          <input type="password" class="form-control" id="co_password_regis" placeholder="********">
        </div>
        <div class="form-group">
          <label for="alamat">Alamat</label>
          <textarea class="form-control" id="alamat" rows="3" placeholder="Masukkan alamat rumah"></textarea>
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
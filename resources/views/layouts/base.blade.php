@php
$url = '';

try {
$url .= $_SERVER['REQUEST_URI'];
} catch (Exception $ex) {
$error_msg = $ex->getMessage();
HalperFunctions::insertLogError('ExceptionGuide', 'GetDataCurrentServer', 'Exception', $error_msg);
}
$url = str_replace('/', '', $url);

$curRouteName = Route::currentRouteName();
$logicHeader = false;
$logicNavCateg = false;

if ($curRouteName != 'login' && $curRouteName != 'forgot.pass') {
$logicHeader = true;
}
if (
  $curRouteName != 'login' && 
  $curRouteName != 'forgot.pass' && 
  $curRouteName != 'verification.notice' &&
  $curRouteName != 'password.reset' &&
  $curRouteName != 'otp-admin'
) {
  $logicNavCateg = true;
}
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="description" content="Ogani Template">
  <meta name="keywords" content="Ogani, unica, creative, html">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/x-icon" href="{{ asset('logo/logoPng.png') }}" />
  <title>{{ env('APP_NAME') }}</title>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

  <!-- Css Styles -->
  <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/elegant-icons.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/slicknav.min.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" type="text/css">
  <style>
    .show-toast-alert {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 99;
      width: 300px;
    }

    #overlay-bg-toast {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.6);
      z-index: 1;
      pointer-events: none;
    }

    .col-button-img {
      position: relative;
      margin: 15px 0;
    }

    .col-button-img img {
      width: 100%;
      object-fit: cover;
      mix-blend-mode: multiply;
    }

    @media only screen and (max-width: 600px) {
      .col-button-img img {
        width: 150px;
      }
    }
  </style>
  @livewireStyles
</head>

<body>
  <!-- Page Preloder -->
  <div class="loading" id="preloder">
    <div class="loader"></div>
    <h5 style="padding-top: 10px; color: white">loading...</h5>
  </div>

  <!-- Humberger Begin -->
  <div class="humberger__menu__overlay"></div>
  <div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo">
      <a href="#"><img src="{{ asset('logo/logo1.png') }}" alt="" width="250px"></a>
    </div>
    <div class="humberger__menu__cart">
      <ul class="mb-2">
        <li>
          <a href="{{ route('whitelist') }}">
            <i class="fa fa-heart"></i>
            @if (Auth::user())
            <span><livewire:component.whitelist-counter></span>
            @endif
          </a>
        </li>
        <li>
          <a href="{{ route('shoping-cart') }}">
            <i class="fa fa-shopping-bag"></i>
            @if (Auth::user())
            <span><livewire:component.cart-counter></span>
            @endif
          </a>
        </li>
        @if (Auth::user())
        <li>
          <a href="#">
            <i class="fa fa-user-circle-o"></i>
          </a>
        </li>
        @endif
      </ul>
      @if (Auth::user())
      <div class="header__cart__price">Hallo, <span>{{ Auth::user()->name }}</span></div>
      @else
      <div class="header__cart__price">Hallo, <span>Selamat datang!</span></div>
      @endif
    </div>
    <div class="humberger__menu__widget">
      <div class="header__top__right__auth">
        @if (Auth::user())
        @if (Auth::user()->user_type == 1)
        <a href="{{ route('adm-dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a>
        @endif
        @endif
      </div>
      <div class="header__top__right__auth">
        @if (Auth::user())
        <a href="javascript:void(0)" data-toggle="modal" data-target="#logoutModal"><i
            class="fa fa-sign-out {{ Auth::user()->user_type == 1 ? 'ml-3' : '' }}"></i> Logout</a>
        @else
        <a href="{{ route('login') }}"><i class="fa fa-user"></i> Login/Register</a>
        @endif
      </div>
    </div>
    <nav class="humberger__menu__nav mobile-menu">
      <ul>
        <li class="{{ $url == '' ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('shop') }}">Shop</a></li>
        <li><a href="./blog.html">About US</a></li>
        <li class="{{ $url == 'contact-us' ? 'active' : '' }}"><a href="{{ route('contact-us') }}">Contact</a></li>
      </ul>
    </nav>
    <div id="mobile-menu-wrap"></div>
    @if ($sosmed)
    <div class="header__top__right__social">
      @foreach ($sosmed as $med)
      <a href="{{ $med->url }}" target="_blank"><i class="fa fa-{{ $med->name }}"></i></a>
      @endforeach
    </div>
    @endif
    <div class="humberger__menu__contact">
      <ul>
        <li><i class="fa fa-envelope"></i> {{ $email }}</li>
        <li>Free Shipping for all Order of $99</li>
      </ul>
    </div>
  </div>
  <!-- Humberger End -->

  <!-- Header Section Begin -->
  <header class="header">
    <div class="header__top">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-6">
            <div class="header__top__left">
              <ul>
                <li><i class="fa fa-envelope"></i> {{ $email }}</li>
                <li>Free Shipping for all Order of $99</li>
              </ul>
            </div>
          </div>
          <div class="col-lg-6 col-md-6">
            <div class="header__top__right">
              @if ($sosmed)
              <div class="header__top__right__social">
                @foreach ($sosmed as $med)
                <a href="{{ $med->url }}" target="_blank"><i class="fa fa-{{ $med->name }}"></i></a>
                @endforeach
              </div>
              @endif
              <div class="header__top__right__auth">
                @if (Auth::user())
                @if (Auth::user()->user_type == 1)
                <a href="{{ route('adm-dashboard') }}"><i class="fa fa-tachometer"></i> Dashboard</a>
                @endif
                @endif
              </div>
              <div class="header__top__right__auth">
                @if (Auth::user())
                <a href="javascript:void(0)" data-toggle="modal" data-target="#logoutModal"><i
                    class="fa fa-sign-out {{ Auth::user()->user_type == 1 ? 'ml-3' : '' }}"></i> Logout</a>
                @else
                <a href="{{ route('login') }}"><i class="fa fa-user"></i> Login/Register</a>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @if ($logicHeader)
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="header__logo">
            <a href="{{ route('home') }}"><img src="{{ asset('logo/logo1.png') }}" alt="" width="260px"></a>
          </div>
        </div>
        <div class="col-lg-5">
          <nav class="header__menu">
            <ul>
              <li class="{{ $url == '' ? 'active' : '' }}"><a href="{{ route('home') }}">Home</a></li>
              <li class="{{ $url == 'shop' ? 'active' : '' }}"><a href="{{ route('shop') }}">Shop</a></li>
              <li><a href="./blog.html">About US</a></li>
              <li class="{{ $url == 'contact-us' ? 'active' : '' }}"><a href="{{ route('contact-us') }}">Contact</a>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-lg-4">
          <div class="header__cart">
            <ul>
              <li>
                <a href="{{ route('whitelist') }}">
                  <i class="fa fa-heart"></i>
                  @if (Auth::user())
                  <span><livewire:component.whitelist-counter></span>
                  @endif
                </a>
              </li>
              <li>
                <a href="{{ route('shoping-cart') }}">
                  <i class="fa fa-shopping-bag"></i>
                  @if (Auth::user())
                  <span><livewire:component.cart-counter></span>
                  @endif
                </a>
              </li>
              @if (Auth::user())
              <li>
                <a href="#">
                  <i class="fa fa-user-circle-o"></i>
                </a>
              </li>
              @endif
            </ul>
            @if (Auth::user())
            <div class="header__cart__price">Hallo, <span>{{ Auth::user()->name }}</span></div>
            @else
            <div class="header__cart__price">Hallo, <span>Selamat datang!</span></div>
            @endif
          </div>
        </div>
      </div>
      <div class="humberger__open">
        <i class="fa fa-bars"></i>
      </div>
    </div>
    @endif
  </header>
  <!-- Header Section End -->

  @if ($logicNavCateg)
  <section class="hero hero-normal">
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="hero__categories">
            <div class="hero__categories__all">
              <i class="fa fa-bars"></i>
              <span>All departments</span>
            </div>
            <ul>
              <li><a href="#">Fresh Meat</a></li>
              <li><a href="#">Vegetables</a></li>
              <li><a href="#">Fruit & Nut Gifts</a></li>
              <li><a href="#">Fresh Berries</a></li>
              <li><a href="#">Ocean Foods</a></li>
              <li><a href="#">Butter & Eggs</a></li>
              <li><a href="#">Fastfood</a></li>
              <li><a href="#">Fresh Onion</a></li>
              <li><a href="#">Papayaya & Crisps</a></li>
              <li><a href="#">Oatmeal</a></li>
              <li><a href="#">Fresh Bananas</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-9">
          <div class="hero__search">
            <div class="hero__search__form">
              <form action="#">
                <input type="text" placeholder="What do yo u need?">
                <button type="submit" class="site-btn">SEARCH</button>
              </form>
            </div>
            <div class="hero__search__phone">
              <div class="hero__search__phone__icon">
                <i class="fa fa-phone"></i>
              </div>
              <div class="hero__search__phone__text">
                <h5>{{ $contact }}</h5>
                <span>support 24/7 time</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endif

  <div class="container">
    {{ $slot }}
  </div>

  <!-- Footer Section Begin -->
  <footer class="footer spad mt-4">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="col-lg-2 mx-2 text-center col-button-img">
          <a href="https://www.kemendag.go.id/" target="_blank">
            <img src="{{ asset('assets/img/footer_sponsor/perdagangan.jpeg') }}" alt="">
          </a>
        </div>
        <div class="col-lg-2 mx-2 text-center col-button-img">
          <a href="http://www.bkpm.go.id" target="_blank">
            <img src="{{ asset('assets/img/footer_sponsor/bkpm.jpeg') }}" alt="">
          </a>
        </div>
        <div class="col-lg-2 mx-2 text-center col-button-img">
          <a href="http://www.kemenperin.go.id" target="_blank">
            <img src="{{ asset('assets/img/footer_sponsor/ministriofindustri.jpeg') }}" alt="">
          </a>
        </div>
        <div class="col-lg-2 mx-2 text-center col-button-img">
          <a href="http://www.kemenkeu.go.id" target="_blank">
            <img src="{{ asset('assets/img/footer_sponsor/kemenkeu.jpeg') }}" alt="">
          </a>
        </div>
        <div class="col-lg-2 mx-2 text-center col-button-img">
          <a href="http://www.deptan.go.id" target="_balnk">
            <img src="{{ asset('assets/img/footer_sponsor/deptan.jpeg') }}" alt="">
          </a>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="footer__about">
            <div class="footer__about__logo">
              <a href="{{ route('home') }}"><img src="{{ asset('logo/logo1.png') }}" alt=""></a>
            </div>
            <ul>
              <li>Address: {{ $address}}</li>
              <li>Phone: {{ $contact }}</li>
              <li>Email: {{ $email }}</li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
          <div class="footer__widget">
            <h6>Useful Links</h6>
            <ul>
              <li><a href="#">About Us</a></li>
              <li><a href="#">About Our Shop</a></li>
              <li><a href="#">Secure Shopping</a></li>
              <li><a href="#">Delivery infomation</a></li>
              <li><a href="#">Privacy Policy</a></li>
              <li><a href="#">Our Sitemap</a></li>
            </ul>
            <ul>
              <li><a href="#">Who We Are</a></li>
              <li><a href="#">Our Services</a></li>
              <li><a href="#">Projects</a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">Innovation</a></li>
              <li><a href="#">Testimonials</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4 col-md-12">
          <div class="footer__widget">
            <h6>Join Our Newsletter Now</h6>
            <p>Get E-mail updates about our latest shop and special offers.</p>
            <form>
              <input type="text" placeholder="Enter your mail">
              <button type="button" class="site-btn">Subscribe</button>
            </form>
            @if ($sosmed)
            <div class="footer__widget__social">
              @foreach ($sosmed as $med)
              <a href="{{ $med->url }}" target="_blank"><i class="fa fa-{{ $med->name }}"></i></a>
              @endforeach
            </div>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="footer__copyright">
            <div class="footer__copyright__text">
              <p>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;
                <script>
                  document.write(new Date().getFullYear());
                </script> by Felix Tobing</a>
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              </p>
            </div>
            <div class="footer__copyright__payment"><img src="{{ asset('assets/img/payment-item') }}.png" alt=""></div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <!-- Footer Section End -->

  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">

          <img src="{{ asset('logo/logo2.png') }}" class="rounded mr-2" alt="" width="160px">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">
          Yakin ingin keluar mengakhiri?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Batal</button>
          <a href="{{ route('logout') }}" type="button" class="btn btn-secondary btn-sm">Keluar</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Js Plugins -->
  <script src="{{ asset('assets/js/jquery-3.3.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.nice-select.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.slicknav.js') }}"></script>
  <script src="{{ asset('assets/js/mixitup.min.js') }}"></script>
  <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('assets/js/main.js') }}"></script>
  <script>
    function hideToastAlert() {
      $('.toast').toast('hide');
      $('#overlay-bg-toast').hide();
    }
  </script>
  @stack('scripts')
  @livewireScripts
</body>

</html>
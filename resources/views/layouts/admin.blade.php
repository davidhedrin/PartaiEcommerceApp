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
@endphp

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
  data-assets-path="{{ asset('assetz/') }}" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>{{ env('APP_NAME') }} - Dashboard</title>

  <meta name="description" content="" />

  <link rel="icon" type="image/x-icon" href="{{ asset('logo/logoPng.png') }}" />

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <link rel="stylesheet" href="{{ asset('assetz/vendor/fonts/boxicons.css') }}" />
  <link rel="stylesheet" href="{{ asset('assetz/vendor/css/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('assetz/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('assetz/css/demo.css') }}" />
  <link rel="stylesheet" href="{{ asset('assetz/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('assetz/vendor/libs/apex-charts/apex-charts.css') }}" />
  <script src="{{ asset('assetz/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('assetz/js/config.js') }}"></script>
  @livewireStyles
</head>

<body>
  <div class="modal fade" id="logoutModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="{{ asset('logo/logo2.png') }}" width="170px" alt="">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <span>Yakin ingin keluar dari aplikasi?</span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <a href="{{ route('logout') }}" class="btn btn-primary">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="{{ route('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
              <img src="{{ asset('logo/logo2.png') }}" width="190px" alt="">
            </span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <li class="menu-item {{ $curRouteName == 'adm-dashboard' ? 'active' : '' }}">
            <a href="{{ route('adm-dashboard') }}" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div data-i18n="Analytics">Dashboard</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('home') }}" class="menu-link">
              <i class='menu-icon tf-icons bx bx-store-alt bx-tada'></i>
              <div data-i18n="Analytics">Ke Toko</div>
            </a>
          </li>

          <li class="menu-header small text-uppercase"><span class="menu-header-text">Ecommerce</span></li>
          <li class="menu-item {{ $curRouteName == 'adm-orders' ? 'active' : '' }}">
            <a href="{{ route('adm-orders') }}" class="menu-link">
              <i class='menu-icon tf-icons bx bx-basket'></i>
              <div data-i18n="Tables">Pesanan <span class="badge rounded-pill bg-danger">12</span></div>
            </a>
          </li>
          <li class="menu-item {{ $curRouteName == 'adm-product' ? 'active' : '' }}">
            <a href="{{ route('adm-product') }}" class="menu-link">
              <i class='menu-icon tf-icons bx bx-package'></i>
              <div data-i18n="Tables">Produk</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
              <i class='menu-icon tf-icons bx bx-street-view'></i>
              <div data-i18n="Tables">Seller</div>
            </a>
          </li>

          <li class="menu-header small text-uppercase"><span class="menu-header-text">Component</span></li>
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
              <i class='menu-icon tf-icons bx bx-card'></i>
              <div data-i18n="Tables">Banner</div>
            </a>
          </li>
          <li class="menu-item {{ $curRouteName == 'adm-category' ? 'active' : '' }}">
            <a href="{{ route('adm-category') }}" class="menu-link">
              <i class='menu-icon tf-icons bx bx-category'></i>
              <div data-i18n="Tables">Kategori</div>
            </a>
          </li>
          <li class="menu-item {{ $curRouteName == 'adm-voucher' ? 'active' : '' }}">
            <a href="{{ route('adm-voucher') }}" class="menu-link">
              <i class='menu-icon tf-icons bx bxs-discount'></i>
              <div data-i18n="Form Layouts">Voucher</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
              <i class='menu-icon tf-icons bx bx-comment-detail'></i>
              <div data-i18n="Tables">Testimonial</div>
            </a>
          </li>

          @if (Auth::user()->user_type == 1)
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Admin Panel</span></li>
            <li class="menu-item {{ $curRouteName == 'adm-ecomsetting' ? 'active' : '' }}">
              <a href="{{ route('adm-ecomsetting') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-news'></i>
                <div data-i18n="Tables">Ecom Setting</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="javascript:void(0);" class="menu-link">
                <i class='menu-icon tf-icons bx bx-group'></i>
                <div data-i18n="Tables">User Management</div>
              </a>
            </li>
          @endif

          <li class="menu-header small text-uppercase"><span class="menu-header-text">Pengaturan</span></li>
          <li class="menu-item">
            <a href="javascript:void(0);" class="menu-link">
              <i class='menu-icon tf-icons bx bx-cog'></i>
              <div data-i18n="Tables">My Profile</div>
            </a>
          </li>
          <li class="menu-item">
            <div class="menu-link cursor-pointer" data-bs-toggle="modal" data-bs-target="#logoutModal">
              <i class='menu-icon tf-icons bx bx-log-out'></i>
              <div data-i18n="Documentation">Logout</div>
            </div>
          </li>
        </ul>
      </aside>

      <div class="layout-page">
        <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
          id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <div class="navbar-nav align-items-center">
              <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input type="text" class="form-control border-0 shadow-none" placeholder="Search..."
                  aria-label="Search..." />
              </div>
            </div>

            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <li class="nav-item lh-1 me-3">
                <a class="github-button" href="https://github.com/themeselection/sneat-html-admin-template-free"
                  data-icon="octicon-star" data-size="large" data-show-count="true"
                  aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">Star
                </a>
              </li>

              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="{{ asset('assetz/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="{{ asset('assetz/img/avatars/1.png') }}" alt
                              class="w-px-40 h-auto rounded-circle" />
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block">{{ Auth::user()->name }}</span>
                          <small class="text-muted">Admin</small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <i class="bx bx-user me-2"></i>
                      <span class="align-middle">My Profile</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <i class="bx bx-cog me-2"></i>
                      <span class="align-middle">Settings</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="d-flex align-items-center align-middle">
                        <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                        <span class="flex-grow-1 align-middle">Billing</span>
                        <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                      </span>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <div class="dropdown-item cursor-pointer" data-bs-toggle="modal" data-bs-target="#logoutModal">
                      <i class="bx bx-power-off me-2"></i>
                      <span class="align-middle">Logout</span>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>

        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            {{ $slot }}
          </div>

          <!-- Footer -->
          <footer class="content-footer footer bg-light">
            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
              <div class="mb-2 mb-md-0">
                ©
                <script>
                  document.write(new Date().getFullYear());
                </script>
                , made with ❤️ by
                <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
              </div>
              <div>
                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                  target="_blank" class="footer-link me-4">Documentation</a>

                <a href="https://github.com/themeselection/sneat-html-admin-template-free/issues" target="_blank"
                  class="footer-link me-4">Support</a>
              </div>
            </div>
          </footer>
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
      </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>

  <script src="{{ asset('assetz/vendor/libs/jquery/jquery.js') }}"></script>
  <script src="{{ asset('assetz/vendor/libs/popper/popper.js') }}"></script>
  <script src="{{ asset('assetz/vendor/js/bootstrap.js') }}"></script>
  <script src="{{ asset('assetz/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
  <script src="{{ asset('assetz/vendor/js/menu.js') }}"></script>
  <script src="{{ asset('assetz/vendor/libs/apex-charts/apexcharts.js') }}"></script>
  <script src="{{ asset('assetz/js/main.js') }}"></script>
  <script src="{{ asset('assetz/js/dashboards-analytics.js') }}"></script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <script>
    document.querySelectorAll('input[type-currency="IDR"]').forEach((element) => {
      element.addEventListener('keyup', function(e) {
        let cursorPostion = this.selectionStart;
        let value = parseInt(this.value.replace(/[^,\d]/g, ''));
        let originalLenght = this.value.length;
        if (isNaN(value)) {
          this.value = "";
        } else {
          this.value = value.toLocaleString('id-ID', {
            currency: 'IDR',
            style: 'currency',
            minimumFractionDigits: 0
          });
          cursorPostion = this.value.length - originalLenght + cursorPostion;
          this.setSelectionRange(cursorPostion, cursorPostion);
        }
      });
    });

    function copyTextClipboard(text){
        const $tempInput = $('<input>');
        $tempInput.val(text);

        $(document.body).append($tempInput);
        $tempInput.select();
        document.execCommand('copy');
        $tempInput.remove();
    }
  </script>

  @stack('scripts')
  @livewireScripts
</body>

</html>

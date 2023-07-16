<div>
  @if (Session::has('msgAlert'))
    <div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000" style="background-color: white !important;">
      <div class="toast-header">
        <img src="{{ asset('assets/img/logo.png') }}" class="rounded mr-2" alt="" width="50px">
        <div class="me-auto fw-semibold"></div>
        <small class="text-{{ strtolower(Session::get('msgStatus')) }}">{{ Session::get('msgStatus') }}</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        {{ Session::get('msgAlert') }}
      </div>
    </div>
  @endif

  <div class="row mb-4">
    <div class="col text-center">
      <img src="{{ asset('logo/logo1.png') }}" alt="user-avatar" class="img-fluid">
    </div>
  </div>
  
  <div class="row">
    <div class="col-lg-12 mb-4 order-0">
      <div class="card">
        <div class="d-flex align-items-end row">
          <div class="col-sm-7">
            <div class="card-body">
              <h5 class="card-title text-primary">Selamat datang, {{ Auth::user()->name }}</h5>
              <p class="mb-4">
                You have done <span class="fw-bold">72%</span> more sales today. Check your new badge in
                your profile.
              </p>

              <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
            </div>
          </div>
          <div class="col-sm-5 text-end text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
              <img src="{{ asset('assetz/img/illustrations/man-with-laptop-light.png') }}" height="140"
                alt="View Badge User" data-app-dark-img="illustrations/man-with-laptop-dark.png"
                data-app-light-img="illustrations/man-with-laptop-light.png" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-primary">
                <i class='bx bx-time' style="font-size: 23px;"></i>
              </span>
            </div>
            <div class="dropdown">
              <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
              </div>
            </div>
          </div>
          <span>Sales</span>
          <h3 class="card-title text-nowrap mb-1">$4,679</h3>
          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-primary">
                <i class='bx bx-time' style="font-size: 23px;"></i>
              </span>
            </div>
            <div class="dropdown">
              <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
              </div>
            </div>
          </div>
          <span>Sales</span>
          <h3 class="card-title text-nowrap mb-1">$4,679</h3>
          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-primary">
                <i class='bx bx-time' style="font-size: 23px;"></i>
              </span>
            </div>
            <div class="dropdown">
              <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
              </div>
            </div>
          </div>
          <span>Sales</span>
          <h3 class="card-title text-nowrap mb-1">$4,679</h3>
          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="card">
        <div class="card-body">
          <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
              <span class="avatar-initial rounded bg-label-primary">
                <i class='bx bx-time' style="font-size: 23px;"></i>
              </span>
            </div>
            <div class="dropdown">
              <button class="btn p-0" type="button" id="cardOpt6" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
              </button>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt6">
                <a class="dropdown-item" href="javascript:void(0);">View More</a>
                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
              </div>
            </div>
          </div>
          <span>Sales</span>
          <h3 class="card-title text-nowrap mb-1">$4,679</h3>
          <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> +28.42%</small>
        </div>
      </div>
    </div>
  </div>
</div>
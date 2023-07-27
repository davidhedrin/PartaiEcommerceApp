<div>
    @if (Session::has('msgAlert'))
      <div class="bs-toast toast toast-placement-ex m-2 fade top-0 end-0 show" role="alert" aria-live="assertive"
        aria-atomic="true" data-delay="2000" style="background-color: white !important;">
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
</div>

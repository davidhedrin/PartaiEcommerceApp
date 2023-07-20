<div>
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
</div>

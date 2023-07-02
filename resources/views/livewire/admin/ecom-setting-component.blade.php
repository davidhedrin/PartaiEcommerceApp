<div>
  <ul class="nav nav-pills flex-column flex-md-row mb-3">
    <li class="nav-item"><a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i>
        Account</a></li>
    <li class="nav-item"><a class="nav-link" href="pages-account-settings-notifications.html"><i
          class="bx bx-bell me-1"></i> Notifications</a></li>
    <li class="nav-item"><a class="nav-link" href="pages-account-settings-connections.html"><i
          class="bx bx-link-alt me-1"></i> Connections</a></li>
  </ul>
  <div class="card mb-4">
    <h5 class="card-header">Profile Details</h5>
    <!-- Account -->
    <div class="card-body">
      <div class="row">
        <div class="col text-center">
          <img src="{{ asset('logo/logo1.png') }}" alt="user-avatar" class="img-fluid">
        </div>
      </div>
    </div>
    <hr class="my-0">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label" for="basic-icon-default-company">Company</label>
          <div class="input-group input-group-merge">
            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-buildings"></i></span>
            <input type="text" id="basic-icon-default-company" class="form-control" placeholder="ACME Inc." aria-label="ACME Inc." aria-describedby="basic-icon-default-company2">
          </div>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label" for="basic-icon-default-company">Company</label>
          <div class="input-group input-group-merge">
            <span id="basic-icon-default-company2" class="input-group-text"><i class="bx bx-buildings"></i></span>
            <input type="text" id="basic-icon-default-company" class="form-control" placeholder="ACME Inc." aria-label="ACME Inc." aria-describedby="basic-icon-default-company2">
          </div>
        </div>
      </div>
    </div>
    <!-- /Account -->
  </div>
  <div class="card">
    <h5 class="card-header">Delete Account</h5>
    <div class="card-body">
      <div class="mb-3 col-12 mb-0">
        <div class="alert alert-warning">
          <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
          <p class="mb-0">Once you delete your account, there is no going back. Please be certain.</p>
        </div>
      </div>
      <form id="formAccountDeactivation" onsubmit="return false">
        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation">
          <label class="form-check-label" for="accountActivation">I confirm my account deactivation</label>
        </div>
        <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
      </form>
    </div>
  </div>
</div>
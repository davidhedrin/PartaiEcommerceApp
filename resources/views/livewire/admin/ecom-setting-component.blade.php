<div>
  <div class="nav-align-top mb-4">
    <ul class="nav nav-pills mb-3" role="tablist">
      <li class="nav-item">
        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
          aria-controls="navs-pills-top-home" aria-selected="false">Home</button>
      </li>
      <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
          data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
          aria-selected="true">Profile</button>
      </li>
      <li class="nav-item">
        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-messages"
          aria-controls="navs-pills-top-messages" aria-selected="false">Messages</button>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade active show" id="navs-pills-top-home" role="tabpanel">
        <h5>Company Details</h5>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label class="form-label" for="company_email">Email</label>
            <div class="input-group input-group-merge">
              <span id="company_email2" class="input-group-text"><i class='bx bx-envelope'></i></span>
              <input type="text" id="company_email" class="form-control" placeholder="Enter email address"
                aria-label="Enter email address" aria-describedby="company_email2">
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <label class="form-label" for="no_ponsel">No Phone</label>
            <div class="input-group input-group-merge">
              <span id="no_ponsel2" class="input-group-text"><i class="bx bx-phone"></i></span>
              <input type="text" id="no_ponsel" class="form-control" placeholder="082112341234"
                aria-label="082112341234" aria-describedby="no_ponsel2">
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <label class="form-label" for="company_address">Address</label>
            <div class="input-group input-group-merge">
              <span id="company_address2" class="input-group-text"><i class='bx bx-map-pin'></i></span>
              <textarea class="form-control" name="" id="company_address" rows="1" placeholder="Enter company address"
              aria-label="Enter company address" aria-describedby="company_address2"></textarea>
            </div>
          </div>
        </div>

        <hr>

        <h5>Social Media</h5>
        <div class="row">
          <div class="col-4">
            <div class="d-flex mb-3">
              <div class="flex-shrink-0">
                <img src="{{ asset('assetz/img/icons/brands/facebook.png') }}" alt="twitter" class="me-3" height="30">
              </div>
              <div class="flex-grow-1 row">
                <div class="col-8 col-sm-7 mb-sm-0 mb-2">
                  <h6 class="mb-0">Twitter</h6>
                  <a href="https://twitter.com/Theme_Selection" target="_blank">@ThemeSelection</a>
                </div>
                <div class="col-4 col-sm-5 text-end">
                  <button type="button" class="btn btn-icon btn-outline-danger">
                    <i class="bx bx-trash-alt"></i>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <hr>
        
        <h5>Delete Account</h5>
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
      <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
        <p>
          Donut dragée jelly pie halvah. Danish gingerbread bonbon cookie wafer candy oat cake ice cream. Gummies
          halvah
          tootsie roll muffin biscuit icing dessert gingerbread. Pastry ice cream cheesecake fruitcake.
        </p>
        <p class="mb-0">
          Jelly-o jelly beans icing pastry cake cake lemon drops. Muffin muffin pie tiramisu halvah cotton candy
          liquorice caramels.
        </p>
      </div>
      <div class="tab-pane fade" id="navs-pills-top-messages" role="tabpanel">
        <p>
          Oat cake chupa chups dragée donut toffee. Sweet cotton candy jelly beans macaroon gummies cupcake gummi
          bears
          cake chocolate.
        </p>
        <p class="mb-0">
          Cake chocolate bar cotton candy apple pie tootsie roll ice cream apple pie brownie cake. Sweet roll icing
          sesame snaps caramels danish toffee. Brownie biscuit dessert dessert. Pudding jelly jelly-o tart brownie
          jelly.
        </p>
      </div>
    </div>
  </div>
</div>
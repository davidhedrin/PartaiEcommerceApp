<div>
  <style>
    .imageShow {
      width: 100px;
      height: 100px;
      object-fit: cover !important;
    }
    .image-voucher {
      height: 165px;
      object-fit: cover !important;
    }

    @media only screen and (max-width: 600px) {
      .select-count-left {
        margin-bottom: 10px;
      }
    }
  </style>
  @include('livewire.component.toast-alert-admin')

  <h5 class="fw-bold mb-4">
    <span class="text-muted fw-light">Ecommere /</span> Voucher
  </h5>

  <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#modalAdd">
    Tambah <i class='bx bx-plus-circle'></i>
  </button>

  <div class="card mb-5">
    <div class="card-header row d-flex align-items-center justify-content-between">
      <div class="col-md-2">
        <h5>All Voucher</h5>
      </div>
      <div class="col-md-10">
        <div class="row d-flex justify-content-end">
          <div class="col-md-2 select-count-left">
            <select wire:model="countShowVoucher" class="form-select" aria-label="Default select example">
              <option value="8" selected>8 Voucher</option>
              <option value="12">12 Voucher</option>
              <option value="40">40 Voucher</option>
              <option value="100">100 Voucher</option>
            </select>
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control" placeholder="Temukan Voucher">
          </div>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="row">
        @forelse ($allVoucher as $voucher)
          <div class="col-md-3 col-lg-3 mb-4">
            <div class="card h-100">
              <img class="card-img-top image-voucher" src="{{ asset($voucher->image ? 'storage/'. colName('vc') . $voucher->image : 'assetz/img/icons/discount-icons.jpg') }}" alt="Card image cap">
              <div class="card-body">
                <a href="javascript:void(0)" wire:click='activeInActiveVoucher({{ $voucher->id }}, {{ $voucher->flag_active }})'>
                  <span class="badge rounded-pill bg-label-{{ $voucher->flag_active ? "success" : "warning" }} mb-2">{{ $voucher->flag_active ? "Active" : "Stopped" }}</span>
                </a>
                <h5 class="card-title">{{ $voucher->code }}</h5>
                <div class="card-text mb-2">
                  <div>Type: <em>{{ $voucher->type }}</em></div>
                  <div>Expired: {{ formatDate("in", $voucher->exp_date) }}</div>
                </div>
                <button class="btn btn-sm rounded-pill btn-outline-info" type="button" wire:click="copyToClipboard('{{ $voucher->code }}')">
                  <i class='bx bx-copy-alt'></i>
                </button>
                <button wire:click="openModalEdit({{ $voucher->id }})" type="button" class="btn rounded-pill btn-sm btn-primary">
                  <i class='bx bxs-edit'></i>
                </button>
                <button wire:click="deleteVoucherModal({{ $voucher->id }})" type="button" class="btn rounded-pill btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#confirm_modal">
                  <i class='bx bx-trash'></i>
                </button>
              </div>
            </div>
          </div>
        @empty
        <div class="misc-wrapper text-center">
          <h2 class="mb-2 mx-2">Daftar Voucher</h2>
          <p class="mb-4 mx-2">
            Daftar voucher produk masih kosong, silahkan tambah voucher.
          </p>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Tambah
            Voucher</button>
          <div class="mt-4">
            <i class="tf-icons bx bxs-discount" style="font-size: 150px"></i>
          </div>
        </div>
        @endforelse
      </div>
      <div class="{{ $allVoucher->count() > 0 && 'px-3 mt-3' }}">
          {{ $allVoucher->links() }}
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade" id="modalAdd" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Voucher Baru</h5>
          <button wire:click='reselFormValue' type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="code_voucher" class="form-label">Code Voucher <span style="color: red">*</span></label>
              <input wire:model="code" type="text" id="code_voucher" class="form-control"
                placeholder="Masukkan kode voucher">
              @error('code')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="type" class="form-label">Tipe Voucher <span style="color: red">*</span></label>
              <select wire:model='type' class="form-select" id="type">
                <option value="">Pilih type</option>
                <option value="fixed">Fixed</option>
                <option value="percent">Percent</option>
              </select>
              @error('type')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="exp_date_add" class="form-label">Expired Date <span style="color: red">*</span></label>
              <input wire:model="exp_date" class="form-control" type="date" id="exp_date_add">
              @error('exp_date')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            @if ($type == "fixed")
            <div class="col-md-6 mb-3">
              <label for="dicount_value" class="form-label">Discont Value <span style="color: red">*</span></label>
              <input wire:model="value" type="text" id="dicount_value" onkeyup="inputCurrencyIdr(this)"
                class="form-control" placeholder="Masukkan nilai diskon">
              @error('value')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            @elseif ($type == "percent")
            <div class="col-md-6 mb-3">
              <label for="percent_value" class="form-label">Percent Value <span style="color: red">*</span></label>
              <div class="input-group">
                <input wire:model='value' type="number" id="percent_value" class="form-control" min="1" max="100"
                  placeholder="Masukkan nilai percent" aria-label="Max value 100%">
                <span class="input-group-text">%</span>
              </div>
              @error('value')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="max_dicont_percent" class="form-label">Max Discont Percent <span
                  style="color: red">*</span></label>
              <input wire:model="max_value_percent" type="text" id="max_dicont_percent" onkeyup="inputCurrencyIdr(this)"
                class="form-control" placeholder="Maksimal diskon percent">
              @error('max_value_percent')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            @endif

            <div class="col-md-12 mb-3">
              <label for="keterangan" class="form-label">Keterangan</label>
              <textarea wire:model='keterangan' class="form-control" id="keterangan" rows="3"
                placeholder="Masukkan deskripsi voucher"></textarea>
              @error('keterangan')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="divider">
              <div class="divider-text">Conditions</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="min_belanja" class="form-label">Min Belanja</label>
              <input wire:model="min_cart" type="text" id="min_belanja" type-currency="IDR" class="form-control"
                placeholder="Masukkan minimal belanjaan">
            </div>
            <div class="col-md-6 mb-3">
              <label for="for_product" class="form-label">Tipe Product</label>
              <select wire:model='for_product' class="form-select" id="for_product">
                <option value="">Pilih type</option>
                <option value="i">Import</option>
                <option value="e">Export</option>
              </select>
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-check form-switch mb-2">
                <input wire:model="product_discont" class="form-check-input" type="checkbox" id="product_dicount">
                <label class="form-check-label" for="product_dicount">
                  Berlaku untuk product sedang diskon.
                </label>
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <label class="form-label">Gambar Voucher</label>
              <div class="d-flex align-items-start align-items-sm-center gap-4">
                @if ($image)
                <img src="{{ $image->temporaryUrl() }}" class="d-block rounded imageShow">
                @else
                <img src="{{ asset('assetz/img/layouts/imageUpload.png') }}" alt="user-avatar"
                  class="d-block rounded imageShow">
                @endif
                <div class="button-wrapper">
                  <div wire:loading.remove wire:loading.attr='disabled' wire:target='image'>
                    <label for="gambar_kategori" class="btn btn-primary me-2 mb-4" tabindex="0">
                      <span class="d-none d-sm-block">Upload</span>
                      <i class="bx bx-upload d-block d-sm-none"></i>
                      <input wire:model="image" type="file" id="gambar_kategori" class="account-file-input" hidden=""
                        accept="image/png, image/jpeg">
                    </label>
                    <button wire:click="resetImageVal" type="button"
                      class="btn btn-outline-secondary account-image-reset mb-4">
                      <i class="bx bx-reset d-block d-sm-none"></i>
                      <span class="d-none d-sm-block">Reset</span>
                    </button>
                  </div>
                  <div wire:loading wire:target='image'>
                    <p class="text-muted">uploading...</p>
                  </div>
                  <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 800K</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="px-4">
          <hr class="mb-0">
          <div>
            <small>
              <em>tanda <span style="color: red">*</span> wajib untuk diisi</em>
            </small>
          </div>
        </div>
        <div class="modal-footer">
          <button wire:click='reselFormValue' type="button" class="btn btn-outline-secondary"
            data-bs-dismiss="modal">Batal</button>
          <div wire:loading.remove wire:loading.attr='disabled' wire:target=''>
            <button wire:click.prevent='saveNewVoucher' type="button" class="btn btn-primary">Tambah</button>
          </div>
          <div wire:loading wire:target=''>
            <button type="button" class="btn btn-secondary" disabled>Tambah</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div wire:ignore.self class="modal fade" id="modalEdit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Voucher</h5>
          <button wire:click='reselFormValue' type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="code_voucher_edit" class="form-label">Code Voucher <span style="color: red">*</span></label>
              <input wire:model="code" type="text" id="code_voucher_edit" class="form-control"
                placeholder="Masukkan kode voucher">
              @error('code')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="type_edit" class="form-label">Tipe Voucher <span style="color: red">*</span></label>
              <select wire:model='type' class="form-select" id="type_edit">
                <option value="">Pilih type</option>
                <option value="fixed">Fixed</option>
                <option value="percent">Percent</option>
              </select>
              @error('type')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="exp_date_edit" class="form-label">Expired Date <span style="color: red">*</span></label>
              <input wire:model="exp_date" class="form-control" type="date" id="exp_date_edit">
              @error('exp_date')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            @if ($type == "fixed")
            <div class="col-md-6 mb-3">
              <label for="dicount_value_edit" class="form-label">Discont Value <span style="color: red">*</span></label>
              <input wire:model="value" type="text" id="dicount_value_edit" onkeyup="inputCurrencyIdr(this)"
                class="form-control" placeholder="Masukkan nilai diskon">
              @error('value')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            @elseif ($type == "percent")
            <div class="col-md-6 mb-3">
              <label for="percent_value_edit" class="form-label">Percent Value <span style="color: red">*</span></label>
              <div class="input-group">
                <input wire:model='value' type="number" id="percent_value_edit" class="form-control"
                  placeholder="Masukkan nilai percent" aria-label="Max value 100%">
                <span class="input-group-text">%</span>
              </div>
              @error('value')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="max_dicont_percent_edit" class="form-label">Max Discont Percent <span
                  style="color: red">*</span></label>
              <input wire:model="max_value_percent" type="text" id="max_dicont_percent_edit" onkeyup="inputCurrencyIdr(this)"
                class="form-control" placeholder="Maksimal diskon percent">
              @error('max_value_percent')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            @endif

            <div class="col-md-12 mb-3">
              <label for="keterangan_edit" class="form-label">Keterangan</label>
              <textarea wire:model='keterangan' class="form-control" id="keterangan_edit" rows="3"
                placeholder="Masukkan deskripsi voucher"></textarea>
              @error('keterangan')
              <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>

            <div class="divider">
              <div class="divider-text">Conditions</div>
            </div>
            <div class="col-md-6 mb-3">
              <label for="min_belanja_edit" class="form-label">Min Belanja</label>
              <input wire:model="min_cart" type="text" id="min_belanja_edit" type-currency="IDR" class="form-control"
                placeholder="Masukkan minimal belanjaan">
            </div>
            <div class="col-md-6 mb-3">
              <label for="for_product_edit" class="form-label">Tipe Product</label>
              <select wire:model='for_product' class="form-select" id="for_product_edit">
                <option value="">Pilih type</option>
                <option value="i">Import</option>
                <option value="e">Export</option>
              </select>
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-check form-switch mb-2">
                <input wire:model="product_discont" class="form-check-input" type="checkbox" id="product_dicount_edit">
                <label class="form-check-label" for="product_dicount_edit">
                  Berlaku untuk product sedang diskon.
                </label>
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <label class="form-label">Gambar Voucher</label>
              <div class="d-flex align-items-start align-items-sm-center gap-4">
                @if ($newimage)
                  <img src="{{ $newimage->temporaryUrl() }}" class="d-block rounded imageShow">
                @else
                  @if ($viewImage)
                    <img src="{{ asset('storage/' . colName('vc') . $viewImage) }}" class="d-block rounded imageShow">
                  @else
                    <img src="{{ asset('assetz/img/layouts/imageUpload.png') }}" alt="user-avatar" class="d-block rounded imageShow">
                  @endif
                @endif
                <div class="button-wrapper">
                  <div wire:loading.remove wire:loading.attr='disabled' wire:target='newimage'>
                    <label for="gambar_voucher_edit" class="btn btn-primary me-2 mb-4" tabindex="0">
                      <span class="d-none d-sm-block">{{ $viewImage ? "Change" : "Upload" }}</span>
                      <i class="bx bx-upload d-block d-sm-none"></i>
                      <input wire:model="newimage" type="file" id="gambar_voucher_edit"
                        class="account-file-input" hidden="" accept="image/png, image/jpeg">
                    </label>
                  </div>
                  <div wire:loading wire:target='newimage'>
                    <p class="text-muted">uploading...</p>
                  </div>
                  <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 800K</p>
                </div>
                @error('newimage')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="px-4">
          <hr class="mb-0">
          <div>
            <small>
              <em>tanda <span style="color: red">*</span> wajib untuk diisi</em>
            </small>
          </div>
        </div>
        <div class="modal-footer">
          <button wire:click='reselFormValue' type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <div wire:loading.remove wire:loading.attr='disabled' wire:target='newimage'>
            <button wire:click.prevent='updateVoucher' type="button" class="btn btn-primary">Simpan</button>
          </div>
          <div wire:loading wire:target='newimage'>
            <button type="button" class="btn btn-secondary" disabled>Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div wire:ignore.self id="confirm_modal" class="modal fade" data-bs-backdrop="static" tabindex="-1" style="display: none; z-index: 9999;" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">
            Delete Confirmation
          </h5>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <span>Enter your password</span>
            <p>Confirm with your password to continue</p>
          </div>
          <input wire:model="pass_confirm" type="password" class="form-control" placeholder="Enter your password">
          @error("pass_confirm")
            <span class="text-danger text-start">{{ $message }}</span>
          @enderror
        </div>
        <div class="modal-footer">
          <button wire:click="clearConfirmPass" type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Batal
          </button>
          <button wire:click.prevent="executeDeleteConfirm" type="button" class="btn btn-danger">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.addEventListener('close-form-modal', event => {
    $('#modalAdd').modal('hide');
    $('#modalEdit').modal('hide');
    $('#confirm_modal').modal('hide');
  });
  window.addEventListener('open-edit-modal', event => {
    $('#modalEdit').modal('show');
  });
  
  window.addEventListener('hit-function-copy', event => {
    var getCode = event.detail.code;
    copyTextClipboard(getCode);
  });
</script>
@push('scripts')
<script>
  $('#code_voucher').on('keyup', function() {
      $(this).val($(this).val().toUpperCase());
    });

    function inputCurrencyIdr(element) {
      var cursorPosition = element.selectionStart;
      var value = parseInt(element.value.replace(/[^,\d]/g, ''));
      var originalLength = element.value.length;
      
      if (isNaN(value)) {
        element.value = "";
      } else {
        element.value = value.toLocaleString('id-ID', {
            currency: 'IDR',
            style: 'currency',
            minimumFractionDigits: 0
        });
        cursorPosition = element.value.length - originalLength + cursorPosition;
        element.setSelectionRange(cursorPosition, cursorPosition);
      }
    }
</script>
@endpush
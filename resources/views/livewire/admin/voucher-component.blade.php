<div>
  <style>
    @media only screen and (max-width: 600px) {
      .select-count-left{
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
            <select wire:model="" class="form-select" aria-label="Default select example">
              <option value="5" selected>5 Voucher</option>
              <option value="10">10 Voucher</option>
              <option value="50">50 Voucher</option>
              <option value="100">100 Voucher</option>
            </select>
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control" placeholder="Temukan Voucher">
          </div>
        </div>
      </div>
    </div>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr class="text-nowrap">
            <th>Kode</th>
            <th>Keterangan</th>
            <th>Expired Date</th>
            <th>Diskon</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Testing</td>
            <td>Testing</td>
            <td>Testing</td>
            <td>Testing</td>
            <td>Testing</td>
            <td>Testing</td>
          </tr>
        </tbody>
      </table>
      <div class="px-3 mt-3">
          {{-- {{ $allProduct->links() }} --}}
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
              <input wire:model="" class="form-control" type="date" id="exp_date_add">
            </div>
            <div class="col-md-6 mb-3">
              <label for="dicount_value" class="form-label">Discont Value <span style="color: red">*</span></label>
              <input wire:model="" type="text" id="dicount_value" class="form-control" placeholder="Masukkan nilai diskon">
              @error('')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-6 mb-3">
              <label for="max_dicont_percent" class="form-label">Max Discont Percent <span style="color: red">*</span></label>
              <input wire:model="" type="text" id="max_dicont_percent" type-currency="IDR" class="form-control" placeholder="Maksimal diskon percent">
              @error('')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
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
              <input wire:model="" type="text" id="min_belanja" type-currency="IDR" class="form-control" placeholder="Masukkan minimal belanjaan">
            </div>
            <div class="col-md-6 mb-3">
              <label for="for_product" class="form-label">Tipe Product</label>
              <select wire:model='' class="form-select" id="for_product">
                <option value="">Pilih type</option>
                <option value="i">Import</option>
                <option value="e">Export</option>
              </select>
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="product_dicount">
                <label class="form-check-label" for="product_dicount">
                  Berlaku untuk product sedang diskon.
                </label>
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
          <div wire:loading.remove wire:loading.attr='disabled' wire:target=''>
            <button wire:click.prevent='' type="button" class="btn btn-primary">Tambah</button>
          </div>
          <div wire:loading wire:target=''>
            <button type="button" class="btn btn-secondary" disabled>Tambah</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@push('scripts')
  <script>
    $('#code_voucher').on('keyup', function() {
      $(this).val($(this).val().toUpperCase());
    });
  </script>
@endpush
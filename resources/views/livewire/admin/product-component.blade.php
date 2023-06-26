<div>
  <style>
    .imageShow {
      width: 100px;
      height: 100px;
      object-fit: cover !important;
    }

    .imageShowTable {
      width: 80px;
      height: 80px;
      object-fit: cover !important;
    }

    .square-image-container {
      position: relative;
      width: 100%;
      padding-top: 100%;
      /* Set padding-top to match width to create a square container */
      overflow: hidden;
    }

    .imageShowLainnya {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover !important;
    }
  </style>

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

  <h5 class="fw-bold mb-4">
    <span class="text-muted fw-light">Ecommere /</span> Products
  </h5>

  @if (count($allProduct) > 0)
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#modalAdd">
      Tambah <i class='bx bx-plus-circle'></i>
    </button>
  @endif

  <div class="card mb-5">
    <h5 class="card-header">All Product</h5>
    <div class="table-responsive text-nowrap">
      <table class="table">
        <thead>
          <tr class="text-nowrap">
            <th>Gambar</th>
            <th>SKU-Produk</th>
            <th>Produk</th>
            <th>Harga Jual</th>
            <th>Harga Diskon</th>
            <th>Stok</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($allProduct as $product)
            <tr id="{{ $product->sku }}">
              <td>
                <img src="{{ asset('storage/' . colName('pr') . $product->image->image) }}"
                  class="d-block rounded imageShowTable">
              </td>
              <td>{{ $product->sku }}</td>
              <td>{{ $product->name }}</td>
              <td>{{ currency_IDR($product->regular_price) }}</td>
              <td>{{ currency_IDR($product->sale_price) }}</td>
              <td class="{{ $product->quantity < 1 ? "text-warning" : "" }}" style='font-style: {{ $product->quantity < 1 ? "italic" : "" }}'>
                {{ $product->quantity > 0 ? $product->quantity . " Kg" : "Out Of Stok" }}
              </td>
              <td>{{ $product->category ? $product->category->name : '-' }}</td>
              <td>
                <a href="javascript:void(0);" wire:click='activeInActiveProduct({{ $product->id }}, {{ $product->flag_active }})'>
                  <span class="badge rounded-pill bg-{{ $product->flag_active ? "success" : "warning" }}">
                    {{ $product->flag_active ? "Active" : 'InActive' }}
                  </span>
                </a>
              </td>
              <td>
                <a href="javascript:void(0);" wire:click='openModelForEdit({{ $product->id }})'>
                  <i class="bx bx-edit-alt me-1"></i>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-5">
                <div class="misc-wrapper text-center">
                  <h2 class="mb-2 mx-2">Daftar Product</h2>
                  <p class="mb-4 mx-2">
                    Daftar product produk masih kosong, silahkan tambah product.
                  </p>
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modalAdd">Tambah
                    Product</button>
                  <div class="mt-4">
                    <i class='tf-icons bx bx-package' style="font-size: 150px"></i>
                  </div>
                </div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <div wire:ignore.self class="modal fade" id="modalAdd" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Product Baru</h5>
          <button wire:click='reselFormValue' type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="import_export" class="form-label">Import/Export <span style="color: red">*</span></label>
              <select wire:model='product_for' wire:change='generateSkuProduct($event.target.value)' class="form-select"
                id="import_export">
                <option value="">Pilih Pasar</option>
                <option value="i">Import</option>
                <option value="e">Export</option>
              </select>
              @error('product_for')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="sku_product" class="form-label">SKU Produk <span style="color: red">*</span></label>
              <div class="input-group">
                <input wire:model="sku" type="text" class="form-control" id="sku_product" readonly
                  placeholder="{{ $loadingSku ? 'generating...' : 'Masukkan kode product' }}"
                  aria-describedby="button_sku_product">
                <button wire:click='generateSkuProduct("sku")' class="btn btn-warning" type="button"
                  id="button_sku_product" {{ $product_for ? '' : 'disabled' }}><i
                    class='bx bx-barcode-reader'></i></button>
              </div>
              @error('sku')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="nama_product" class="form-label">Nama <span style="color: red">*</span></label>
              <input wire:model="name" type="text" id="nama_product" class="form-control"
                placeholder="Masukkan nama product">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="regular_price" class="form-label">Harga Jual</label>
              <input wire:model="regular_price" type="text" id="regular_price" type-currency="IDR"
                class="form-control" placeholder="Masukkan harga product">
              @error('regular_price')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="sale_price" class="form-label">Harga Diskon</label>
              <input wire:model="sale_price" type="text" id="sale_price" type-currency="IDR"
                class="form-control" placeholder="Masukkan diskon product">
            </div>
            <div class="col-md-4 mb-3">
              <label for="short_desc" class="form-label">Subtitle</label>
              <input wire:model="short_desc" type="text" id="short_desc" class="form-control"
                placeholder="Masukkan kode product">
            </div>
            <div class="col-md-4 mb-3">
              <label for="quantity" class="form-label">Stok Produk / KG</label>
              <input wire:model="quantity" type="number" id="quantity" class="form-control"
                placeholder="Masukkan stok product">
              @error('quantity')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="category_id" class="form-label">Categori</label>
              <select wire:init='' wire:model='category_id' class="form-select" id="category_id">
                <option value="">Pilih Kategori</option>
                @foreach ($allCategory as $categ)
                  <option value="{{ $categ->id }}">{{ $categ->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Produk Unggulan</label>
              <div class="form-check form-switch">
                <input wire:model='featured' class="form-check-input" type="checkbox" id="product_unggulan">
                <label class="form-check-label" for="product_unggulan">Aktifkan Produk Unggulan</label>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <label for="description" class="form-label">Deskripsi <span style="color: red">*</span></label>
              <textarea wire:model='description' class="form-control" id="description" rows="3"
                placeholder="Masukkan deskripsi produk"></textarea>
              @error('description')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Gambar Utama <span style="color: red">*</span></label>
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
                      <input wire:model="image" type="file" id="gambar_kategori" class="account-file-input"
                        hidden="" accept="image/png, image/jpeg">
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
              @error('image')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label for="gambar_lalinnya" class="form-label">Upload Sampai 10 Gambar</label>
              <div class="button-wrapper">
                <div>
                  <label wire:loading.remove wire:loading.attr='disabled' wire:target='setImg' for="gambar_lainnya"
                    class="btn btn-primary me-2" tabindex="0">
                    <span class="d-none d-sm-block">Upload <i class='bx bx-plus'></i></span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input wire:model='setImg' type="file" id="gambar_lainnya" class="account-file-input"
                      hidden="" accept="image/png, image/jpeg">
                  </label>
                  <button wire:loading wire:target='setImg' class="btn btn-primary me-2" disabled
                    tabindex="0">uploading...</button>
                </div>
              </div>
            </div>
            <div class="row px-4">
              @if ($images)
                @foreach ($images as $img)
                  <div class="col-md-2 px-2 py-2">
                    <div class="square-image-container">
                      <img src="{{ $img->temporaryUrl() }}" class="d-block rounded imageShowLainnya" alt="Preview">
                    </div>
                  </div>
                @endforeach
              @endif
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
          <div wire:loading.remove wire:loading.attr='disabled' wire:target='image, setImg'>
            <button wire:click.prevent='storeProductToDb' type="button" class="btn btn-primary">Tambahkan</button>
          </div>
          <div wire:loading wire:target='image, setImg'>
            <button type="button" class="btn btn-primary" disabled>Tambahkan</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade" id="modalEdit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Product</h5>
          <button wire:click='reselFormValue' type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="import_export_edit" class="form-label">Import/Export <span
                  style="color: red">*</span></label>
              <select wire:model='product_for' wire:change='generateSkuProduct($event.target.value)'
                class="form-select" id="import_export_edit">
                <option value="">Pilih Pasar</option>
                <option value="i">Import</option>
                <option value="e">Export</option>
              </select>
              @error('product_for')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="sku_product_edit" class="form-label">SKU Produk <span style="color: red">*</span></label>
              <div class="input-group">
                <input wire:model="sku" type="text" class="form-control" id="sku_product_edit" readonly
                  placeholder="{{ $loadingSku ? 'generating...' : 'Masukkan kode product' }}"
                  aria-describedby="button_sku_product">
                <button class="btn btn-warning" type="button" id="button_sku_product" disabled><i
                    class='bx bx-barcode-reader'></i></button>
              </div>
              @error('sku')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
          </div>
          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="nama_product_edit" class="form-label">Nama <span style="color: red">*</span></label>
              <input wire:model="name" type="text" id="nama_product_edit" class="form-control"
                placeholder="Masukkan nama product">
              @error('name')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="regular_prices_edit" class="form-label">Harga Jual </label>
              <input wire:model="regular_price" type="text" id="regular_prices_edit" type-currency="IDR"
                class="form-control" placeholder="Masukkan harga product">
              @error('regular_price')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="sale_prices_edit" class="form-label">Harga Diskon</label>
              <input wire:model="sale_price" type="text" id="sale_prices_edit" type-currency="IDR"
                class="form-control" placeholder="Masukkan diskon product">
            </div>
            <div class="col-md-4 mb-3">
              <label for="short_desc_edit" class="form-label">Subtitle</label>
              <input wire:model="short_desc" type="text" id="short_desc_edit" class="form-control"
                placeholder="Masukkan kode product">
            </div>
            <div class="col-md-4 mb-3">
              <label for="quantity_edit" class="form-label">Stok Produk / KG </label>
              <input wire:model="quantity" type="number" id="quantity_edit" class="form-control"
                placeholder="Masukkan stok product">
              @error('quantity')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-4 mb-3">
              <label for="category_id_edit" class="form-label">Categori</label>
              <select wire:init='' wire:model='category_id' class="form-select" id="category_id_edit">
                <option value="">Pilih Kategori</option>
                @foreach ($allCategory as $categ)
                  <option value="{{ $categ->id }}">{{ $categ->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Produk Unggulan</label>
              <div class="form-check form-switch">
                <input wire:model='featured' class="form-check-input" type="checkbox" id="product_unggulan_edit">
                <label class="form-check-label" for="product_unggulan_edit">Aktifkan Produk Unggulan</label>
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <label for="description_edit" class="form-label">Deskripsi <span style="color: red">*</span></label>
              <textarea wire:model='description' class="form-control" id="description_edit" rows="3"
                placeholder="Masukkan deskripsi produk"></textarea>
              @error('description')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label class="form-label">Gambar Utama <span style="color: red">*</span></label>
              <div class="d-flex align-items-start align-items-sm-center gap-4">
                @if ($imageEdit)
                  <img src="{{ $imageEdit->temporaryUrl() }}" class="d-block rounded imageShow">
                @else
                  <img src="{{ asset('storage/' . colName('pr') . $imageEditView) }}"
                    class="d-block rounded imageShow">
                @endif
                <div class="button-wrapper">
                  <label wire:loading.remove wire:loading.attr='disabled' wire:target='imageEdit'
                    for="gambar_kategori_edit" class="btn btn-primary me-2 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">Change</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input wire:model="imageEdit" type="file" id="gambar_kategori_edit"
                      class="account-file-input" hidden="" accept="image/png, image/jpeg">
                  </label>
                  <button wire:loading wire:target='imageEdit' class="btn btn-primary me-2 mb-4" disabled
                    tabindex="0">uploading...</button>
                  <p class="text-muted mb-0">Allowed JPG or PNG. Max size of 800K</p>
                </div>
              </div>
              @error('image')
                <span class="text-danger">{{ $message }}</span>
              @enderror
            </div>
            <div class="col-md-12 mb-3">
              <label for="gambar_lalinnya" class="form-label">Upload Sampai 10 Gambar</label>
              <div class="button-wrapper">
                <div>
                  <label wire:loading.remove wire:loading.attr='disabled' wire:target='setImgEdit'
                    for="gambar_lainnya_edit" class="btn btn-primary me-2" tabindex="0">
                    <span class="d-none d-sm-block">Upload <i class='bx bx-plus'></i></span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input wire:model='setImgEdit' type="file" id="gambar_lainnya_edit"
                      class="account-file-input" hidden="" accept="image/png, image/jpeg">
                  </label>
                  <button wire:loading wire:target='setImgEdit' class="btn btn-primary me-2" disabled
                    tabindex="0">uploading...</button>
                </div>
              </div>
            </div>
            <div class="row px-4">
              @if ($imagesEditView)
                @if ($imagesEdit)
                  @foreach ($imagesEdit as $img)
                    <div class="col-md-2 px-2 py-2">
                      <div class="square-image-container">
                        <img src="{{ $img->temporaryUrl() }}" class="d-block rounded imageShowLainnya"
                          alt="Preview">
                      </div>
                    </div>
                  @endforeach
                @endif
                @foreach ($imagesEditView as $img)
                  <div class="col-md-2 px-2 py-2">
                    <div class="square-image-container">
                      <img src="{{ asset('storage/' . colName('pr') . $folderName . '/' . $img) }}"
                        class="d-block rounded imageShowLainnya" alt="Preview">
                    </div>
                  </div>
                @endforeach
              @endif
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
          <div wire:loading.remove wire:loading.attr='disabled' wire:target='imageEdit, setImgEdit'>
            <button wire:click.prevent='saveUpdateProdut({{ $idForUpdate }})' type="button" class="btn btn-primary">Simpan</button>
          </div>
          <div wire:loading wire:target='imageEdit, setImgEdit'>
            <button type="button" class="btn btn-primary" disabled>Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="{{ asset('logo/logo2.png') }}" width="170px" alt="">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <span>Yakin ingin menghapus data?</span>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button wire:loading.remove wire:loading.attr='disabled' wire:target='idForDelete' type="button" class="btn btn-primary">Hapus</button>
          <button wire:loading wire:target='idForDelete' type="button" class="btn btn-primary" disabled>Hapus</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  window.addEventListener('close-form-modal', event => {
    $('#modalAdd').modal('hide');
    $('#modalEdit').modal('hide');
    $('#deleteModal').modal('hide');
  });
  window.addEventListener('open-form-modal', event => {
    $('#modalEdit').modal('show');
  });
</script>

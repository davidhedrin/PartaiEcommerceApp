<div>
  <style>
    .image-category {
      height: 150px;
      object-fit: cover !important;
    }

    .card-category {
      cursor: pointer;
    }

    .imageShow {
      width: 100px;
      height: 100px;
      object-fit: cover !important;
    }
  </style>

  @include('livewire.component.toast-alert-admin')

  <h5 class="fw-bold mb-4">
    <span class="text-muted fw-light">Ecommere /</span> Kategori
  </h5>

  @if (count($allCategory) > 0)
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#modalAdd">
      Tambah <i class='bx bx-plus-circle'></i>
    </button>
  @endif

  <h6>Daftar kategori:</h6>

  @if (count($allCategory) > 0)
    <div class="row row-cols-1 row-cols-md-6 g-4">
      @foreach ($allCategory as $category)
        <div class="col">
          <div class="card">
            <img class="card-img-top image-category" src="{{ asset('storage/'. colName('ct') . $category->image) }}"
              alt="Card image cap">
            <div class="card-img-overlay px-2 py-2 d-flex justify-content-end">
              <div class="px-1">
                <button wire:click="openModalEdit({{ $category->id }})" type="button"
                  class="btn rounded-pill btn-sm btn-primary">
                  <i class='bx bxs-edit'></i>
                </button>
              </div>
              <div>
                <button wire:click="openModalDelete({{ $category->id }})" type="button"
                  class="btn rounded-pill btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">
                  <i class='bx bx-trash'></i>
                </button>
              </div>
            </div>
            <div class="px-3 py-2">
              <span>cat-{{ $category->code }}</span>
              <h5 class="card-title mb-0">{{ $category->name }}</h5>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="card">
      <div class="card-body">
        <div class="misc-wrapper text-center">
          <h2 class="mb-2 mx-2">Daftar Kategori</h2>
          <p class="mb-4 mx-2">
            Daftar kategori produk masih kosong, silahkan tambah kategori.
          </p>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Tambah
            Kategori</button>
          <div class="mt-4">
            <i class='tf-icons bx bx-category' style="font-size: 150px"></i>
          </div>
        </div>
      </div>
    </div>
  @endif

  <div wire:ignore.self class="modal fade" id="modalAdd" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddTitle">Kategori Baru</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="saveKagetoriToDb()">
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="nama_kategori" class="form-label">Nama</label>
                <input wire:model="name" type="text" id="nama_kategori" class="form-control"
                  placeholder="Masukkan nama kategori">
                @error('name')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Gambar</label>
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
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <div wire:loading.remove wire:loading.attr='disabled' wire:target='image'>
              <button type="submit" class="btn btn-primary">Tambahkan</button>
            </div>
            <div wire:loading wire:target='image'>
              <button type="submit" class="btn btn-primary" disabled>Tambahkan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade" id="modalEdit" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalAddTitle">Ubah Kategori</h5>
          <button wire:click='resetFormValue' type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="updateCategory">
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="nama_kategori_edit" class="form-label">Nama</label>
                <input wire:model="name" type="text" id="nama_kategori_edit" class="form-control"
                  placeholder="Masukkan nama kategori">
                @error('name')
                  <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label class="form-label">Gambar</label>
                <div class="d-flex align-items-start align-items-sm-center gap-4">
                  @if ($newimage)
                    <img src="{{ $newimage->temporaryUrl() }}" class="d-block rounded imageShow">
                  @else
                    <img src="{{ asset('storage/' . colName('ct') . $viewImage) }}" class="d-block rounded imageShow">
                  @endif
                  <div class="button-wrapper">
                    <div wire:loading.remove wire:loading.attr='disabled' wire:target='newimage'>
                      <label for="gambar_kategori_edit" class="btn btn-primary me-2 mb-4" tabindex="0">
                        <span class="d-none d-sm-block">Upload</span>
                        <i class="bx bx-upload d-block d-sm-none"></i>
                        <input wire:model="newimage" type="file" id="gambar_kategori_edit"
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
          <div class="modal-footer">
            <button wire:click='resetFormValue' type="button" class="btn btn-outline-secondary"
              data-bs-dismiss="modal">Batal</button>
            <div wire:loading.remove wire:loading.attr='disabled' wire:target='newimage'>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            <div wire:loading wire:target='newimage'>
              <button type="submit" class="btn btn-primary" disabled>Simpan</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div wire:ignore.self class="modal fade" id="modalDelete" tabindex="-1" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="{{ asset('assets/img/logo.png') }}" width="70px" alt="">
          <button wire:click='resetFormValue' type="button" class="btn-close" data-bs-dismiss="modal"
            aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <span>Yakin ingin menghapus data?</span>
        </div>
        <div class="modal-footer">
          <button wire:click='resetFormValue' type="button" class="btn btn-outline-secondary"
            data-bs-dismiss="modal">Close</button>
          <button wire:click='deleteCategory' type="button" class="btn btn-primary">Delete</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  window.addEventListener('close-form-modal', event => {
    $('#modalAdd').modal('hide');
    $('#modalEdit').modal('hide');
    $('#modalDelete').modal('hide');
  });
  window.addEventListener('open-edit-modal', event => {
    $('#modalEdit').modal('show');
  });
</script>
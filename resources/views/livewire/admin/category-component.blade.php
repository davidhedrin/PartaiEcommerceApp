<div>
  <style>
    .image-category {
      height: 150px;
      object-fit: cover !important;
    }

    .card-category {
      cursor: pointer;
    }
  </style>

  <h5 class="fw-bold mb-4">
    <span class="text-muted fw-light">Ecommere /</span> Kategori
  </h5>

  @if (count($allCategory) > 0)
    <button type="button" class="btn btn-success mb-4" data-bs-toggle="modal" data-bs-target="#modalAdd">
      Tambah <i class='bx bx-plus-circle'></i>
    </button>
  @endif

  @if (count($allCategory) > 0)
    <div class="row row-cols-1 row-cols-md-6 g-4">
      @foreach ($allCategory as $category)
        <div class="col">
          <div class="card">
            <img class="card-img-top image-category" src="{{ asset('assetz/img/elements/2.jpg') }}" alt="Card image cap">
            <div class="card-img-overlay px-2 py-2 d-flex justify-content-end">
              <div class="px-1">
                <button type="button" class="btn rounded-pill btn-sm btn-primary"><i class='bx bxs-edit'></i></button>
              </div>
              <div>
                <button type="button" class="btn rounded-pill btn-sm btn-danger"><i class='bx bx-trash'></i></button>
              </div>
            </div>
            <div class="px-3 py-2">
              <span>Teting code</span>
              <h5 class="card-title mb-0">Card title</h5>
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
        <a href="index.html" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">Tambah Kategori</a>
        <div class="mt-4">
          <img src="{{ asset('assetz/img/illustrations/girl-doing-yoga-light.png') }}" alt="girl-doing-yoga-light" width="500"
            class="img-fluid">
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
          {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
        </div>
        <form wire:submit.prevent="saveKagetoriToDb()">
          <div class="modal-body">
            <div class="row">
              <div class="col mb-3">
                <label for="nama_kategori" class="form-label">Nama</label>
                <input wire:model="name" type="text" id="nama_kategori" class="form-control" placeholder="Masukkan nama kategori">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="gambar_kategori" class="form-label">Gambar</label>
                <input wire:model="image" class="form-control" type="file" id="gambar_kategori">
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Tambahkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

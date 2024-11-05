@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Menu Produk</li>
            </ol>
        </nav>

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card mb-3">
            <form action="{{ route('product.store') }}" method="POST" class="needs-validation form-create" novalidate>
                @csrf
                @method('POST')
                <div class="card-header fw-bold">Produk Baru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code_product" class="form-label">Kode Produk</label>
                                <input type="text" class="form-control" id="code_product" name="code" autocomplete="off" spellcheck="false" title="Kode produk" placeholder="MEICHEMSC01" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="name_product" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name_product" name="name" autocomplete="off" spellcheck="false" title="Nama produk" placeholder="Alkalinity Booster" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="packaging" class="form-label">Kemasan</label>
                                <input type="text" class="form-control" id="packaging" name="packaging" autocomplete="off" spellcheck="false" title="Kemasan" placeholder="30 Kg/Pail" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="unit" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="unit" name="unit" autocomplete="off" spellcheck="false" title="Satuan" placeholder="Kg" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select name="category" class="form-select" id="category" title="Kategori" required>
                                    <option value="">Pilih kategori...</option>
                                    <option value="General Chemical">General Chemical</option>
                                    <option value="Specialty Chemical">Specialty Chemical</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header fw-bold">Data Produk</div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%"></table>
            </div>
        </div>

        {{-- <div class="card shadow-sm">
            <div class="card-header d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center shadow" data-bs-toggle="modal" data-bs-target="#createProduct">
                    <i class='bx bx-plus-circle me-1' style="font-size: 20px"></i>
                    <span>Tambah Data</span>
                </button>

                <div class="modal fade" id="createProduct" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                    <form action="{{ route('product.store') }}" class="needs-validation" method="POST" novalidate>
                        @csrf
                        @method('POST')
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Data Baru</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="codeProduct" class="form-label">Kode Produk</label>
                                        <input type="text" class="form-control" id="codeProduct" name="code" autocomplete="off" spellcheck="false" value="{{ old('code') }}" required>
                                        <div class="form-text">Kode produk harus unik dari data produk</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nameProduct" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" id="nameProduct" name="name" autocomplete="off" spellcheck="false" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="packaging" class="form-label">Kemasan</label>
                                        <input type="text" class="form-control" id="packaging" name="packaging" autocomplete="off" spellcheck="false" value="{{ old('packaging') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">Satuan</label>
                                        <input type="text" class="form-control" id="unit" name="unit" autocomplete="off" spellcheck="false" value="{{ old('unit') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Kategori</label>
                                        <input type="text" class="form-control" id="category" name="category" autocomplete="off" spellcheck="false" value="{{ old('category') }}" required>
                                        <div class="form-text text-muted">Contoh: General chemical, specialty chemical, dll.</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="mb-0 fw-bold text-muted">DATA MASTER PRODUK</div>
            </div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%">
                    <thead>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Produk</th>
                        <th>Kemasan</th>
                        <th>Satuan</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </thead>
                </table>
            </div>
        </div> --}}
        
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
                serverSide: true,
                ajax: "{{ route('product.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'code', name: 'code', title: 'Kode'},
                    { data: 'name', name: 'name', title: 'Nama Produk'},
                    { data: 'packaging', name: 'packaging', title: 'Kemasan'},
                    { data: 'unit', name: 'unit', title: 'Satuan'},
                    { data: 'category', name: 'category', title: 'Kategori'},
                    { data: 'aksi', name: 'aksi', title: 'Aksi'}
                ],
            });
        });
    </script>
@endpush

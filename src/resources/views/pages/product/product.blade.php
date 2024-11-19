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

        @can('create-product')
        <div class="card mb-3">
            <form action="{{ route('product.store') }}" method="POST" class="needs-validation form-create" novalidate>
                @csrf
                @method('POST')
                <div class="card-header fw-bold">Produk Baru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="code_product" class="form-label">Kode Produk</label>
                                <input type="text" class="form-control" id="code_product" name="code" autocomplete="off" spellcheck="false" title="Kode produk" placeholder="MEICHEMSC01" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name_product" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="name_product" id="name_product" title="Nama Produk" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="type_of_product" class="form-label">Jenis Produk</label>
                                <select name="type_of_product" id="type_of_product" class="form-select select-box" title="Kategori produk" require>
                                    <option value="" selected>Pilih jenis produk...</option>
                                    @foreach ($typeProducts as $typeProduct)
                                        <option value="{{ $typeProduct->id }}">{{ $typeProduct->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="packaging" class="form-label">Kemasan</label>
                                <input type="text" class="form-control" id="packaging" name="packaging" autocomplete="off" spellcheck="false" title="Kemasan" placeholder="30 Kg/Pail" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="unit" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="unit" name="unit" autocomplete="off" spellcheck="false" title="Satuan" placeholder="Kg" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select name="category" class="form-select select-box" id="category" title="Kategori" required>
                                    <option value="">Pilih kategori...</option>
                                    @foreach ($categoryProducts as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
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
        @endcan

        <div class="card">
            <div class="card-header fw-bold">Data Produk</div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%"></table>
            </div>
        </div>
        
    </section>
@endsection

@push('scripts')
    <script>
        const config = {
                    search: true,
                    creatable: false,
                    clearable: true,
                    size: '',
                }
        let selectBox = document.querySelectorAll('.select-box');
        selectBox.forEach(element => {
            if (element && element.tagName === 'SELECT') {
                dselect(element, config);
            } 
        });
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

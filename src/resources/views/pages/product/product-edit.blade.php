@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produk</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('product.update', $product->id) }}" method="POST" class="needs-validation form-edit" id="editProduct-{{$product->id}}" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header fw-bold">Produk Baru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="code_product" class="form-label">Kode Produk</label>
                                <input type="text" class="form-control" id="code_product" name="code" autocomplete="off" spellcheck="false" title="Kode produk" placeholder="MEICHEMSC01" value="{{ $product->code }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name_product" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" name="name_product" id="name_product" title="Nama Produk" value="{{ $product->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="type_of_product" class="form-label">Jenis Produk</label>
                                <select name="type_of_product" id="type_of_product" class="form-select select-box" title="Kategori produk" required>
                                    <option value="" selected>Pilih jenis produk...</option>
                                    @foreach ($typeProducts as $typeProduct)
                                        <option value="{{ $typeProduct->id }}" {{ $product->type_product_id == $typeProduct->id ? "selected" : "" }}>{{ $typeProduct->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="packaging" class="form-label">Kemasan</label>
                                <input type="text" class="form-control" id="packaging" name="packaging" autocomplete="off" spellcheck="false" title="Kemasan" value="{{ $product->packaging }}" placeholder="30 Kg/Pail" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="unit" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="unit" name="unit" autocomplete="off" spellcheck="false" title="Satuan" value="{{ $product->unit }}" placeholder="Kg" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select name="category" class="form-select select-box" id="category" title="Kategori" required>
                                    <option value="">Pilih kategori...</option>
                                    @foreach ($categoryProducts as $category)
                                        <option value="{{ $category->id }}" {{ $product->category_product_id == $category->id ? "selected" : "" }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="confirmEdit('editProduct-{{$product->id}}')">Simpan</button>
                </div>
            </form>
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
    </script>
@endpush
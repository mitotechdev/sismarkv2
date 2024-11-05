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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code_product" class="form-label">Kode Produk</label>
                                <input type="text" class="form-control" id="code_product" name="code" autocomplete="off" spellcheck="false" title="Kode produk" value="{{ $product->code }}" placeholder="MEICHEMSC01" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="name_product" class="form-label">Nama Produk</label>
                                <input type="text" class="form-control" id="name_product" name="name" autocomplete="off" spellcheck="false" title="Nama produk" value="{{ $product->name }}" placeholder="Alkalinity Booster" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="packaging" class="form-label">Kemasan</label>
                                <input type="text" class="form-control" id="packaging" name="packaging" autocomplete="off" spellcheck="false" title="Kemasan" value="{{ $product->packaging }}" placeholder="30 Kg/Pail" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="unit" class="form-label">Satuan</label>
                                <input type="text" class="form-control" id="unit" name="unit" autocomplete="off" spellcheck="false" title="Satuan" value="{{ $product->unit }}" placeholder="Kg" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select name="category" class="form-select" id="category" title="Kategori" required>
                                    <option value="">Pilih kategori...</option>
                                    <option value="General Chemical" {{ $product->category == "General Chemical" ? "selected" : "" }}>General Chemical</option>
                                    <option value="Specialty Chemical" {{ $product->category == "Specialty Chemical" ? "selected" : "" }}>Specialty Chemical</option>
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
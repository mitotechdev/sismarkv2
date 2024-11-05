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
            <div class="card-header fw-bold">Detail Produk</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="code_product" class="form-label">Kode Produk</label>
                            <input type="text" class="form-control" id="code_product" disabled readonly value="{{ $product->code }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="name_product" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" id="name_product" disabled readonly value="{{ $product->name }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="packaging" class="form-label">Kemasan</label>
                            <input type="text" class="form-control" id="packaging" disabled readonly value="{{ $product->packaging }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="unit" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="unit" disabled readonly value="{{ $product->unit }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="category" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="category" disabled readonly value="{{ $product->category }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('product.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

    </section>
@endsection
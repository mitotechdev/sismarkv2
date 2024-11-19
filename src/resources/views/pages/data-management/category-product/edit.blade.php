@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('category-product.index') }}">Kategori Produk</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('category-product.update', $categoryProduct->id) }}" class="needs-validation" id="editProduct-{{$categoryProduct->id}}" novalidate method="POST">
                @csrf
                @method('PUT')
                <div class="card-header fw-bold">Form Edit</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" name="name" id="name" title="Nama Kategori" autocomplete="off" placeholder="General Chemical" spellcheck="false" value="{{ $categoryProduct->name }}" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" id="description" rows="3" placeholder="Deskripsikan kategori disini" class="form-control" autocomplete="off" spellcheck="false" title="Deskripsi" required>{{ $categoryProduct->description }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary"  type="button" onclick="confirmEdit('editProduct-{{$categoryProduct->id}}')">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
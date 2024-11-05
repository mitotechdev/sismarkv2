@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Menu Jasa</a></li>
              <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>

        <div class="card col-xxl-7 col-12">
            <form action="{{ route('service.update', $service->id) }}" class="needs-validation form-edit" method="POST" novalidate>
                @csrf
                @method('PUT')
                <h5 class="card-header">Informasi Produk</h5>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="codeService" class="form-label">Kode Jasa</label>
                        <input type="text" class="form-control" id="codeService" name="code" autocomplete="off" spellcheck="false" value="{{ $service->code }}" required>
                        <div class="form-text">Kode jasa harus unik dari data produk</div>
                    </div>
                    <div class="mb-3">
                        <label for="nameService" class="form-label">Nama Jasa</label>
                        <input type="text" class="form-control" id="nameService" name="name" autocomplete="off" spellcheck="false" value="{{ $service->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Satuan</label>
                        <input type="text" class="form-control" id="unit" name="unit" autocomplete="off" spellcheck="false" value="{{ $service->unit }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Deskripsi Jasa</label>
                        <textarea class="form-control" id="desc" name="desc" rows="6" placeholder="Deskripsikan jasa disini" required>{{ $service->desc }}</textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>
@endsection
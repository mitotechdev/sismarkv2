@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('type-product.index') }}">Jenis Produk</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('type-product.update', $typeProduct->id) }}" class="needs-validation form-create" id="editTypeProduct-{{$typeProduct->id}}" novalidate method="POST">
                @csrf
                @method('PUT')
                <div class="card-header fw-bold">Form edit</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Jenis</label>
                                <input type="text" class="form-control" name="name" id="name" title="Nama Kategori" autocomplete="off" placeholder="Kaporit" value="{{ $typeProduct->name }}" spellcheck="false" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="confirmEdit('editTypeProduct-{{$typeProduct->id}}')">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
         $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
            });
        });
    </script>
@endpush
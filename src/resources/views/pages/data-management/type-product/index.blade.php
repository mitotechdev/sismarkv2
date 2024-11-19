@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Jenis Produk</li>
            </ol>
        </nav>

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card mb-3">
            <form action="{{ route('type-product.store') }}" class="needs-validation form-create" novalidate method="POST">
                @csrf
                @method('POST')
                <div class="card-header fw-bold">Jenis Produk Baru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">Jenis</label>
                                <input type="text" class="form-control" name="name" id="name" title="Nama Kategori" autocomplete="off" placeholder="Kaporit" spellcheck="false" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>

        <div class="card mb-3">
            <div class="card-header">Data Jenis produk</div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%">
                    <thead>
                        <th>No</th>
                        <th>Name</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($typeProducts as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->name }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a class="btn btn-sm btn-outline-warning" href="{{ route('type-product.edit', $data->id) }}">Edit</a>
                                    <form action="{{ route('type-product.destroy', $data->id) }}" method="POST" id="deleteType-{{ $data->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="button" onclick="commonDelete('deleteType-{{ $data->id }}')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
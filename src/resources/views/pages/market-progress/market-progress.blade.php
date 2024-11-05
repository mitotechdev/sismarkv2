@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Market Progress</li>
            </ol>
        </nav>

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card mb-3">
            <form action="{{ route('market-progress.store') }}" method="POST" class="needs-validation form-create" novalidate>
                @csrf
                @method('POST')
                <div class="card-header fw-bold">Form Market Progress Baru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Progress</label>
                                <input type="text" class="form-control" name="name" id="name" autocomplete="off" spellcheck="false" placeholder="Mapping" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <input type="text" class="form-control" id="status" name="status" autocomplete="off" spellcheck="false" placeholder="Prospect" required>
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
            <div class="card-header">Data Market Progress</div>
            <div class="card-body">
                <table class="table table-hover align-middle" id="datatable_sismark" style="width: 100%; font-size: 14px">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marketProgress as $data)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $data->name }}</td>
                                <td>{{ $data->status }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="{{ route('market-progress.edit', $data->id) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="bx bxs-edit"></i>
                                        </a>
                                        <form action="{{ route('market-progress.destroy', $data->id) }}" method="POST" id="deleteMarketProgress-{{ $data->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="button" onclick="commonDelete('deleteMarketProgress-{{ $data->id }}')">
                                                <i class="bx bx-trash-alt"></i>
                                            </button>
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
            })
        })
    </script>
@endpush



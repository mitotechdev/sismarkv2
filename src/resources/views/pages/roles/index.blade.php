@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Roles</li>
            </ol>
        </nav>

        @if ($message = Session::get("success"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-3">
            <form action="{{ route('roles.store') }}" class="needs-validation form-create" method="POST" novalidate>
                @csrf
                @method('POST')
                <div class="card-header">Roles Terbaru</div>
                <div class="card-body">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Nama Role</label>
                        <input type="text" class="form-control" name="name" id="name" autocomplete="off" spellcheck="false" title="Nama role terbaru" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>

        <div class="card mb-3">
            <div class="card-header">List Roles</div>
            <div class="card-body">
                <table class="table align-middle table-hover" id="datatable_sismark" style="width: 100%; font-size: 14px"></table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $('#datatable_sismark').DataTable({
            responsive: true,
            serverSide: true,
            ajax: "{{ route('roles.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                { data: 'name', name: 'name', title: 'Nama', orderable: true, searchable: true },
                { data: 'aksi', name: 'aksi', title: 'Aksi' },
            ],
        });
    </script>
@endpush
@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pajak</li>
            </ol>
        </nav>

        @if ($message = Session::get("success"))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @elseif($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card shadow-sm rounded">
            @can('create-tax')
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center shadow" data-bs-toggle="modal" data-bs-target="#createTax">
                    <i class='bx bx-plus-circle me-1' style="font-size: 20px"></i>
                    <span>Tambah Data</span>
                </button>

                <div class="modal fade" id="createTax" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                    <form action="{{ route('tax.store') }}" class="needs-validation form-create" method="POST" novalidate>
                        @csrf
                        @method('POST')
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Data Baru</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Pajak</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" spellcheck="false" value="{{ old('name') }}" placeholder="PPN 11%" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tax" class="form-label">Nilai</label>
                                        <input type="number" class="form-control" id="tax" name="tax" step="any" autocomplete="off" spellcheck="false" value="{{ old('tax') }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endcan
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%"></table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                scrollX: true,
                serverSide: true,
                ajax: "{{ route('tax.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'name', name: 'name', title: 'Nama Pajak', footer: 'Nama Pajak', orderable: true},
                    { data: 'tax', name: 'tax', title: 'Nilai', footer: 'Nilai' },
                    { data: 'aksi', name: 'aksi', title: 'Aksi', footer: 'Aksi' },
                ],
            })
        })
    </script>
@endpush
@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Menu Jasa</li>
            </ol>
        </nav>

        @if ($message = Session::get('error') || $message = Session::get('success') || $message = Session::get('updated') || $message = Session::get('deleted'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @if ($message = Session::get('error'))
                        showAlert('Gagal!', 'Kode Jasa <b>{{ $message }}</b> telah terdaftar!', 'error');
                    @elseif ($message = Session::get('success'))
                        showAlert('Sukses!', 'Kode Jasa <b>{{ $message }}</b> berhasil ditambahkan!', 'success');
                    @elseif ($message = Session::get('updated'))
                        showAlert('Sukses!', 'Jasa dengan kode <b>{{ $message }}</b> berhasil diperbaharui!', 'success');
                    @elseif ($message = Session::get('deleted'))
                        showAlert('Sukses!', 'Jasa dengan kode <b>{{ $message }}</b> berhasil dihapus!', 'success');
                    @endif
                });
            </script>
        @endif

        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center shadow" data-bs-toggle="modal" data-bs-target="#createService">
                    <i class='bx bx-plus-circle me-1' style="font-size: 20px"></i>
                    <span>Tambah Data</span>
                </button>

                <div class="modal fade" id="createService" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                    <form action="{{ route('service.store') }}" class="needs-validation form-create" method="POST" novalidate>
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
                                        <label for="codeService" class="form-label">Kode Jasa</label>
                                        <input type="text" class="form-control" id="codeService" name="code" autocomplete="off" spellcheck="false" value="{{ old('code') }}" required>
                                        <div class="form-text">Kode jasa harus unik dari data jasa</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nameService" class="form-label">Nama Jasa</label>
                                        <input type="text" class="form-control" id="nameService" name="name" autocomplete="off" spellcheck="false" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">Satuan</label>
                                        <input type="text" class="form-control" id="unit" name="unit" autocomplete="off" spellcheck="false" value="{{ old('unit') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Kategori Jasa</label>
                                        <input type="text" class="form-control" id="category" name="category" autocomplete="off" spellcheck="false" value="{{ old('category') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="desc" class="form-label">Deskripsi Jasa</label>
                                        <textarea class="form-control" id="desc" name="desc" rows="6" placeholder="Deskripsikan jasa disini" required></textarea>
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
                <div class="mb-0 fw-bold text-muted">DATA MASTER SERVICES</div>
            </div>

            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark">
                    <thead>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Jasa</th>
                        <th>Satuan</th>
                        <th>Kategori Jasa</th>
                        <th>Aksi</th>
                    </thead>
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
                serverSide: true,
                ajax: "{{ route('service.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'code', name: 'code', title: 'Kode', footer: 'Kode' },
                    { data: 'name', name: 'name', title: 'Nama Jasa', footer: 'Nama Jasa' },
                    { data: 'unit', name: 'unit', title: 'Satuan', footer: 'Satuan' },
                    { data: 'category', name: 'category', title: 'Kategori', footer: 'Kategori' },
                    { data: 'aksi', name: 'aksi', title: 'Aksi', footer: 'Aksi' },
                ],
                columnDefs: [
                    { targets: [5], className: 'text-nowrap' }
                ],
                language: {
                    paginate: {
                        first: 'First',
                        previous: '&laquo;',
                        next: '&raquo;',
                        last: 'Last'
                    },
                    aria: {
                        paginate: {
                            first: 'First',
                            previous: 'Previous',
                            next: 'Next',
                            last: 'Last'
                        }
                    },
                    info: 'Showing _START_ to _END_ of _TOTAL_ Entries',
                    lengthMenu: 'Show _MENU_ Entries',
                    search: 'Search:',
                    zeroRecords: 'Data tidak ditemukan!'
                }
            });
        });
    </script>
@endpush
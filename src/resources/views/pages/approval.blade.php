@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Konfigurasi Approval</li>
            </ol>
        </nav>

        @if ($message = Session::get('error') || $message = Session::get('success') || $message = Session::get('updated') || $message = Session::get('deleted') || $message = Session::get('denied'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @if ($message = Session::get('success'))
                        showAlert('Sukses!', 'Status Approval baru <b>{{ $message }}</b> berhasil ditambahkan!', 'success');
                    @elseif ($message = Session::get('error'))
                        showAlert('Gagal!', '{{ $message }}', 'error');
                    @elseif ($message = Session::get('updated'))
                        showAlert('Sukses!', 'Status Approval <b>{{ $message }}</b> berhasil diperbaharui!', 'success');
                    @elseif ($message = Session::get('deleted'))
                        showAlert('Sukses!', 'Item <b>{{ $message }}</b> berhasil dihapus!', 'success');
                    @elseif ($message = Session::get('denied'))
                        showAlert('Perhatian!', '{{ $message }}', 'warning');
                    @endif
                });
            </script>
        @endif

        <div class="card shadow-sm rounded">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center shadow" data-bs-toggle="modal" data-bs-target="#createApproval">
                    <i class='bx bx-plus-circle me-1' style="font-size: 20px"></i>
                    <span>Tambah Data</span>
                </button>

                <div class="modal fade" id="createApproval" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                    <form action="{{ route('approval.store') }}" class="needs-validation form-create" method="POST" novalidate>
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
                                        <label for="name" class="form-label">Nama Level Approval</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" spellcheck="false" value="{{ old('name') }}" placeholder="Draf" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tag_front_end" class="form-label">Kategori Approval</label>
                                        <input type="text" class="form-control" id="tag_front_end" name="tag_front_end" autocomplete="off" spellcheck="false" value="{{ old('tag_front_end') }}" required>
                                        <div class="form-text">Ex: primary, success, danger, warning, info, etc</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tag_status" class="form-label">Tag Validasi</label>
                                        <input type="text" class="form-control" id="tag_status" name="tag_status" autocomplete="off" spellcheck="false" value="{{ old('tag_status') }}" placeholder="draf" required>
                                        <div class="form-text">Digunakan untuk keperluan validasi</div>
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

                <div class="mb-0 fw-bold text-muted mt-sm-0 mt-2">KONFIGURASI APPROVAL</div>
            </div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori Approval</th>
                        <th>Tag Status</th>
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
                ajax: "{{ route('approval.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'name', name: 'name', title: 'Nama', footer: 'Nama' },
                    { data: 'tag_front_end', name: 'tag_front_end', title: 'Kategori', footer: 'Kategori' },
                    { data: 'tag_status', name: 'tag_status', title: 'Validasi', footer: 'Validasi' },
                    { data: 'aksi', name: 'aksi', title: 'Aksi', footer: 'Aksi' },
                ],
            })
        })
    </script>
@endpush
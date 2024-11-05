@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Menu Branches</li>
            </ol>
        </nav>

        @if ($message = Session::get('error') || $message = Session::get('success') || $message = Session::get('updated') || $message = Session::get('deleted'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    @if ($message = Session::get('error'))
                        showAlert('Gagal!', 'Kode branch <b>{{ $message }}</b> telah terdaftar!', 'error');
                    @elseif ($message = Session::get('success'))
                        showAlert('Sukses!', 'Kode branch <b>{{ $message }}</b> berhasil ditambahkan!', 'success');
                    @elseif ($message = Session::get('updated'))
                        showAlert('Sukses!', 'Branch dengan kode <b>{{ $message }}</b> berhasil diperbaharui!', 'success');
                    @elseif ($message = Session::get('deleted'))
                        showAlert('Sukses!', 'Branch dengan kode <b>{{ $message }}</b> berhasil dihapus!', 'success');
                    @endif
                });
            </script>
        @endif

        <div class="card shadow-sm rounded">
            <div class="card-header d-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center shadow" data-bs-toggle="modal" data-bs-target="#createBranch">
                    <i class='bx bx-plus-circle me-1' style="font-size: 20px"></i>
                    <span>Tambah Data</span>
                </button>

                <div class="modal fade" id="createBranch" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                    <form action="{{ route('branches.store') }}" class="needs-validation form-create" method="POST" novalidate>
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
                                        <label for="codeBranch" class="form-label">Kode Branch</label>
                                        <input type="text" class="form-control" id="codeBranch" name="code" autocomplete="off" spellcheck="false" value="{{ old('code') }}" required>
                                        <div class="form-text">Kode branch harus unik dari data master branch</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nameBranch" class="form-label">Nama Branch</label>
                                        <input type="text" class="form-control" id="nameBranch" name="name" autocomplete="off" spellcheck="false" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="npwp" class="form-label">NPWP</label>
                                        <input type="text" class="form-control" id="npwp" name="npwp" autocomplete="off" spellcheck="false" value="{{ old('npwp') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">No. Telepon</label>
                                        <input type="text" class="form-control" id="phone" name="phone" autocomplete="off" spellcheck="false" value="{{ old('phone') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Alamat Branch</label>
                                        <input type="text" class="form-control" id="address" name="address" autocomplete="off" spellcheck="false" value="{{ old('address') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pic" class="form-label">PIC Branch</label>
                                        <input type="text" class="form-control" id="pic" name="pic" autocomplete="off" spellcheck="false" value="{{ old('pic') }}" required>
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

                <div class="mb-0 fw-bold text-muted">DATA MASTER BRANCH</div>
            </div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%">
                    <thead>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>NPWP</th>
                        <th>No. Telepon</th>
                        <th>PIC</th>
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
                ajax: "{{ route('branches.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'code', name: 'code', title: 'Kode', footer: 'Kode' },
                    { data: 'name', name: 'name', title: 'Nama Jasa', footer: 'Nama Jasa' },
                    { data: 'npwp', name: 'npwp', title: 'NPWP', footer: 'NPWP' },
                    { data: 'phone', name: 'phone', title: 'No. Telepon', footer: 'No. Telepon' },
                    { data: 'pic', name: 'pic', title: 'PIC', footer: 'PIC' },
                    { data: 'aksi', name: 'aksi', title: 'Aksi', footer: 'Aksi' },
                ],
            })
        })
    </script>
@endpush
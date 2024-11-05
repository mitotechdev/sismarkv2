@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item"><a href="#">User</a></li>
              <li class="breadcrumb-item active" aria-current="page">Data</li>
            </ol>
        </nav>

        @if ($message = Session::get('error') || $message = Session::get('success') || $message = Session::get('updated') || $message = Session::get('deleted') || $message = Session::get('warning'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    @if ($message = Session::get('success'))
                        showAlert('Sukses!', 'Data <b>{{ $message }}</b> berhasil ditambahkan!', 'success');
                    @elseif ($message = Session::get('error'))
                        showAlert('Gagal!', '{{ $message }}', 'error');
                    @elseif ($message = Session::get('warning'))
                        showAlert('Peringatan!', '{{ $message }}', 'warning');
                    @elseif ($message = Session::get('updated'))
                        showAlert('Sukses!', 'User <b>{{ $message }}</b> berhasil diperbaharui!', 'success');
                    @elseif ($message = Session::get('deleted'))
                        showAlert('Sukses!', '<b>{{ $message }}</b> berhasil dihapus!', 'success');
                    @endif
                });
            </script>
        @endif

        <div class="card shadow-sm">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <button type="button" class="btn btn-primary shadow-sm d-flex align-items-center shadow" data-bs-toggle="modal" data-bs-target="#createUser">
                    <i class='bx bx-plus-circle me-1' style="font-size: 20px"></i>
                    <span>Tambah Data</span>
                </button>

                <div class="modal fade" id="createUser" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
                    <form action="{{ route('user.store') }}" class="needs-validation form-create" method="POST" novalidate>
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
                                        <label for="employee_id" class="form-label">NIK Karyawan</label>
                                        <input type="text" class="form-control" id="employee_id" name="employee_id" autocomplete="off" spellcheck="false" value="{{ old('employee_id') }}" title="NIK Karyawan" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nama Pengguna</label>
                                        <input type="text" class="form-control" id="name" name="name" autocomplete="off" spellcheck="false" value="{{ old('name') }}" title="Nama Pengguna" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">Jenis Kelamin</label>
                                        <select class="form-select" name="gender" id="gender" title="Jenis Kelamin" required>
                                            <option value="" selected>Pilih...</option>
                                            <option value="Pria">Pria</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Telepon</label>
                                        <input type="text" class="form-control" id="phone" name="phone" autocomplete="off" spellcheck="false" value="{{ old('phone') }}" title="Telepon" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" autocomplete="off" spellcheck="false" value="{{ old('email') }}" title="Email" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" autocomplete="off" spellcheck="false" value="{{ old('username') }}" title="Username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" name="password" id="password" title="Password" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="showPassword()">Tampilkan</button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Branch</label>
                                        <select class="form-select" name="branch_id" id="branch_id" title="Branch ID" required>
                                            <option value="" selected>Pilih...</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->code }}</option>
                                            @endforeach
                                        </select>
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

                <div class="mb-0 fw-bold text-muted mt-sm-0 mt-2">DAFTAR PENGGUNA</div>
            </div>
            <div class="card-body">
                <table class="table" id="datatable_sismark" style="width: 100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Telepon</th>
                            <th>Branch</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function showPassword() {
            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                scrollX: true,
                serverSide: true,
                ajax: "{{ route('user.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'employee_id', name: 'employee_id', title: 'NIK', footer: 'NIK', orderable: true },
                    { data: 'name', name: 'name', title: 'Nama', footer: 'Nama', orderable: true },
                    { data: 'username', name: 'username', title: 'Username', footer: 'username', orderable: true },
                    { data: 'phone', name: 'phone', title: 'Telepon', footer: 'Telepon', orderable: true },
                    { data: 'branch_name', name: 'branch_name', title: 'Branch', footer: 'Branch', orderable: true },
                    { data: 'aksi', name: 'aksi', title: 'Aksi', footer: 'Aksi', orderable: true },
                ],
            })
        })
    </script>
@endpush
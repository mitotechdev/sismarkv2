@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>

        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card mb-3">
            <form action="{{ route('user.store') }}" class="needs-validation form-create" method="POST" novalidate>
                @csrf
                @method('POST')
                <div class="card-header">Pengguna Baru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Pengguna <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" title="Nama Pengguna" value="{{ old('name') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select" name="gender" id="gender" title="Jenis Kelamin" required>
                                    <option value="" selected>Pilih...</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" autocomplete="off" spellcheck="false" value="{{ old('phone') }}" title="Telepon" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" autocomplete="off" spellcheck="false" value="{{ old('email') }}" title="Email" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" autocomplete="off" spellcheck="false" value="{{ old('username') }}" title="Username" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password" title="Password" required>
                                    <button class="btn btn-outline-secondary" type="button" onclick="showPassword()"><i class='bx bx-show-alt'></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="username" class="form-label">Branch <span class="text-danger">*</span></label>
                                <select class="form-select select-box" name="branch_id" id="branch_id" title="Branch ID" required>
                                    <option value="" selected>Pilih...</option>
                                    @forelse ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->code }}</option>
                                    @empty
                                        <a href="{{ route('branches.index') }}">Tambah data branch baru</a>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select select-box" name="role" id="role" title="Role pengguna" required>
                                    <option value="" selected>Pilih...</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">Data Pengguna</div>
            <div class="card-body">
                <table class="table align-middle" id="datatable_sismark" style="width: 100%; font-size: 14px"></table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const config = {
                    search: true,
                    creatable: false,
                    clearable: true,
                    size: '',
                }
        let selectBox = document.querySelectorAll('.select-box');
        selectBox.forEach(element => {
            if (element && element.tagName === 'SELECT') {
                dselect(element, config);
            } 
        });

        function showPassword() {
            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }
        }
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
                serverSide: true,
                ajax: "{{ route('user.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'name', name: 'name', title: 'Nama', orderable: true, searchable: true},
                    { data: 'username', name: 'username', title: 'Username', orderable: true, searchable: true},
                    { data: 'phone', name: 'phone', title: 'Telepon', orderable: true, searchable: true},
                    { data: 'branch_name', name: 'branch_name', title: 'Branch', orderable: true, searchable: true},
                    { data: 'role', name: 'role', title: 'Role', orderable: true, searchable: true},
                    { data: 'aksi', name: 'aksi', title: 'Aksi', orderable: true},
                ],
            })
        })
    </script>
@endpush
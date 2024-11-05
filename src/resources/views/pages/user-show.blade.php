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

        <div class="card shadow-sm rounded">
            <div class="card-header fw-bold text-muted">
                Informasi Pengguna
            </div>
            <div class="card-body">
                <form>
                    <div class="row mb-3">
                        <label for="employee_id" class="col-sm-2 col-form-label">NIK</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="employee_id" id="employee_id" title="Nomor Induk Karyawan" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="full_name" class="col-sm-2 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="full_name" id="full_name" title="Nama Lengkap Karyawan" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nickname" class="col-sm-2 col-form-label">Alias</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="nickname" id="nickname" title="Alias" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" title="Email" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Nomor Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="phone" id="phone" title="Nomor Telepon" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="username" title="Username" required autocomplete="off">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="password" title="Password" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="showPassword()">Tampilkan</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="role" class="col-sm-2 col-form-label">Role Sistem</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="role" id="role" title="Role" required>
                                <option value="" selected>Pilih role...</option>
                                <option value="Admin">Admin</option>
                                <option value="Sales">Sales</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="branch_id" class="col-sm-2 col-form-label">Branch</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="branch_id" id="branch_id" title="Branch" required>
                                <option value="" selected>Pilih Branch...</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
    </script>
@endpush
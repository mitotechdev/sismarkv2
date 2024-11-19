@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pengaturan</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('pengaturan.update', $user->id) }}" class="needs-validation" method="POST" id="editPengaturan" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header">Pengaturan Profile</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Nama Pengguna</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" id="name" title="Nama pengguna" autocomplete="off" value="{{ $user->name }}" spellcheck="false" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="gender" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <select class="form-select" name="gender" id="gender" title="Jenis Kelamin" required>
                                <option value="" selected>Pilih...</option>
                                <option value="Pria" {{ $user->gender == "Pria" ? "selected" : "" }}>Pria</option>
                                <option value="Perempuan" {{ $user->gender == "Perempuan" ? "selected" : "" }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">No. Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="phone" id="phone" title="Nomor telepon" autocomplete="off" spellcheck="false" value="{{ $user->phone }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" name="email" id="email" title="Email" autocomplete="off" spellcheck="false" value="{{ $user->email }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="username" id="username" title="Username" autocomplete="off" spellcheck="false" value="{{ $user->username }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" id="password" title="Password" autocomplete="off" spellcheck="false">
                        </div>
                    </div>
                    @can('admin-switch-branch')
                    <div class="row mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Branch</label>
                        <div class="col-sm-10">
                            <select class="form-select select-box" name="branch_id" id="branch_id" title="Branch ID" required>
                                <option value="" selected>Pilih...</option>
                                @foreach ($branches as $branch)
                                    <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? "selected" : "" }}>{{ $branch->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>   
                    @endcan
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="confirmEdit('editPengaturan')">Simpan Perubahan</button>
                </div>
            </form>
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
    </script>
@endpush
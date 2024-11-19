@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Users</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('user.update', $user->id) }}" class="needs-validation" id="editUser-{{ $user->id }}" method="POST" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header">Data Pengguna</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="" class="form-label">Nama Pengguna <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" title="Nama Pengguna" value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="gender" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select class="form-select" name="gender" id="gender" title="Jenis Kelamin" required>
                                    <option value="" selected>Pilih...</option>
                                    <option value="Pria" {{ $user->gender == "Pria" ? "selected" : "" }}>Pria</option>
                                    <option value="Perempuan" {{ $user->gender == "Perempuan" ? "selected" : "" }}>Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="phone" class="form-label">No. Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" name="phone" autocomplete="off" spellcheck="false" value="{{ $user->phone }}" title="Telepon" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" autocomplete="off" spellcheck="false" value="{{ $user->email }}" title="Email" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" autocomplete="off" spellcheck="false" value="{{ $user->username }}" title="Username" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" id="password" title="Password">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="username" class="form-label">Branch <span class="text-danger">*</span></label>
                                <select class="form-select select-box" name="branch_id" id="branch_id" title="Branch ID" required>
                                    <option value="" selected>Pilih...</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}" {{ $user->branch_id == $branch->id ? "selected" : "" }}>{{ $branch->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                <select class="form-select select-box" name="role" id="role" title="Role pengguna" required>
                                    <option value="" selected>Pilih...</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ $user->getRoleNames()->first() == $role->name ? "selected" : "" }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="confirmEdit('editUser-{{$user->id}}')">Simpan Perubahan</button>
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
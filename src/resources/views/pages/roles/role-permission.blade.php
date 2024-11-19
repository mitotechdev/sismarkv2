@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                <li class="breadcrumb-item active" aria-current="page">Permission</li>
            </ol>
        </nav>

        @if($message = Session::get('error'))
        <div class="alert alert-danger">
            {{ $message }}
        </div>
        @endif

        <form action="{{ route('role.give.permission', $role->id) }}" method="POST" class="needs-validation form-create">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="col">
                        <h3 class="fw-bold">{{ $role->name }}</h3>
                        List Permission
                    </div>
                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" value="" id="checkAllPermission">
                        <label class="form-check-label" for="checkAllPermission">Give All Permission</label>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($permissions as $key => $permission)
                        <div class="col-md-4 col-lg-3 col-sm-6">
                            <div class="header mb-2">
                                <h5 class="mb-0">{{ $key  }}</h5>
                            </div>
                            @foreach ($permission as $item)
                            <div class="form-check form-switch mb-2">
                                <input class="form-check-input form-check-permission" type="checkbox" value="{{ $item->name }}" name="permission[]" id="{{ $item->id }}" {{ $role->permissions->contains('id', $item->id) ? "checked" : "" }}>
                                <label class="form-check-label" for="{{ $item->id }}">{{ $item->slug }}</label>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline-primary">Save Permission</button>
                </div>
            </div>
        </form>
    </section>
@endsection

@push('scripts')
    <script>
        const inputCheckPermission = document.querySelectorAll('.form-check-permission');
        const inputCheckboxChecked = document.querySelectorAll('input[type="checkbox"]:checked');

        let previousCheckedStatus = [];
        inputCheckboxChecked.forEach(inputCheckbox => {
            previousCheckedStatus.push(inputCheckbox);
        });
        

        if (checkAllPermission) {
            checkAllPermission.addEventListener('change', function() {
                if (this.checked) {
                    inputCheckPermission.forEach(inputCheck => {
                        inputCheck.checked = this.checked;
                    });
                } else {
                    inputCheckPermission.forEach(inputCheck => {
                        if (!previousCheckedStatus.includes(inputCheck)) {
                            inputCheck.checked = false;
                        }
                    });
                }
            });
        }
    </script>
@endpush
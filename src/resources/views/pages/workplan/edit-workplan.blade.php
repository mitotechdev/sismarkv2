@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('workplan.index') }}">Workplan</a></li>
              <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="card">
            <form action="{{ route('workplan.update', $workplan->id) }}" method="POST" id="editWorkplan-{{$workplan->id}}" class="needs-validation form-edit" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header">Form Edit</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name_customer" class="form-label">Nama Customer</label>
                                <select name="name_customer" id="name_customer" class="form-select select-box" onchange="showDetail(this.value)" required>
                                    <option value="" selected>Pilih customer...</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $workplan->customer_id == $customer->id ? "selected" : "" }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="segmen" class="form-label">Segmen</label>
                                <input type="hidden" name="category_customer" id="category_customer" required>
                                <input type="text" class="form-control" id="segmen" readonly disabled title="Segmen customer" value="{{ $workplan->category_customer->name }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status_customer" class="form-label">Status Customer</label>
                                <input type="text" class="form-control" id="status_customer" readonly disabled value="{{ $workplan->customer->type_customer->name }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit" onclick="confirmEdit('editWorkplan-{{$workplan->id}}')">Simpan Perubahan</button>
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

        dselect(document.querySelector('.select-box'), config); 

        function showDetail(data) {
            if(data) {
                const url = '{{ route("api.customer.show", ["id" => ":id"]) }}'.replace(':id', data); 
                fetch(url)
                .then(response => response.json())
                .then(item => {
                    segmen.value = item.category_customer.name;
                    status_customer.value = item.type_customer.name;

                    // for store data
                    category_customer.value = item.category_customer.id;
                });
            } else {
                segmen.value = "";
                status_customer.value = "";
                category_customer.value = "";
            }
        }
    </script>
@endpush
@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Realisasi Kerja</li>
            </ol>
        </nav>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                {{ $message }}
            </div>
        @endif

        @can('create-realisasi-kerja')
        <form action="{{ route('workplan.store') }}" class="needs-validation form-create" method="POST" novalidate>
            @csrf
            @method('POST')
            <div class="card mb-3">
                <div class="card-header fw-bold">Realisasi Kerja Baru</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name_customer" class="form-label">Nama Customer</label>
                                <select name="name_customer" id="name_customer" class="form-select select-box" onchange="showDetail(this.value)" required>
                                    <option value="" selected>Pilih customer...</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="segmen" class="form-label">Segmen</label>
                                <input type="hidden" name="category_customer" id="category_customer" required>
                                <input type="text" class="form-control" title="Segmen Customer" id="segmen" readonly disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status Customer</label>
                                <input type="text" class="form-control" id="status_customer" title="Status Customer" readonly disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Simpan Data</button>
                </div>
            </div>
        </form>
        @endcan
    
        <div class="card shadow-sm">
            <div class="card-header fw-bold">Data Realisasi Kerja</div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%; font-size: 14px"></table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
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

        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
                serverSide: true,
                ajax: "{{ route('workplan.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'sales', name: 'sales', title: 'Sales', orderable: true},
                    { data: 'name_customer', name: 'name_customer', title: 'Customer', orderable: true, searchable: true },
                    { data: 'segmen', name: 'segmen', title: 'Segmen', orderable: true, searchable: true },
                    { data: 'progress', name: 'progress', title: 'Market Progress', orderable: true },
                    { data: 'status', name: 'status', title: 'Status', orderable: true },
                    { data: 'aksi', name: 'aksi', title: 'Aksi'},
                ],
            })
        })

    </script>
@endpush
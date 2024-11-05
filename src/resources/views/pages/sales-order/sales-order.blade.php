@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Purchase Order</li>
            </ol>
        </nav>
    </section>

    @if ($message = Session::get("success"))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $error }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endforeach

    <div class="card mb-3">
        <form action="{{ route('sales-order.store') }}" method="POST" class="needs-validation form-create" novalidate>
            @csrf
            @method('POST')
            <input type="hidden" id="segmen" name="segmen">
            <div class="card-header fw-bold">Purchase Order Baru</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name_sales" class="form-label">Nama Sales</label>
                            <select class="form-select select-box" name="sales" id="name_sales" title="Nama Sales" required>
                                <option value="" selected>Pilih sales...</option>
                                @foreach ($users as $sales)
                                    <option value="{{ $sales->id }}" {{ old('sales_id') == $sales->id ? "selected" : "" }}>{{ $sales->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="name_customer" class="form-label">Nama Customer</label>
                            <select class="form-select select-box" name="name_customer" id="name_customer" onchange="getDataCustomer(this.value)" title="Nama Customer" required>
                                <option value="" selected>Pilih customer...</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('name_customer') == $customer->id ? "selected" : "" }}>{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="no_po" class="form-label">Nomor Sales Order </label>
                            <input type="text" class="form-control" name="no_sales_order" id="no_po" title="Nomor Purchase Order" placeholder="Nomor Purchase Order" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="order_date" class="form-label">Tanggal Order</label>
                            <input type="date" class="form-control" name="order_date" id="order_date" title="Tanggal Order" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tax_rate" class="form-label">PPN</label>
                            <select name="tax_rate" id="tax_rate" class="form-select select-box" title="Pajak" required>
                                <option value="" selected>Pilih PPN...</option>
                                @foreach ($taxes as $tax)
                                    <option value="{{ $tax->id }}">{{ $tax->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="top" class="form-label">Term of Payment (TOP)</label>
                            <input type="date" class="form-control" name="top" id="top" title="Term of Payment" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>

    {{-- Total PO per category segmen --}}
    <div class="container-fluid mb-3">
        <div class="row gap-2">
            @foreach ($countPerCategorySegmen as $data)
            <div class="col-lg-3 bg-white p-3 rounded border">
                <div class="row">
                    <label for="segmen" class="form-label mb-0">{{ $data->segmen->name }}</label>
                    <small class="text-muted" style="font-size: 12px">Total purchase order</small>
                    <div class="h3 fw-bold">{{ $data->total_po }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Data Purchase Order --}}
    <div class="card">
        <div class="card-header">Data Purchase Order</div>
        <div class="card-body">
            <table class="table align-middle table-hover" id="datatable_sismark" style="width: 100%; font-size: 14px"></table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    function getDataCustomer(data) {
        if(data) {
            const url = '{{ route("api.customer.show", ["id" => ":id"]) }}'.replace(':id', data);
            fetch(url)
            .then(response => response.json())
            .then(item => {
                $('#segmen').val(item.category_customer_id);
            });
        } else {
            $('#segmen').val('');
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
    $('#datatable_sismark').DataTable({
        responsive: true,
        serverSide: true,
        ajax: "{{ route('sales-order.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
            { data: 'code', name: 'code', title: 'ID', orderable: true },
            { data: 'tanggal_order', name: 'tanggal_order', title: 'Order', orderable: true, searchable: true},
            { data: 'sales', name: 'sales', title: 'Sales', orderable: true, searchable: true},
            { data: 'konsumen', name: 'konsumen', title: 'Customer', orderable: true, searchable: true},
            { data: 'segmen', name: 'segmen', title: 'Segmen', orderable: true, searchable: true},
            { data: 'no_sales_order', name: 'no_sales_order', title: 'PO', orderable: true, searchable: true},
            { data: 'top', name: 'top', title: 'TOP', orderable: true, searchable: true},
            { data: 'status', name: 'status', title: 'Status', render: function($data) {
                const data = JSON.parse($data);
                return '<span class="badge text-bg-'+ data.approval.tag_front_end +'">'+ data.approval.name +'</span>';
            }},
            { data: 'aksi', name: 'aksi', title: 'Act.'},
        ],
    });
</script>
@endpush


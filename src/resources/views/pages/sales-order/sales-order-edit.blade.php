@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales-order.index') }}">Purchase Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('sales-order.update', $salesOrder->id) }}" method="POST" class="needs-validation" id="formEditSalesOrder-{{$salesOrder->id}}" novalidate>
                @csrf
                @method('PUT')
                <div class="card-header fw-bold">Purchase Order Terkini</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name_sales" class="form-label">Nama Sales</label>
                                <select class="form-select select-box" name="sales" id="name_sales" title="Nama Sales" required>
                                    <option value="" selected>Pilih sales...</option>
                                    @foreach ($users as $sales)
                                        <option value="{{ $sales->id }}" {{ $salesOrder->sales_id == $sales->id ? "selected" : "" }}>{{ $sales->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name_customer" class="form-label">Nama Customer</label>
                                <select class="form-select select-box" name="name_customer" id="name_customer" title="Nama Customer" required>
                                    <option value="" selected>Pilih customer...</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $salesOrder->customer_id == $customer->id ? "selected" : "" }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="no_po" class="form-label">Nomor Sales Order </label>
                                <input type="text" class="form-control" name="no_sales_order" id="no_po" title="Nomor Purchase Order" placeholder="Nomor Purchase Order" value="{{ $salesOrder->no_sales_order }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="order_date" class="form-label">Tanggal Order</label>
                                <input type="date" class="form-control" name="order_date" id="order_date" title="Tanggal Order" value="{{ $salesOrder->order_date->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tax_rate" class="form-label">PPN</label>
                                <select name="tax_rate" id="tax_rate" class="form-select select-box" title="Pajak" required>
                                    <option value="" selected>Pilih PPN...</option>
                                    @foreach ($taxes as $tax)
                                        <option value="{{ $tax->id }}" {{ $salesOrder->tax_id == $tax->id ? "selected" : "" }}>{{ $tax->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="button" onclick="confirmEdit('formEditSalesOrder-{{$salesOrder->id}}')" >Simpan Perubahan</button>
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
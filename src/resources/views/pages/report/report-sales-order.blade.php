@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Report PO</li>
            </ol>
        </nav>

        <div class="d-flex gap-3 mb-3">
            <div class="col-md-5 bg-white p-4 shadow-sm rounded mb-3">
                <div class="row">
                    <div class="h6 fw-bold mb-0 text-muted">Total Revenue PO</div>
                    <div class="form-text" style="font-size: 11px">Berdasarkan akumulasi purchase order yang <strong class="text-success">Approved</strong></div>
                    <div class="h3 fw-bold mt-3">{{ 'Rp ' . number_format($totalRevenueOrders, "2", ",", ".") }}</div>
                </div>
            </div>
            <div class="col-md-5 bg-white p-4 shadow-sm rounded mb-3">
                <div class="row">
                    <div class="h6 fw-bold mb-0 text-muted">Total PO In</div>
                    <div class="form-text" style="font-size: 11px">Berdasarkan akumulasi purchase order yang <strong class="text-success">Approved</strong></div>
                    <div class="h3 fw-bold mt-3">{{ number_format($salesOrder->count(), "0", ",", ".") }} Data</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Data Purchase Order</div>
            <div class="card-body">
                <table class="table align-middle table-hover" id="datatable_sismark" style="width: 100%; font-size: 14px"></table>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
                serverSide: true,
                ajax: "{{ route('report.purchase.order') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'code', name: 'code', title: 'ID', orderable: true },
                    { data: 'sales', name: 'sales', title: 'Sales', orderable: true },
                    { data: 'segmen', name: 'segmen', title: 'Segmen', orderable: true},
                    { data: 'konsumen', name: 'konsumen', title: 'Customer', orderable: true},
                    { data: 'product', name: 'product', title: 'Item', orderable: true},
                    { data: 'qty', name: 'qty', title: 'Qty', orderable: true},
                    { data: 'price', name: 'price', title: 'Harga', orderable: true},
                    { data: 'sum_price', name: 'sum_price', title: 'Total', orderable: true},
                ]
            });
        })
    </script>
@endpush
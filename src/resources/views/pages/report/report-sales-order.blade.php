@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Orders</li>
            </ol>
        </nav>

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
                ajax: "{{ route('report.list.purchase.order') }}",
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
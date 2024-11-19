@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Rekap Purchase Order</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <span class="badge "></span>
            <div class="card-header">Data Purchase Order</div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%; font-size: 14px"></table>
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
                    { data: 'tanggal_order', name: 'tanggal_order', title: 'Order', orderable: true, searchable: true},
                    { data: 'no_sales_order', name: 'no_sales_order', title: 'PO', orderable: true, searchable: true},
                    { data: 'sales', name: 'sales', title: 'Sales', orderable: true, searchable: true},
                    { data: 'konsumen', name: 'konsumen', title: 'Customer', orderable: true, searchable: true},
                    { data: 'segmen', name: 'segmen', title: 'Segmen', orderable: true, searchable: true},
                    { data: 'total_po', name: 'total_po', title: 'Total Payment', orderable: true, searchable: true},
                    { data: 'outstanding_balance', name: 'outstanding_balance', title: 'Outstanding', orderable: true, searchable: true, render: function(data) {
                        if(data == null) {
                            return `<span class="badge rounded-pill text-bg-success">Lunas</span>`;
                        } else {
                            return data;
                        }
                    }},
                    { data: 'uninvoiced', name: 'uninvoiced', title: 'Belum Invoice', orderable: true, searchable: true},
                    { data: 'paid_amount', name: 'paid_amount', title: 'Total Lunas', orderable: true, searchable: true, render: function(data) {
                        if(data == 0) {
                            return `<span class="badge rounded-pill text-bg-warning">Pending</span>`;
                        } else {
                            return data.toLocaleString("id-ID", { 
                                style: "currency", 
                                currency: "IDR",
                            }).replace("Rp ", "IDR ");
                        }
                    }},
                ],
            });
        });
    </script>
@endpush
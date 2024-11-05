@extends('layout')
@section('content')
    <section>   
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Outstanding</li>
            </ol>
        </nav>

        <div class="card shadow-sm">
            <div class="card-header">Data Outstanding</div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%"></table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                scrollX: true,
                serverSide: true,
                ajax: "{{ route('sales.order.outstanding') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'code', name: 'code', title: 'Kode', footer: 'Kode', orderable: true},
                    { data: 'konsumen', name: 'konsumen', title: 'Customer', footer: 'Customer' },
                    { data: 'no_sales_order', name: 'no_sales_order', title: 'PO Customer', footer: 'PO Customer' },
                    { data: 'total', name: 'total', title: 'Total Invoice', footer: 'Total Invoice' },
                    { data: 'status', name: 'status', title: 'Status', footer: 'Status' },
                    { data: 'aksi', name: 'aksi', title: 'Aksi', footer: 'Aksi' },
                ],
            })
        })
    </script>
@endpush
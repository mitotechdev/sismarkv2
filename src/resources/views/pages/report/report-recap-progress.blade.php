@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Rekap Progress</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-header fw-bold">Data Rekap Progress</div>
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
                ajax: "{{ route('report.progress') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', title: 'No', orderable: false, searchable: false },
                    { data: 'code_progress', name: 'code_progress', title: 'ID', orderable: true, searchable: true},
                    { data: 'date_progress', name: 'date_progress', title: 'Tanggal', orderable: true, searchable: true} ,
                    { data: 'sales', name: 'sales', title: 'Sales', orderable: true, searchable: true },
                    { data: 'customer_name', name: 'customer_name', title: 'Customer', orderable: true, searchable: true },
                    { data: 'market_progress', name: 'market_progress', title: 'Market Progress', orderable: true, searchable: true },
                    { data: 'issue', name: 'issue', title: 'Deksripsi', orderable: true, searchable: true },
                    { data: 'next_action', name: 'next_action', title: 'Next Action', orderable: true, searchable: true }
                ],
            })
        })
    </script>
@endpush
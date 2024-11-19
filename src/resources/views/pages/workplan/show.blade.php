@extends('layout')

@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('workplan.index') }}">Realisasi Kerja</a></li>
              <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="" class="form-label text-muted">Sales</label>
                        <div class="form-label h6">{{ $workplan->sales->name }}</div>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label text-muted">Customer</label>
                        <div class="form-label h6">{{ $workplan->customer->name }}</div>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label text-muted">Segmen</label>
                        <div class="form-label h6">{{ $workplan->customer->category_customer->name }}</div>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label text-muted">Market Progress</label>
                        @if ($workplan->market_progress_id == null)
                            <div class="form-label">
                                <span class="badge text-bg-warning">Draf</span>
                            </div>
                        @else
                            <div class="form-label">
                                <span class="badge text-bg-success">{{ $workplan->market_progress->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Rekap progress</div>
            <div class="card-body">
                <table class="table table-striped align-middle" id="datatable_sismark" style="width: 100%; font-size: 14px">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Market Progress</th>
                            <th>Deskripsi</th>
                            <th>Next Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($progressWorkplans as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->market_progress->name }}</td>
                                <td>{{ $data->issue }}</td>
                                <td>{{ $data->next_action }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </section>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
            });
        })
    </script>
@endpush
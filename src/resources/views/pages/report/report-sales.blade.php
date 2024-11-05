@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Sales</li>
            </ol>
        </nav>


        <div class="row g-0 gap-3 mb-3">
            <div class="col bg-white p-3 shadow-sm rounded">
                {!! $chartTopSalesProduct->container() !!}
            </div>
            
            <div class="col bg-white p-3 shadow-sm rounded">
                {!! $chartTopSellingSales->container() !!}
            </div>
        </div>

        <div class="row g-0 gap-3 mb-3">
            <div class="col bg-white py-3 px-sm-0 px-3 shadow-sm rounded">
                {!! $chartMonthlyRevenue->container() !!}
            </div>
            <div class="col shadow-sm rounded">
                <div class="card">
                    <div class="card-header">List Sales</div>
                    <div class="card-body">
                        <table class="table table-hover text-start align-middle" id="datatable_sismark" style="width: 100%">
                            <thead>
                                <tr>
                                    <th class="text-start">No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $item)
                                    <tr>
                                        <td class="text-start">{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>
                                            <a href="{{ route('report.sales.detail', $item->id) }}" class="btn badge rounded-pill text-bg-primary">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-0 gap-3 mb-3">
            <div class="col bg-white p-3 shadow-sm rounded">
                {!! $chartStatsProspect->container() !!}
            </div>

            <div class="col bg-white p-3 shadow-sm rounded">
                {!! $chartStatSegmenSales->container() !!}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ $chartStatSegmenSales->cdn() }}"></script>
    {{ $chartStatSegmenSales->script() }}

    <script src="{{ $chartTopSellingSales->cdn() }}"></script>
    {{ $chartTopSellingSales->script() }}

    <script src="{{ $chartTopSalesProduct->cdn() }}"></script>
    {{ $chartTopSalesProduct->script() }}

    <script src="{{ $chartMonthlyRevenue->cdn() }}"></script>
    {{ $chartMonthlyRevenue->script() }}

    <script src="{{ $chartStatsProspect->cdn() }}"></script>
    {{ $chartStatsProspect->script() }}

    <script>
        $(document).ready(function() {
            $('#datatable_sismark').DataTable({
                responsive: true,
                lengthMenu: [5],
            })
        })
    </script>

@endpush
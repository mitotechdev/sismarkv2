@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('report.sales') }}">Sales</a></li>
              <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>

        <div class="h5 mb-4">Statistik Sales {{ $user->name }}</div>

        <div class="row g-0 gap-3 mb-3">
            <div class="col-md-5 bg-white p-3 shadow-sm rounded">
                {!! $chartStatsProspectSales->container() !!}
            </div>
        
            <div class="col-md-6 bg-white p-3 shadow-sm rounded">
                {!! $chartTopSellingProductBySales->container() !!}
            </div>
        </div>

        <div class="row g-0 gap-3">
            <div class="col-md-5 bg-white p-3 shadow-sm rounded">
                {!! $chartStatsSegmenPerSales->container() !!}
            </div>
        </div>

    </section>
@endsection

@push('scripts')

    <script src="{{ $chartStatsSegmenPerSales->cdn() }}"></script>
    {{ $chartStatsSegmenPerSales->script() }}

    <script src="{{ $chartStatsProspectSales->cdn() }}"></script>
    {{ $chartStatsProspectSales->script() }}

    <script src="{{ $chartTopSellingProductBySales->cdn() }}"></script>
    {{ $chartTopSellingProductBySales->script() }}

   


@endpush
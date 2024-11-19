@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>

        <h4>Selamat Datang, {{ Auth::user()->name }}</h4>

        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header" style="background-color: rgb(238 238 238)">Total Revenue</div>
                    <div class="card-body">
                        <h3 class="fw-bold">{{ 'Rp ' . number_format($totalRevenue, 0, ',', '.') }}</h3>
                        <small class="mb-1 text-muted">Total keseluruhan nilai PO</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header" style="background-color: rgb(238 238 238)">Outstanding Balance</div>
                    <div class="card-body">
                        <h3 class="fw-bold text-info">{{ 'Rp ' . number_format($totalOutstandingBalance, 0, ',', '.') }}</h3>
                        <small class="mb-1 text-muted">Total keseluruhan outstanding</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header" style="background-color: rgb(238 238 238)">Total Earnings</div>
                    <div class="card-body">
                        <h3 class="fw-bold text-success">{{ 'Rp ' . number_format($totalEarnings, 0, ',', '.') }}</h3>
                        <small class="mb-1 text-muted">Total invoice telah dibayarkan</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header" style="background-color: rgb(238 238 238)">Total Uninvoiced</div>
                    <div class="card-body">
                        <h3 class="fw-bold text-secondary">{{ 'Rp ' . number_format($totalUninvoice, 0, ',', '.') }}</h3>
                        <small class="mb-1 text-muted">Total belum terbit invoice</small>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        {!! $chartMonthlyRevenue->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        {{-- Pie Chart --}}
                        {!! $grapSalesBySegment->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        {!! $totalPoPerCustomer->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        {{ $chartStatsProspect->container() }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        {{-- Polar Chart --}}
                        {{ $chartStatSegmenSalesChart->container() }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        {!! $chartTopSellingSales->container() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        {!! $chartTopSalesProduct->container() !!}
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ $grapSalesBySegment->cdn() }}"></script>
            {{-- Pie Chart --}}
            {{ $grapSalesBySegment->script() }}
            {{-- Polar Area Chart --}}
            {{ $chartStatSegmenSalesChart->script() }} 
    
    <script src="{{ $totalPoPerCustomer->cdn() }}"></script>
            {{-- Bar Chart --}}
            {{ $totalPoPerCustomer->script() }}
            {{ $chartStatsProspect->script() }}
            {{ $chartTopSalesProduct->script() }}

    <script src="{{ $chartMonthlyRevenue->cdn() }}"></script>
            {{-- Area Chart --}}
            {{ $chartMonthlyRevenue->script() }}

    <script src="{{ $chartTopSellingSales->cdn() }}"></script>
            {{-- Horizontal Bar --}}
            {{ $chartTopSellingSales->script() }}

@endpush
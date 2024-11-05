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
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header" style="background-color: rgb(238 238 238)">Total Revenue</div>
                    <div class="card-body">
                        <h2 class="fw-bold">{{ 'Rp ' . number_format($totalRevenue, 0, ',', '.') }}</h2>
                        <small class="mb-1 text-muted">Pendapatan {{ Auth::user()->branch->name }}</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header" style="background-color: rgb(238 238 238)">Total Sales Order</div>
                    <div class="card-body">
                        <h2 class="fw-bold">{{ $totalSalesOrder }}</h2>
                        <small class="mb-1 text-muted">Total PO {{ Auth::user()->branch->name }}</small>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header" style="background-color: rgb(238 238 238)">Customer</div>
                    <div class="card-body">
                        <h2 class="fw-bold">{{ $totalCustomer }}</h2>
                        <small class="mb-1 text-muted">Total customer {{ Auth::user()->branch->name }}</small>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        {!! $chartMonthlyRevenue->container() !!}
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
    <script src="{{ $chartMonthlyRevenue->cdn() }}"></script>
    {{ $chartMonthlyRevenue->script() }}

    <script src="{{ $chartTopSellingSales->cdn() }}"></script>
    {{ $chartTopSellingSales->script() }}

    <script src="{{ $chartTopSalesProduct->cdn() }}"></script>
    {{ $chartTopSalesProduct->script() }}
@endpush
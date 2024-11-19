@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Download Payments</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="{{ route('download.payment') }}" method="GET">
                <div class="card-header">Form filter</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="sales" class="form-label">Sales</label>
                                <select name="sales" id="sales" class="form-select select-box" title="Nama sales">
                                    <option value="" selected>Pilih sales...</option>
                                    @foreach ($sales as $data)
                                        <option value="{{ $data->id }}" {{ request()->input('sales') == $data->id ? "selected" : "" }}>{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tanggal_awal" class="form-label">Tanggal awal</label>
                                <input type="date" class="form-control" name="dateMin" id="tanggal_awal" title="Tanggal awal" value="{{ request()->input('dateMin') }}" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="tanggal_akhir" class="form-label">Tanggal akhir</label>
                                <input type="date" class="form-control" name="dateMax" id="tanggal_akhir" title="Tanggal akhir" value="{{ request()->input('dateMax') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Filter Data</button>
                </div>
            </form>
        </div>
        
        <div class="card">
            <div class="card-header">Data Payments</div>
            <div class="card-body">
                @if ($results)
                    @if (count($results) > 0)
                        <div class="d-flex gap-2">
                            <form action="{{ route('export.payment.pdf') }}" method="POST" target="__blank" >
                                @csrf
                                @method('POST')
                                <input type="hidden" name="sales" value="{{ request()->input('sales') }}">
                                <input type="hidden" name="dateMin" value="{{ request()->input('dateMin') }}">
                                <input type="hidden" name="dateMax" value="{{ request()->input('dateMax') }}">
    
                                <button class="btn btn-sm btn-success" type="submit"><i class='bx bx-printer'></i> PDF</button>
                            </form>
                            <form action="{{ route('export.payment.excel') }}" method="POST" target="__blank" >
                                @csrf
                                @method('POST')
                                <input type="hidden" name="sales" value="{{ request()->input('sales') }}">
                                <input type="hidden" name="dateMin" value="{{ request()->input('dateMin') }}">
                                <input type="hidden" name="dateMax" value="{{ request()->input('dateMax') }}">
    
                                <button class="btn btn-sm btn-success" type="submit"><i class='bx bx-printer'></i> Excel</button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-warning">Data tidak ditemukan!</div>
                    @endif

                    <table class="table align-middle table-hover mt-3" id="datatable_sismark" style="width: 100%; font-size: 14px">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Order</th>
                                <th>Sales</th>
                                <th>PO</th>
                                <th>Customer</th>
                                <th>Total PO</th>
                                <th>Outstanding Balance</th>
                                <th>Belum Invoice</th>
                                <th>Total Lunas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $key =>$data)
                                @php
                                    $totalPo = 0;
                                    foreach ($data->sales_order_items as $item) {
                                        $totalPo += $item->qty * $item->price;
                                    }
                                    $ppn = $totalPo * $data->tax->tax;
                                    $grandTotal = $totalPo + $ppn;

                                    $totalInvoicePaid = 0;
                                    $totalInvoiceUnpaid = 0;

                                    foreach ($data->recap_invoice as $item) {
                                        if ($item->date_payment != null) {
                                            $totalInvoicePaid += $item->total_payment;
                                        } else {
                                            $totalInvoiceUnpaid += $item->total_payment;
                                        }
                                    }
                                    $totalOutstanding = 0;
                                    $sumTotalUnpaidAndPaid = $totalInvoicePaid + $totalInvoiceUnpaid;
                                    $totalUninvoiced = max(0, $grandTotal - ($totalInvoicePaid + $totalInvoiceUnpaid));

                                    if ($grandTotal >= $sumTotalUnpaidAndPaid) {
                                        if ($totalInvoiceUnpaid >= $totalInvoicePaid) {
                                            $totalOutstanding = $totalInvoiceUnpaid;
                                        } else {
                                            $totalOutstanding = $totalInvoiceUnpaid;
                                        }
                                    }
                                @endphp

                                <tr>
                                    <td>{{ $results->firstItem() + $key }}</td>
                                    <td>{{ $data->order_date->format('d/m/Y') }}</td>
                                    <td>{{ $data->sales->name }}</td>
                                    <td>{{ $data->no_sales_order }}</td>
                                    <td>{{ $data->customer->name }}</td>
                                    <td>{{ 'Rp '. number_format($grandTotal, 2, ',', '.'); }}</td>
                                    <td>{{ 'Rp '. number_format($totalOutstanding, 2, ',', '.') }}</td>
                                    <td>{{ 'Rp '. number_format($totalUninvoiced, 2, ',', '.') }}</td>
                                    <td>{{ 'Rp '. number_format($totalInvoicePaid, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-warning">Cari data terlebih dahulu!</div>
                @endif
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        const config = {
                    search: true,
                    creatable: false,
                    clearable: true,
                    size: '',
                }
        let selectBox = document.querySelectorAll('.select-box');
        selectBox.forEach(element => {
            if (element && element.tagName === 'SELECT') {
                dselect(element, config);
            } 
        });
    </script>
@endpush
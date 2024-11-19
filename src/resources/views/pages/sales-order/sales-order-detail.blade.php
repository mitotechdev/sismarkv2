@extends('layout')
@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('sales-order.index') }}">Purchase Order</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-3">
                        <small class="text-muted">Tanggal Order</small>
                        <div>{{ $salesOrder->order_date->format('d/m/Y')}}</div>
                    </div>
                    <div class="col-sm-3">
                        <small class="text-muted">Nama Konsumen</small>
                        <div>{{ $salesOrder->customer->name}}</div>
                    </div>
                    <div class="col-sm-3">
                        <small class="text-muted">Nomor Sales Order</small>
                        <div>{{ $salesOrder->no_sales_order }}</div>
                    </div>
                    <div class="col-sm-3">
                        <small class="text-muted">Nama Sales</small>
                        <div>{{ $salesOrder->sales->name }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">Data Purchase Order</div>
            <div class="card-body">
                @php
                    $grandTotal = 0;
                @endphp

                <div class="table-responsive">
                    <table class="table align-middle table-hover text-nowrap" id="datatable_sismark" style="width: 100%; font-size: 14px">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($salesOrder->sales_order_items as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $data->product->name }}</td>
                                    <td>{{ $data->qty }}</td>
                                    <td>{{ $data->product->unit }}</td>
                                    <td>{{ 'Rp ' . number_format($data->price, "2", ",", ".") }}</td>
                                    <td>
                                        @php
                                            $total = $data->qty * $data->price;
                                            $grandTotal += $total;
                                            echo 'Rp ' . number_format($total, "2", ",", ".");
                                        @endphp
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th colspan="5">Tax ({{ $salesOrder->tax->name ?? 'N/A' }})</th>
                                <th>
                                    @php
                                        if($salesOrder->tax == null) {
                                            $ppn = 0;
                                        } else {
                                            $ppn = $grandTotal * $salesOrder->tax->tax;
                                        }
                                    @endphp
                                    {{ 'Rp ' . number_format($ppn, "2", ",", ".") }}
                                </th>
                            </tr>
                            <tr>
                                <th colspan="5">Grand Total</th>
                                <th>
                                    {{ 'Rp ' . number_format($grandTotal + $ppn, "2", ",", ".") }}
                                </th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
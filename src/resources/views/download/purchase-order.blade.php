@extends('layout')

@section('content')
    <section>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Download Purchase Orders</li>
            </ol>
        </nav>

        <div class="card mb-3">
            <form action="" method="GET">
                {{-- @csrf
                @method('GET') --}}
                <div class="card-header">Form filter data</div>
                <div class="card-body">
                    <div class="alert alert-info py-2 mb-4">
                        <small>Filter data ini berdasarkan purchase order yang telah <strong>Approved</strong></small>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="sales" class="form-label">Sales</label>
                                <select name="sales" id="sales" class="form-select select-box">
                                    <option value="" selected>Pilih sales...</option>
                                    @foreach ($sales as $data)
                                        <option value="{{ $data->id }}" {{ request()->input('sales') == $data->id ? "selected" : "" }}>{{ $data->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="customer" class="form-label">Customer</label>
                                <select name="customer" id="customer" class="form-select select-box">
                                    <option value="" selected>Pilih customer...</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ request()->input('customer') == $customer->id ? "selected" : "" }}>{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dateMin" class="form-label">Tanggal awal</label>
                                <input type="date" class="form-control" name="dateMin" id="dateMin" title="Tanggal awal" value="{{ request()->input('dateMin') }}" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="dateMax" class="form-label">Tanggal akhir</label>
                                <input type="date" class="form-control" name="dateMax" id="dateMax" title="Tanggal akhir" value="{{ request()->input('dateMax') }}" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Filter data</button>
                    @if (request()->input('sales') || request()->input('customer') || request()->input('dateMin') || request()->input('dateMax'))
                        <a href="{{ route('download.purchase.order') }}" class="btn btn-secondary">Refresh</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">Data purchase order</div>
            <div class="card-body">
                @if ($results)
                    @if (count($results) > 0)
                        <form action="{{ route('export.purchase.order') }}" method="GET" target="__blank" >
                            <input type="hidden" name="sales" value="{{ request()->input('sales') }}">
                            <input type="hidden" name="customer" value="{{ request()->input('customer') }}">
                            <input type="hidden" name="dateMin" value="{{ request()->input('dateMin') }}">
                            <input type="hidden" name="dateMax" value="{{ request()->input('dateMax') }}">

                            <button class="btn btn btn-success" type="submit"><i class='bx bx-printer'></i>  Export Data</button>
                        </form>
                    @else
                        <div class="alert alert-warning">Data tidak ditemukan!</div>
                    @endif

                    <table class="table table-hover align-middle mt-3" style="width: 100%; font-size: 14px">
                        <thead>
                            <tr>
                                <th class="text-start">No</th>
                                <th class="text-start">PO</th>
                                <th>Date</th>
                                <th>Sales</th>
                                <th>Customer</th>
                                <th>Total Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $key => $result)
                                @php
                                    $totalInvoice = 0;
                                    foreach ($result['sales_order_items'] as $item) {
                                        $totalInvoice += $item->total_amount;
                                    }
                                    $ppn = $totalInvoice * $result->tax->tax;
                                    $grandTotal = $totalInvoice + $ppn;
                                @endphp
                                <tr>
                                    <td class="text-start bg-info bg-opacity-25">{{ $results->firstItem() + $key }}</td>
                                    <td class="text-start bg-info bg-opacity-25">{{ $result->no_sales_order }}</td>
                                    <td class="bg-info bg-opacity-25">{{ $result->order_date->format('d/m/Y') }}</td>
                                    <td class="bg-info bg-opacity-25">{{ $result->sales->name }}</td>
                                    <td class="bg-info bg-opacity-25">{{ $result->customer->name }}</td>
                                    <td class="bg-info bg-opacity-25">{{ 'Rp ' . number_format($grandTotal, "2", ",", ".") }}</td>
                                </tr>
                                <thead>
                                    <tr>
                                        <th colspan="6">List of item purchase order</th>
                                    </tr>
                                </thead>
                                @foreach ($result['sales_order_items'] as $item)
                                    <tr>
                                        <td colspan="3">{{ $item->product->name }} </td>
                                        <td>{{ number_format($item->qty, '0', ',', '.') . ' (' . $item->product->unit . ')' }}</td>
                                        <td>{{ 'Rp ' . number_format($item->price, "2", ",", ".") }}</td>
                                        <td>{{ 'Rp ' . number_format($item->total_amount, "2", ",", ".") }}</td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>

                    {{ $results->appends([
                        'sales' => request()->input('sales'),
                        'customer' => request()->input('customer'),
                        'dateMin' => request()->input('dateMin'),
                        'dateMax' => request()->input('dateMax'),
                        ])->links()
                    }}
                
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
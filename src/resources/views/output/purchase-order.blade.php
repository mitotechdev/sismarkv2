<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report Purchase Order</title>
    <link rel="stylesheet" href="{{ public_path('/css/purchase-order.css') }}">
    <style>
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="text-center">
        <strong>LAPORAN PURCHASE ORDER</strong>
    </div>
    <div style="margin-top: 70px; margin-bottom: 10px;">Date Print: {{ date('d/m/Y') }}</div>
    <table>
        <thead>
            <tr>
                <th class="text-start">No</th>
                <th class="text-start">PO</th>
                <th>Date</th>
                <th>Sales</th>
                <th>Customer</th>
                <th>Tax</th>
                <th>Total Tax</th>
                <th>Total Invoice</th>
            </tr>
        </thead>
        @foreach ($results as $key => $result)
        <tbody>
            @php
                $totalInvoice = 0;
                foreach ($result['sales_order_items'] as $item) {
                    $totalInvoice += $item->total_amount;
                }
                $ppn = $totalInvoice * $result->tax->tax;
                $grandTotal = $totalInvoice + $ppn;
            @endphp
            <tr>
                <td class="text-start bg-info bg-opacity-25">{{ $loop->iteration }}</td>
                <td class="text-start bg-info bg-opacity-25">{{ $result->no_sales_order }}</td>
                <td class="bg-info bg-opacity-25">{{ $result->order_date->format('d/m/Y') }}</td>
                <td class="bg-info bg-opacity-25">{{ $result->sales->name }}</td>
                <td class="bg-info bg-opacity-25">{{ $result->customer->name }}</td>
                <td class="bg-info bg-opacity-25">{{ $result->tax->name }}</td>
                <td class="bg-info bg-opacity-25">{{ 'Rp ' . number_format($ppn, 2, ',', '.') }}</td>
                <td class="bg-info bg-opacity-25">{{ 'Rp ' . number_format($grandTotal, 2, ',', '.') }}</td>
            </tr>
            
            {{-- Header for item list --}}
            <tr>
                <th colspan="8">List of item purchase order</th>
            </tr>

            {{-- Loop through the items --}}
            @foreach ($result['sales_order_items'] as $item)
                <tr>
                    <td colspan="5">{{ $item->product->name }}</td>
                    <td>{{ number_format($item->qty, 0, ',', '.') . ' (' . $item->product->unit . ')' }}</td>
                    <td>{{ 'Rp ' . number_format($item->price, 2, ',', '.') }}</td>
                    <td>{{ 'Rp ' . number_format($item->total_amount, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        @endforeach
    </table>
</body>
</html>
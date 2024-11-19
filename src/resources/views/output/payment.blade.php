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
        <strong>LAPORAN REKAP PEMBAYARAN PO</strong>
    </div>
    <div style="margin-top: 70px; margin-bottom: 10px;">Date Print: {{ date('d/m/Y') }}</div>
    <table>
        <thead>
            <tr>
                <th class="text-start" style="width: 20px">No</th>
                <th class="text-start">PO</th>
                <th>Date</th>
                <th>Sales</th>
                <th>Customer</th>
                <th>Total PO</th>
                <th>Outstanding</th>
                <th>Belum Invoice</th>
                <th>Total Lunas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $key => $data)
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
                    <td style="width: 40px" class="bg-info">{{ $results->firstItem() + $key }}</td>
                    <td class="bg-info">{{ $data->no_sales_order }}</td>
                    <td class="bg-info">{{ $data->order_date->format('d/m/Y') }}</td>
                    <td class="bg-info">{{ $data->sales->name }}</td>
                    <td class="bg-info">{{ $data->customer->name }}</td>
                    <td class="bg-info">{{ 'Rp '. number_format($grandTotal, 2, ',', '.'); }}</td>
                    <td class="bg-info">{{ 'Rp '. number_format($totalOutstanding, 2, ',', '.') }}</td>
                    <td class="bg-info">{{ 'Rp '. number_format($totalUninvoiced, 2, ',', '.') }}</td>
                    <td class="bg-info">{{ 'Rp '. number_format($totalInvoicePaid, 2, ',', '.') }}</td>
                </tr>

                @if ($data->recap_invoice->count() > 0)
                <tr>
                    <td colspan="9">List of payments</td>
                </tr>
                <tr>
                    <td colspan="4">No Invoice</td>
                    <td>Terbit Invoice</td>
                    <td>Jatuh Tempo</td>
                    <td>Tanggal Bayar</td>
                    <td>Lama Bayar</td>
                    <td>Jumlah Bayar</td>
                </tr>
                @foreach ($data['recap_invoice'] as $item)
                    <tr>
                        <td colspan="4">{{ $item->no_invoice }}</td>
                        <td>{{ $item->date_invoice->format('d/m/Y') }}</td>
                        {{-- <td>{{ $item->due_date->format('d/m/Y') }}</td> --}}
                        <td>
                            @if ($item->date_payment == null)
                                @if ($item->due_date->lt(now()))
                                    {{ $item->due_date->format('d/m/Y') }} <span style="color: red">{{ ' (- ' . $item->due_date->diffInDays(now()) . ' hari)' }}</span>
                                @else
                                    {{ $item->due_date->format('d/m/Y') }} <span style="color: green">{{ ' (+' . $item->due_date->diffInDays(now()) . ' hari lagi)' }}</span>
                                @endif
                            @else
                            {{ $item->due_date->format('d/m/Y') }}
                            @endif
                        </td>
                        <td>{{ $item->date_payment == null ? 'Belum bayar' : $item->date_payment->format('d/m/Y') }}</td>
                        <td>
                            @if ($item->date_payment == null)
                                Belum bayar
                            @else
                                {{ $item->date_payment->diffInDays($item->due_date) . ' Hari'}}
                            @endif
                        </td>
                        <td>{{ 'Rp ' . number_format($item->total_payment, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
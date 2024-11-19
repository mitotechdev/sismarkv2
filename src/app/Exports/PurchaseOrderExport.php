<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchaseOrderExport extends CustomValueBinder implements FromCollection,
    WithCustomValueBinder,
    WithColumnWidths,
    WithHeadings,
    ShouldAutoSize,
    WithTitle,
    WithStyles
{

    protected $salesOrders;

    public function __construct(Collection $salesOrders)
    {
        $this->salesOrders = $salesOrders;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,  // Tanggal Order
            'B' => 20,  // Sales
            'C' => 25,  // No PO
            'D' => 25,  // Customer
            'E' => 15,  // Pajak
            'F' => 25,  // Total PPN
            'G' => 25,  // Total PO
            'H' => 25,  // Total Outstanding
            'I' => 25,  // Total Belum Invoice
            'J' => 25,  // Total Pembayaran
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal Order',
            'Sales',
            'No PO',
            'Customer',
            'Pajak',
            'Total Pajak',
            'Total PO',
            'Outstanding',
            'Belum Invoice',
            'Total Pembayaran'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Membuat baris pertama (header) menjadi tebal
        ];
    }

    public function title(): string
    {
        return 'PO';
    }
    
    public function collection()
    {
        return $this->salesOrders->map(function ($data) {
            $totalPo = 0;
            foreach ($data->sales_order_items as $item) {
                $totalPo += $item->qty * $item->price;
            }
            $ppn = $totalPo * $data->tax->tax;
            $grandTotalAfterTax = $totalPo + $ppn;

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
            $totalUninvoiced = max(0, $grandTotalAfterTax - ($totalInvoicePaid + $totalInvoiceUnpaid));

            if ($grandTotalAfterTax >= $sumTotalUnpaidAndPaid) {
                if ($totalInvoiceUnpaid >= $totalInvoicePaid) {
                    $totalOutstanding = $totalInvoiceUnpaid;
                } else {
                    $totalOutstanding = $totalInvoiceUnpaid;
                }
            }

            return [
                'order_date' => $data->order_date->format('d/m/Y'),
                'sales' => $data->sales->name,
                'no_sales_order' => $data->no_sales_order,
                'customer_name' => $data->customer->name,
                'category_ppn' => $data->tax->name,
                'ppn' => $ppn,
                'total_po' => $grandTotalAfterTax,
                'outstanding' => $totalOutstanding,
                'belum_invoice' => $totalUninvoiced,
                'total_pembayaran' => $totalInvoicePaid,
            ];
        });
    }
}

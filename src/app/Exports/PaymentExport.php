<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentExport extends CustomValueBinder implements FromCollection,
        WithCustomValueBinder,
        WithHeadings,
        WithColumnWidths,
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
            'D' => 30,  // Customer
            'E' => 20,  // No Invoice
            'F' => 15,  // Terbit Invoice
            'G' => 15,  // Jatuh Tempo
            'H' => 15,  // Tanggal Bayar
            'I' => 25,  // Grand Total
        ];
    }
    public function headings(): array
    {
        return [
            'Tanggal Order',
            'Sales',
            'No PO',
            'Customer',
            'No Invoice',
            'Terbit Invoice',
            'Tanggal Bayar',
            'Jatuh Tempo',
            'Total Bayar',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function collection()
    {

        // dd($this->salesOrders);
        return $this->salesOrders->map(function ($data) {
            $totalPo = 0;
            foreach ($data->sales_order_items as $item) {
                $subTotal = $item->qty * $item->price;
                $totalPo += $subTotal;
            }

            $ppn = $totalPo * $data->tax->tax;
            $grandTotal = $totalPo + $ppn;

            // Kalkulasi Grand Total di level Sales Order
            return $data->recap_invoice->map(function ($invoice) use ($data, $grandTotal) {
                $totalPaid = $invoice->total_payment;

                // Return data per recap_invoice
                return [
                    'order_date' => $data->order_date->format('d/m/Y'),
                    'sales' => $data->sales->name,
                    'no_sales_order' => $data->no_sales_order,
                    'customer_name' => $data->customer->name,
                    'no_invoice' => $invoice->no_invoice,
                    'date_invoice' => $invoice->date_invoice->format('d/m/Y'),
                    'due_date' => $invoice->due_date->format('d/m/Y'),
                    'date_payment' => $invoice->date_payment ? $invoice->date_payment->format('d/m/Y') : 'BELUM BAYAR',
                    'total_paid' => $totalPaid,
                ];
            });
        });
    }
    public function title(): string
    {
        return 'Recap Payment';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Membuat baris pertama (header) menjadi tebal
        ];
    }
}

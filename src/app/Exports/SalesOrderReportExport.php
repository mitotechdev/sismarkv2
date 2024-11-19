<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class SalesOrderReportExport extends CustomValueBinder implements WithMultipleSheets, WithCustomValueBinder
{
    use Exportable;

    protected $salesOrders;

    public function __construct(Collection $salesOrders)
    {
        $this->salesOrders = $salesOrders;
    }

    public function sheets(): array
    {
        return [
            'PO' => new PurchaseOrderExport($this->salesOrders),
            'Payment' => new PaymentExport($this->salesOrders),
        ];
    }
}

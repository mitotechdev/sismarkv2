<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\ProgressWorkplan;
use Illuminate\Support\Facades\Auth;
use App\Charts\StatsSegmenPerSalesChart;
use Yajra\DataTables\Facades\DataTables;
use App\Charts\StatsProspectPerSalesChart;
use App\Charts\TopSellingProductBySalesChart;

class ReportController extends Controller
{

    public function reportRecapProgress()
    {
        $metadata = [
            'title' => 'Recap progress',
            'description' => 'Reports',
            'submenu' => 'recap-progress',
        ];

        $progress = ProgressWorkplan::with('sales', 'market_progress', 'workplan')
                    ->whereHas('workplan', function($data) {
                        return $data->where('branch_id', Auth::user()->branch_id);
                    })
                   ->latest()->get();

        if( request()->ajax() ) {
            return DataTables::of($progress)
                ->addIndexColumn()
                ->addColumn('sales', function($data) {
                    return $data->sales->name;
                })
                ->addColumn('date_progress', function($data) {
                    return $data->date_progress->format('d/m/Y');
                })
                ->addColumn('market_progress', function($data) {
                    return $data->market_progress->name;
                })
                ->addColumn('status_progress', function($data) {
                    return $data->market_progress->status;
                })
                ->addColumn('customer_name', function($data) {
                    return $data->workplan->customer->name;
                })
                ->make();
        }
        return view('pages.report.report-recap-progress', compact('progress', 'metadata'));
    }

    public function reportPurchaseOrder()
    {
        $metadata = [
            'title' => 'Report Purchase Order',
            'description' => 'Reports',
            'submenu' => 'report-purchase-order',
        ];

        $salesOrders = SalesOrder::with('customer', 'approval', 'tax', 'recap_invoice')
                                   ->where('branch_id', Auth::user()->branch_id)
                                   ->where('approval_id', 3)
                                   ->latest()
                                   ->get();
        if ( request()->ajax() ) {
            return DataTables::of($salesOrders)
                ->addIndexColumn()
                ->addColumn('tanggal_order', function($data) {
                    return $data->order_date->format('d/m/Y');
                })
                ->addColumn('sales', function($data) {
                    return $data->sales->name;
                })
                ->addColumn('konsumen', function($data) {
                    return $data->customer->name;
                })
                ->addColumn('segmen', function($data) {
                    return $data->segmen->name;
                })
                ->addColumn('total_po', function($data) {
                    $totalPo = 0;
                    foreach ($data->sales_order_items as $item) {
                        $subTotal = $item->qty * $item->price;
                        $totalPo += $subTotal;
                    }
                    $ppn = $totalPo * $data->tax->tax;
                    $grandTotal = $totalPo + $ppn;
                    return 'Rp '. number_format($grandTotal, 2, ',', '.');
                })
                ->addColumn('outstanding_balance', function($data) {
                    // Hitung Total PO keseluruhan items
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

                    if ($grandTotal >= $sumTotalUnpaidAndPaid) {
                        if ($totalInvoiceUnpaid >= $totalInvoicePaid) {
                            $totalOutstanding = $totalInvoiceUnpaid;
                        } else {
                            $totalOutstanding = $totalInvoiceUnpaid;
                        }
                    }

                    return 'Rp '. number_format($totalOutstanding, 2, ',', '.');
                    
                })
                ->addColumn('uninvoiced', function($data) {
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

                    $totalUninvoiced = max(0, $grandTotal - ($totalInvoicePaid + $totalInvoiceUnpaid));

                    return 'Rp '. number_format($totalUninvoiced, 2, ',', '.');
                })
                ->addColumn('paid_amount', function($data) {
                    $totalPaid = 0;
                    foreach ($data->recap_invoice as $item) {
                        if($item->date_payment != null) {
                            $totalPaid += $item->total_payment;
                        }
                    }
                    return $totalPaid;
                })
                ->make();
        }
        return view('pages.recap.purchase-order', compact('metadata'));
    }

    public function reportSalesOrder()
    {
        $metadata = [
            'title' => 'List Purchase Order',
            'description' => 'Reports',
            'submenu' => 'list-purchase-order',
        ];

        $salesOrderItems = SalesOrderItem::with('product', 'sales_order')
                    ->whereHas('sales_order', function($query) {
                        $query->where('approval_id', 3)
                              ->where('branch_id', Auth::user()->branch_id);
                    })
                    ->latest()
                    ->get();

        if( request()->ajax() ) {
            return DataTables::of($salesOrderItems)
                ->addIndexColumn()
                ->addColumn('code', function($data) {
                    return $data->sales_order->code;
                })
                ->addColumn('sales', function($data) {
                    return $data->sales_order->sales->name;
                })
                ->addColumn('konsumen', function($data) {
                    return $data->sales_order->customer->name;
                })
                ->addColumn('segmen', function($data) {
                    return $data->sales_order->customer->category_customer->name;
                })
                ->addColumn('product', function($data) {
                    return $data->product->name;
                })
                ->addColumn('qty', function($data) {
                    return number_format($data->qty, '0', ',', '.') . ' '. $data->product->unit;
                })
                ->addColumn('price', function($data) {
                    return 'Rp ' . number_format($data->price, '0', ',', '.');
                })
                ->addColumn('sum_price', function($data) {
                    return 'Rp ' . number_format($data->price*$data->qty, '0', ',', '.');
                })
                ->make();
        }
        return view('pages.report.report-sales-order', compact('metadata'));
    }

    // public function reportSales()
    // {
    //     $data = SalesOrder::has('sales')->where('branch_id', Auth::user()->branch_id)->get()->groupBy('sales_id')->keys(); //ambil [id sales] dari sales order
    //     $sales = User::whereIn('id', $data)->get();
        
    //     return view('pages.report.report-sales', [
    //         'sales' => $sales,
    //     ]);
    // }

    // public function reportSalesDetail(User $user)
    // {
    //     $chartStatsProspectSales = app(StatsProspectPerSalesChart::class)->build($user->id);
    //     $chartTopSellingProductBySales = app(TopSellingProductBySalesChart::class)->build($user->id);
    //     $chartStatsSegmenPerSales = app(StatsSegmenPerSalesChart::class)->build($user->id);
    //     return view('pages.report.report-sales-detail', [
    //         'user' => $user,
    //         'chartStatsProspectSales' => $chartStatsProspectSales,
    //         'chartTopSellingProductBySales' => $chartTopSellingProductBySales,
    //         'chartStatsSegmenPerSales' => $chartStatsSegmenPerSales,
    //     ]);
    // }
}

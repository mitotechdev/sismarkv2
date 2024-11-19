<?php

namespace App\Http\Controllers;

use App\Models\RecapInvoice;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecapInvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-recap-invoice', ['only' => ['store']]);
        $this->middleware('permission:read-recap-invoice', ['only' => ['index']]);
        $this->middleware('permission:edit-recap-invoice', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-recap-invoice', ['only' => ['destroy']]);
    }
    public function index()
    {
        $metadata = [
            'title' => 'Recap Invoice',
            'description' => 'Sales',
            'submenu' => 'recap-invoice',
        ];

        $salesOrders = SalesOrder::with('sales_order_items')->where('branch_id', Auth::user()->branch_id)->get();
        $salesOrdersWithSisaBayar = $salesOrders->filter(function ($salesOrder) {
            // Hitung totalInvoice
            $totalInvoice = 0;
            foreach ($salesOrder->sales_order_items as $item) {
                $totalInvoice += $item->total_amount;
            }
    
            // Hitung PPN dan grandTotal
            $ppn = $totalInvoice * ($salesOrder->tax->tax ?? 0); // Pastikan tax ada, jika tidak set 0
            $grandTotal = $totalInvoice + $ppn;
    
            // Hitung total pembayaran yang sudah dilakukan dari recap_invoice
            $totalDonePayment = 0;
            foreach ($salesOrder->recap_invoice as $invoice) {
                $totalDonePayment += $invoice->total_payment;
            }
    
            // Kembalikan true jika masih ada sisa bayar, sebaliknya false
            return $grandTotal > $totalDonePayment;
        });
        $recapInvoices = RecapInvoice::with('customer', 'sales_order')
                        ->where('branch_id', Auth::user()->branch_id)
                        ->latest()
                        ->get();
        if( request()->ajax() ) {
            return datatables()->of($recapInvoices)
                ->addIndexColumn()
                ->addColumn('order_date', function($data) {
                    return $data->sales_order->order_date->format('d/m/Y');
                })
                ->addColumn('sales', function($data) {
                    return $data->sales_order->sales->name;
                })
                ->addColumn('no_sales_order', function($data) {
                    return $data->sales_order->no_sales_order;
                })
                ->addColumn('customer', function($data) {
                    return $data->customer->name;
                })
                ->addColumn('date_invoice', function($data) {
                    return $data->date_invoice->format('d/m/Y');
                })
                ->addColumn('due_date', function($data) {
                    return $data->due_date->format('d/m/Y');
                })
                ->addColumn('total_payment', function($data) {
                    return 'Rp '. number_format($data->total_payment, 2, ',', '.');
                })
                ->addColumn('aksi', function($data) {
                    return view('components.action-recap-invoice', compact('data'));
                })
                ->rawColumns(['aksi'])
                ->make();
        }
        return view('pages.recap-invoice.recap-invoice', compact('salesOrdersWithSisaBayar', 'metadata'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_purchase_order' => 'required',
            'no_invoice' => 'required',
            'date_invoice' => 'required',
            'deadline_invoice' => 'required',
            'total_payment' => 'required',
        ]);

        $data = [
            'sales_order_id' => $request->no_purchase_order,
            'customer_id' => $request->name_customer,
            'no_invoice' => $request->no_invoice,
            'date_invoice' => $request->date_invoice,
            'due_date' => $request->deadline_invoice,
            'total_payment' => $request->total_payment,
            'status' => 1, // 1 = unpaid (terbit invoice tapi belum diverifikasi oleh user admin artinya belum dibayar)
            'branch_id'=> Auth::user()->branch_id,
        ];

        if($request->date_payment) {
            $data['date_payment'] = $request->date_payment;
        }

        RecapInvoice::create($data);
        return redirect()->back()->with("success", "Data rekap invoice terbaru telah ditambahkan!");
    }

    public function edit(RecapInvoice $recapInvoice)
    {
        $metadata = [
            'title' => 'Edit Recap Invoice',
            'description' => 'Sales',
            'submenu' => 'recap-invoice',
        ];

        if(auth()->user()->branch_id == $recapInvoice->branch_id) {
            return view('pages.recap-invoice.recap-invoice-edit', compact('recapInvoice', 'metadata'));
        } else {
            abort(403);
        }
    }

    public function update(Request $request, RecapInvoice $recapInvoice)
    {
        $salesOrders = SalesOrder::with('sales_order_items', 'recap_invoice')
                                  ->where('branch_id', Auth::user()->branch_id)
                                  ->find($recapInvoice->sales_order_id);
        $totalInvoice = 0;
        foreach ($salesOrders->sales_order_items as $item) {
            $totalInvoice += $item->total_amount;
        }

        // Hitung PPN dan grandTotal
        $ppn = $totalInvoice * ($salesOrders->tax->tax ?? 0); // Pastikan tax ada, jika tidak set 0
        $grandTotal = $totalInvoice + $ppn;

        $totalDonePayment = 0;
        foreach ($salesOrders->recap_invoice->except($recapInvoice->id) as $invoice) {
            $totalDonePayment += $invoice->total_payment;
        }

        

        if($grandTotal < ($request->total_payment+$totalDonePayment)) {
            return redirect()->route('recap-invoice.index')->with('error', 'Total pembayaran tidak boleh melebihi total tagihan!');
        }

        $request->validate([
            'no_invoice' => 'required',
            'date_invoice' => 'required|date',
            'due_date' => 'required|date',
            'total_payment' => 'required',
        ]);

        $data = [
            'no_invoice' => $request->no_invoice,
            'date_invoice' => $request->date_invoice,
            'due_date' => $request->due_date,
            'total_payment' => $request->total_payment
        ];

        if($request->date_payment) {
            $data['date_payment'] = $request->date_payment;
        }

        $recapInvoice->update($data);

        return redirect()->route('recap-invoice.index')->with('success', 'Data berhasil perbaharui!');
    }

    public function destroy(RecapInvoice $recapInvoice)
    {
        $recapInvoice->delete();
        return redirect()->back()->with('success', 'Data recap invoice berhasil dihapus!');
    }

    
}

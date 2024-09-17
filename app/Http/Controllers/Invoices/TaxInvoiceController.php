<?php

namespace App\Http\Controllers\invoices;

use App\Http\Controllers\Controller;
use App\Models\Projects;
use App\Models\Rider;
use Illuminate\Http\Request;

class TaxInvoiceController extends Controller
{
    public function index(Request $request)
    {

        if ($request->isMethod('post')) {

            $result = Rider::selectRaw('sum(rider_invoice_items.qty) as quantity,items.item_name as item_name,SUM(rider_invoice_items.amount) as item_amount,
            rider_invoices.billing_month as b_month,items.pirce as item_price')
                ->where('PID', $request->PID)->where('billing_month', $request->billing_month . "-01")
                ->join('rider_invoices', 'riders.id', '=', 'rider_invoices.RID')
                ->join('rider_invoice_items', 'rider_invoice_items.inv_id', '=', 'rider_invoices.id')
                ->join('items', 'rider_invoice_items.item_id', '=', 'items.id')
                ->groupBy('rider_invoice_items.item_id')->get();
            $billing_month = $request->billing_month . "-01";
            $project = Projects::find($request->PID);
            return view('invoices.tax_invoice.show', compact('result', 'billing_month', 'project'));
        }

        return view('invoices.tax_invoice.index');
    }
}

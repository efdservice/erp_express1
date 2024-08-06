<?php

namespace App\Http\Controllers;

use App\Models\Rider;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function rider_invoice_index()
    {
        return view('Reports.rider');
    }
    public function vendor_invoice_index()
    {
        return view('Reports.vendor');
    }
    public function rider_list()
    {
        $riders = Rider::all();
        return view('Reports.rider_list', compact('riders'));
    }
}

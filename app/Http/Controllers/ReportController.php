<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function rider_invoice_index(){
        return view('Reports.rider');
    }
    public function vendor_invoice_index(){
        return view('Reports.vendor');
    }
}

<?php

namespace App\Http\Controllers\Invoices;

use App\Helpers\Account;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Imports\ImportRiderInvoice;
use App\Models\Accounts\Transaction;
use App\Models\Accounts\TransactionAccount;
use App\Models\AssignVendorRider;
use App\Models\Item;
use App\Models\Rider;
use App\Models\RiderInvoice;
use App\Models\RiderInvoiceItem;
use App\Models\RiderItemPrice;
use App\Models\VendorInvoiceItem;
use App\Models\VendorItemPrice;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class RiderInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:invoices_view', ['only', ['index']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = RiderInvoice::query()->with(['rider'])->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = $btn . ' ';
                    $btn = $btn . '<div class="dropdown">';
                    $btn = $btn . '
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Action
                      </button>';
                    $btn = $btn . '
                      <div class="dropdown-menu">';
                    if (\Auth::user()->can('invoices_edit')) {
                        $btn = $btn . '
                        <a href="#" data-toggle="tooltip" data-action="' . route('rider_invoices.edit', $row->id) . '" class="edit editRiderInvRec dropdown-item" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>';
                    }
                    if (\Auth::user()->can('invoices_delete')) {
                        $btn = $btn . '
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-action="' . route('rider_invoices.store') . '/' . $row->id . '" data-original-title="Delete" class=" deleteRecord dropdown-item"><i class="fas fa-trash"></i> Del</a>';
                    }

                    $btn = $btn . '
                        <div class="dropdown-divider"></div>
                        <a href="' . route('rider_invoices.show', $row->id) . '" target="_blank" class="dropdown-item"><i class="fas fa-eye"></i> Rider Invoice</a>
                        
                      </div>
                    </div>';
                    /* <div class="dropdown-divider"></div>
                        <a href="'.route('vendor_invoices.show',$row->id).'" target="_blank"  class="dropdown-item"><i class="fas fa-eye"></i> Vendor Invoice</a>
                       */
                    return $btn;
                })->addColumn('rider_name', function ($row) {
                    return $row->rider->rider_id . '-' . $row->rider->name;
                    /* })->addColumn('vendor_total', function($row){
                        return VendorInvoiceItem::where('inv_id',$row->id)->sum('amount'); */
                })->addColumn('total_qty', function ($row) {
                    return RiderInvoiceItem::where('inv_id', $row->id)->sum('qty');
                })->addColumn('inv_no', function ($row) {
                    return CommonHelper::inv_sch($row->id, $row->created_at);
                })
                ->rawColumns(['action', 'total_qty', 'inv_no'])
                ->make(true);

        }
        return view('invoices.rider_invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'inv_date' => 'required',
            'RID' => 'required|numeric|min:0|not_in:0',
            'total_amount' => 'required|numeric|min:0|not_in:0',
        ];
        $message = [
            'inv_date.required' => 'Invoice Date Required',
            'RID.required' => 'Please select Rider ',
            'total_amount.required' => 'Sub Total Should be greateer than 0',
        ];
        $this->validate($request, $rules, $message);
        DB::beginTransaction();
        $data = $request->except(['_token', 'item_id', 'qty', 'rate', 'discount', 'tax', 'amount', 'month_invoice']);
        $id = $request->id;
        $count = count($request->qty);
        try {
            //add vendor invoice item
            //$VID=AssignVendorRider::where('RID',$request->RID)->value('VID');
            $VID = Rider::where('id', $request->RID)->value('VID');
            $data['VID'] = $VID;
            if ($id == 0 || $id == '') {
                $inv = RiderInvoice::create($data);
                $arra = [];
                //$vArray=[];
                for ($i = 0; $i < $count; $i++) {
                    $arra[] = [
                        'item_id' => $request['item_id'][$i],
                        'qty' => $request['qty'][$i],
                        'rate' => $request['rate'][$i],
                        'discount' => $request['discount'][$i],
                        'tax' => $request['tax'][$i],
                        'amount' => $request['amount'][$i],
                        'inv_id' => $inv->id,
                    ];
                    /* $vArray[]=[
                        'item_id' => $request['item_id'][$i],
                        'qty' => $request['qty'][$i],
                        'rate' => CommonHelper::vendorItemPrice($VID,$request['item_id'][$i]),
                        'discount' => $request['discount'][$i],
                        'tax' => $request['tax'][$i],
                        'amount' => (CommonHelper::vendorItemPrice($VID,$request['item_id'][$i]))*($request['qty'][$i]),
                        'inv_id' => $inv->id,
                    ]; */
                }
                RiderInvoiceItem::insert($arra);
                //VendorInvoiceItem::insert($vArray);
            } else {
                RiderInvoiceItem::where('inv_id', $id)->delete();
                //VendorInvoiceItem::where('inv_id',$id)->delete();
                RiderInvoice::where('id', $id)->update($data);
                $arra = [];
                //$vArray=[];
                for ($i = 0; $i < $count; $i++) {
                    if (!empty($request['item_id'][$i])) {
                        $arra[] = [
                            'item_id' => $request['item_id'][$i],
                            'qty' => $request['qty'][$i],
                            'rate' => $request['rate'][$i],
                            'discount' => $request['discount'][$i],
                            'tax' => $request['tax'][$i],
                            'amount' => $request['amount'][$i],
                            'inv_id' => $id,
                        ];
                        //add vendor invoice item
                        //$VID=AssignVendorRider::where('RID',$request->RID)->value('VID');
                        /*  $VID = Rider::where('id',$request->RID)->value('VID');
                         $vArray[]=[
                             'item_id' => $request['item_id'][$i],
                             'qty' => $request['qty'][$i],
                             'rate' => CommonHelper::vendorItemPrice($VID,$request['item_id'][$i]),
                             'discount' => $request['discount'][$i],
                             'tax' => $request['tax'][$i],
                             'amount' => (CommonHelper::vendorItemPrice($VID,$request['item_id'][$i]))*($request['qty'][$i]),
                             'inv_id' => $id,
                         ]; */
                    }
                }
                RiderInvoiceItem::insert($arra);
                //VendorInvoiceItem::insert($vArray);
            }
            //accounts entries
            if ($id == 0 || $id == '') {
                $invID = $inv->id;
            } else {
                Transaction::where('vt', 4)->where('SID', $id)->delete();
                $invID = $id;
            }
            $rider_amount = RiderInvoiceItem::where('inv_id', $invID)->sum('amount');
            //$vendor_amount=VendorInvoiceItem::where('inv_id',$invID)->sum('amount');
            //$profit=$vendor_amount-$rider_amount;
            $tData['trans_acc_id'] = TransactionAccount::where(['PID' => 21, 'Parent_Type' => $request->RID])->value('id');
            $tData['vt'] = 4;
            $tData['amount'] = $rider_amount;
            $tData['narration'] = 'Rider Invoice Against #' . $invID . ' - ' . $request->descriptions;
            $tData['status'] = 1;
            $tData['SID'] = $invID;
            $tData['created_by'] = Auth::user()->id;
            $tData['dr_cr'] = 2;
            $tData['trans_code'] = Account::trans_code();
            $tData['trans_date'] = $request->inv_date;
            $tData['billing_month'] = $request->billing_month;
            $tData['posting_date'] = $request->inv_date;
            Transaction::create($tData);
            //cr to vendor
            /* $tData['trans_acc_id']=TransactionAccount::where(['PID'=>9,'Parent_Type'=>$VID])->value('id');
            $tData['amount']=$profit;
            Transaction::create($data); */
            DB::commit();
            return response()->json(['message' => 'Operation Successfull']);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $res = RiderInvoice::with(['riderInv_item'])->where('id', $id)->get();
        //        dd($res);
        return view('invoices.rider_invoices.show', compact('res'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result = RiderInvoice::find($id);
        $items = RiderInvoiceItem::where('inv_id', $id)->get();
        $html = '';
        $i = 0;
        foreach ($items as $item) {
            $html .= '<div class="row item">
                    <div class="col-md-3 form-group">
                        <label>Item Description</label>
                        <select class="form-control form-control-sm select2" onchange="search_price(this)" name="item_id[]">
                            <option value="">--Select--</option>
                            ' . Item::dropdown($item->item_id) . '
                        </select>
                    </div>
                    <!--col-->';
            $html .= '<div class="col-md-1 form-group">
                                <label>Qty</label>
                                <input type="text" class="form-control form-control-sm qty" name="qty[]" placeholder="0" value="' . $item->qty . '">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Rate</label>
                                <input type="text" class="form-control form-control-sm rate" name="rate[]" placeholder="0" value="' . $item->rate . '">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Discount</label>
                                <input type="text" class="form-control form-control-sm discount" name="discount[]" placeholder="0" value="' . $item->disount . '">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Tax</label>
                                <input type="text" class="form-control form-control-sm tax" name="tax[]" placeholder="0" value="' . $item->tax . '">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label>Amount</label>
                                <input type="text" class="form-control form-control-sm amount" name="amount[]" placeholder="0" value="' . $item->amount . '">
                            </div>
                            <!--col-->
                            <div class="col-md-1 form-group">
                                <label style="visibility: hidden">Assign Price</label>
                                <button type="button" class="btn btn-sm ' . ($i != 0 ? 'btn-danger remove' : 'btn-primary new_line') . '"><i class="fa fa-plus"></i> </button>
                            </div>
                            <!--col-->
                            ';
            $html .= '</div>';
            $i++;
        }
        return compact('result', 'html');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Transaction::where('vt', 4)->where('SID', $id)->delete();
        return RiderInvoice::destroy($id);
    }

    /*
     * import excel file
     */
    public function import_excel(Request $request)
    {
        $rules = [
            'file' => 'required|max:50000|mimes:xlsx'
        ];
        $message = [
            'file.required' => 'Excel File Required'
        ];
        $this->validate($request, $rules, $message);
        Excel::import(new ImportRiderInvoice(), $request->file('file'));
    }
}

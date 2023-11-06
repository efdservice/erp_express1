<?php

namespace App\Http\Controllers;

use App\Models\AssignVendorRider;
use App\Models\Item;
use App\Models\Rider;
use App\Models\RiderInvoiceItem;
use App\Models\RiderItemPrice;
use App\Models\Vendor;
use App\Models\VendorItemPrice;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     function __construct(){
       /*  $this->middleware('permission:role_create', ['only' => ['create','store']]);
        $this->middleware('permission:role_edit', ['only' => ['edit','update']]);
        $this->middleware('permission:role_delete', ['only' => ['destroy']]); */
        $this->middleware('permission:items_view', ['only' => ['index']]); 
        

     }
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=Item::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '';
                    if(\Auth::user()->can('items_edit')){
                        $btn = $btn.'<a href="#" data-toggle="tooltip" data-action="'.route('item.edit',$row->id).'" class="edit btn btn-primary btn-xs editItem" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>';

                    }
                    if(\Auth::user()->can('items_edit')){
                    $btn = $btn.' <a data-item="clone" href="#" data-toggle="tooltip" data-action="'.route('item.edit',$row->id).'" class="edit btn btn-success btn-xs editItem" data-modalID="modal-new"><i class="fas fa-copy"></i> Clone</a>';
                    }
                    if(\Auth::user()->can('items_delete')){
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-action="'.route('item.store').'/'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-xs deleteRecord"><i class="fas fa-trash"></i> Del</a>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return  view('items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=[
            'item_name'=>'required',
            'sale_price'=>'required',
            'cost_price'=>'required',
        ];
        $message=[
            'item_name.required'=>'Item Name Required',
            'sale_price.required'=>'Sale Price Required',
            'cost_price.required'=>'Cost Price Required',
        ];
        $this->validate($request,$rules,$message);
        $data=$request->except(['RID','price','VID','vendor_price','sale_price']);
        $data['pirce']=$request->sale_price;
        $id=$request->input('id');
        DB::beginTransaction();
        try {
            if($id==0 || $id==''){
                $ret=Item::create($data);
//                        $existItem=VendorItemPrice::where('item_id',$ret->id)->where('VID',$request['VID'][$i])->where('RID',$request['RID'][$i])->first();
//                        if(!$existItem) {
//                            $item['item_id'] = $ret->id;
//                            $item['RID'] = $request['RID'][$i];
//                            $item['price'] = $request['price'][$i];
//                            $retR = RiderItemPrice::create($item);
//                            $vitem['item_id'] = $ret->id;
//                            $vitem['VID'] = $request['VID'][$i];
//                            $vitem['price'] = $request['vendor_price'][$i];
//                            $vitem['RID'] = $retR->id;
//                            VendorItemPrice::create($vitem);
//                        }
            }else{
                $ret=Item::where('id',$id)->update($data);
            }
            DB::commit();
            return $ret;
        }catch (QueryException $e){
            DB::rollback();
//            if($e->getCode()==23000){
//                return response()->json([
//                    'success' => 'false',
//                    'errors'  => 'You are trying to Enter Duplicate Rider with this item',
//                ], 400);
//            }else{
//                return response()->json([
//                    'success' => 'false',
//                    'errors'  => $e->getMessage(),
//                ], 400);
//            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$item_id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $result=Item::find($id);

        return compact('result');
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
        return Item::destroy($id);
    }
    /*
     * search item price
     */
    public function search_item_price($RID, $item_id){
        $result=RiderItemPrice::where('item_id',$item_id)->where('RID',$RID)->first();
        if($result && $result->price>0){
            return $result;
        }else{
            $result=Item::where('id',$item_id)->first();
            return $result;
        }
    }
    /*
     * feth vendor against rider id
     */
    public function fetch_rider(Request $request){
        $id=$request->id;
        $res=AssignVendorRider::where('VID',$id)->get();
        $html='';
        $i=0;
        foreach ($res as $item){
            $html.='
            <div class="row item_line_one">
                <div class="col-md-3 form-group">
                    '.($i==0?'<label>Rider</label>':'').'
                    <select class="form-control form-control-sm select2 selected_riders" onchange="fetch_vendor(this)" name="RID[]">
                        <option value="">Select Rider</option>
                        '.Rider::dropdown($item->RID).'
                    </select>
                </div>
                <!--col-->
                <div class="col-md-2 form-group">
                    '.($i==0?'<label>Rider Price</label>':'').'
                    <input type="text" class="form-control form-control-sm sp" name="price[]" placeholder="Assign Price">
                </div>
                <!--col-->
                <div class="col-md-2 form-group">
                    '.($i==0?'<label>Vendor Price</label>':'').'
                    <input type="text" class="form-control form-control-sm cp" name="vendor_price[]" placeholder="Assign Price">
                </div>
                <!--col-->
            </div>
            <!--row-->
                ';
            $i++;
        }
        return $html;
    }
    //assign rider vendor
    public function assign_rv(){
        return view('items.assign_rv');
    }
    public function save_rv(Request $request){
        $item_id=$request->item_id;
        DB::beginTransaction();
        RiderItemPrice::where('item_id',$item_id)->where('VID',$request->VID)->delete();
        VendorItemPrice::where('item_id',$item_id)->where('VID',$request->VID)->delete();
        $count=count($request->RID);
        try{
            for ($key=0; $key<$count; $key++){
                if(!empty($request['RID'][$key])) {
                    $item['item_id'] = $item_id;
                    $item['RID'] = $request['RID'][$key];
                    $item['VID'] = $request->VID;
                    $item['price'] = $request['price'][$key];
                    $retR = RiderItemPrice::create($item);
                    $vitem['item_id'] = $item_id;
                    $vitem['VID'] = $request->VID;
                    $vitem['price'] = $request['vendor_price'][$key];
                    $vitem['RID'] = $retR->id;
                    VendorItemPrice::create($vitem);
                }
            }
            DB::commit();
            return redirect()->back()->with('success', 'your message,here');
        }catch (QueryException $e){
            DB::rollback();
            dd($e->getMessage());
        }
    }
    public function assign_price(Request $request){
        if($request->ajax()){
            $data=VendorItemPrice::query()->with(['vendors','items'])->groupBy('item_id')->groupBy('VID')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.url('assign_price_edit/'.$row->item_id.'/'.$row->VID).'" data-toggle="tooltip" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-action="" data-original-title="Delete" class="btn btn-danger btn-xs deleteRecord"><i class="fas fa-trash"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return  view('items.assign_price');
    }
    public function assign_price_edit($id,$VID){
        $data=DB::table("vendor_item_prices")->join("rider_item_prices","vendor_item_prices.RID","rider_item_prices.id")
            ->select("vendor_item_prices.item_id AS item_id","vendor_item_prices.VID AS VID","vendor_item_prices.price as vp",
                "rider_item_prices.price as rp","rider_item_prices.RID as RRID","rider_item_prices.price as rider_price","vendor_item_prices.price as vendor_price")
            ->where("vendor_item_prices.VID",$VID)->where('vendor_item_prices.item_id',$id)->get();
        $data=json_decode($data,true);
        return view('items.show',compact('data'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Imports\RiderImport;
use App\Models\Accounts\TransactionAccount;
use App\Models\Files;
use App\Models\Item;
use App\Models\Rider;
use App\Models\RiderItemPrice;
use Form;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use DB;
use App\Helpers\CommonHelper;

class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(){
        $this->middleware("permission:riders_view",["only"=>["index"]]);
    }
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=Rider::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('VID', function($row){
                    return $row->vendor->name??'';
                })
                ->addColumn('PID', function($row){
                    return $row->project->name??'';
                })
                ->addColumn('id', function($row){
                    return $row->sims->sim_number??'';
                    /* $sim = '';
                    foreach($row->sims as $item){
                        $sim .= $item->sim_number.' '??'';
                    }
                    return $sim; */
                })
                ->addColumn('license_no', function($row){
                    return $row->bikes->plate??'';
                   /*  $plate = '';
                    foreach($row->bikes as $bike){
                        $plate .= $bike->plate.' '??'';
                    }
                    return $plate; */
                })
                ->addColumn('status', function($row){
                   
                        return CommonHelper::RiderStatus($row->status);
                        //return  Form::select('category_id', CommonHelper::RiderStatus(), $row->status, ['class' => 'statuschange','onchange' => 'changeStatus('.$row->id.',this)']);
                        
                        //return '<a href="javascript:void(0)" data-toggle="tooltip"  data-action="'.url('rider-status/'.$row->id).'" data-original-title="Action" class="doAction" ><span class="badge badge-primary" >Active</span></a>';
                    
                     })
                ->addColumn('action', function($row){
                    $btn = '';
                    if(\Auth::user()->can('riders_document')){
                    $btn = $btn.'<a href="'.route('rider.document',$row->id).'" data-toggle="tooltip" class="file btn btn-success btn-xs" data-modalID="modal-new"><i class="fas fa-file"></i> Documents</a>';
                    }
                    if(\Auth::user()->can('riders_edit')){
                    $btn =  $btn.' <a href="#" data-toggle="tooltip" data-action="'.route('rider.edit',$row->id).'" class="edit btn btn-primary btn-xs editRec" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>';
                    }
                    if(\Auth::user()->can('riders_delete')){
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-action="'.route('rider.store').'/'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-xs deleteRecord"><i class="fas fa-trash"></i> Del</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action','status'])
                ->make(true);

        }
        return view('riders.index');
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
       unset($request['item_id']);
       unset($request['item_price']);
      

        $rules=[
            'rider_id'=>'required',
            'name'=>'required',
            'personal_email'=>'required',
           /*  'passport'=>'required',
            'passport_expiry'=>'required', */
        ];
        $message=[
            'rider_id.required'=>'Rider ID Required',
            'name.required'=>'Rider Name Required',
            'personal_email.required'=>'Rider Email Required',
            /* 'passport.required'=>'Passport Required',
            'passport_expiry.required'=>'Passport Expiry Required', */
        ];
        $this->validate($request,$rules,$message);
        $data=$request->except(['code']);
        $data=$request->except(['items']);
        $arrayFiles=[];
        if(isset($request->attach_documents)) {
            foreach ($request->attach_documents as $files) {
                $path=$files->storeAs('rider',$files->getClientOriginalName());
                //$arrayFiles[] = url('storage/app/'.$path);
                $arrayFiles[] =$path;
            }
        }
        $data['attach_documents']=json_encode($arrayFiles);
        $id=$request->input('id');
        DB::beginTransaction();
        try {
            $tData['Trans_Acc_Name']=$request->name;
            $tData['PID']=21;
            if($id==0 || $id==''){
                $ret=Rider::create($data);
                $tData['Parent_Type']=$ret->id;
                $code=Account::current_code('RD',$ret->id);
                $tData['Parent_Type']=$ret->id;
                $tData['code']=$code;
                TransactionAccount::create($tData);
                //RiderItemPrice::where('RID',$ret->id)->where('VID',$request->post('VID'))->delete();
                if($request->post('items')){
                foreach($request->post('items') as $key=>$value){
                    
                    $p_data = [
                        'item_id' => $key,
                        'price' =>  $value,
                        'RID'   => $ret->id,
                        'VID'   => $request->post('VID')
                    ];

                    RiderItemPrice::create($p_data);

                }
            }
                

            }else{
                $ret=Rider::where('id',$id)->update($data);
                TransactionAccount::where('Parent_Type',$id)->where('PID',21)->update($tData);
                if($request->post('items')){
                RiderItemPrice::where('RID',$id)->delete();
                foreach($request->post('items') as $key=>$value){
                    
                    $p_data = [
                        'item_id' => $key,
                        'price' =>  $value,
                        'RID'   => $id,
                        'VID'   => $request->post('VID')
                    ];

                    RiderItemPrice::create($p_data);

                }
            }
            }
            DB::commit();
            return $ret;
        }catch (QueryException $e){
            DB::rollback();
            return response()->json([
                'success' => 'false',
                'errors'  => $e->getMessage(),
            ], 400);
        }
    }
    /*
     * import riders in excel
     */
    public function import_excel(Request $request){
        $rules=[
            'file'=>'required|max:50000|mimes:xlsx'
        ];
        $message=[
            'file.required'=>'Excel File Required'
        ];
        $this->validate($request,$rules, $message);
        Excel::import(new RiderImport(), $request->file('file'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $res=Rider::find($id)->toArray();
        $result = $res;

        $items = Item::all();
    
        foreach($items as $item){
            $r_item = RiderItemPrice::where('RID',$id)->where('VID',$res['VID'])->where('item_id',$item->id)->first();
            if($r_item){
                $result['items'][$r_item->item_id]['item_id'] = $r_item->item_id;
                $result['items'][$r_item->item_id]['item_price'] = $r_item->price;
               
            }
        }
        
        return $result;
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
        $ret=Rider::destroy($id);
        TransactionAccount::where('Parent_Type',$id)->where('PID',9)->delete();
        if($ret){
            return 1;
        }
    }

    public function status(Request $request)
    {
        $id = $request->post('id');
        $status = $request->post('status');
        $ret=Rider::find($id);
        $ret->status = $status;
        $ret->save();
       

        //TransactionAccount::where('Parent_Type',$id)->where('PID',9)->delete();
        if($ret){
            return 1;
        }
    }


    public function getItems(Request $request){
        /* $random = rand(0,999);
        $row = '<td>';
        $row .= '<select name="items['.$random.'][item_id]" class="form-control form-control-sm""><option value="0">Select Item</option>';
            $items = Item::all();
            foreach($items as $item){
                $row .='<option value="'.$item->id.'">'.$item->item_name.' - '.$item->pirce.'</option>';
            }
        $row .='</select></td>';
        $row .='<td><label>Price: &nbsp;</label>';
        $row .='<input type="number" step="any" name="items['.$random.'][price]" /></td>';
        
        $row .='<td><input type="button" class="ibtnDel btn btn-md btn-xs btn-danger "  value="Delete"></td>'; */

       $item = Item::find($request->item_id);
        $row = '<td width="250"><label>'.$item->item_name.'(Price: '.$item->pirce.')</label></td>                                
        <td width="130"><input type="number" name="items['.$item->id.']" id="item-'.$item->id.'" value="'.$request->item_price.'" step="any" class="form-control form-control-sm" /></td>';
        
        $row .='<td width="300"><input type="button" class="ibtnDel btn btn-md btn-xs btn-danger "  value="Delete"></td>';
      return $row;
    }
    /*
     *
     */

     public function document($rider_id){
        if(request()->post()){
           
            foreach(request('documents') as $document){
                
                if($document['expiry_date']){
                    $data = [];
                    if(isset($document['file_name'])){
                        
                        $extension = $document['file_name']->extension();
                        $name = $document['type'].'-'.$rider_id.'-'.time().'.'.$extension;
                        $document['file_name']->storeAs('rider',$name);
                        
                        $data['file_name'] = $name;
                        $data['file_type'] = $extension;
                    }
                    
                    $data['type_id'] = $rider_id;
                    $data['type'] = $document['type'];
                    $data['expiry_date'] = $document['expiry_date'];

                    $condition=[
                        'type' => $document['type'],
                        'type_id' => $rider_id
                        ];

                    Files::updateOrCreate($condition,$data);
                }
            }
            
        }

        $files = Files::where('type_id',$rider_id)->get();
        $rider = Rider::find($rider_id);

        return view('riders.document',compact('files','rider'));
     }
}

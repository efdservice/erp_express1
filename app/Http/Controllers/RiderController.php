<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Imports\RiderImport;
use App\Models\Accounts\TransactionAccount;
use App\Models\Files;
use App\Models\Rider;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use DB;

class RiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=Rider::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="'.route('rider.document',$row->id).'" data-toggle="tooltip" class="file btn btn-success btn-xs" data-modalID="modal-new"><i class="fas fa-file"></i> Documents</a>';
                    $btn =  $btn.' <a href="#" data-toggle="tooltip" data-action="'.route('rider.edit',$row->id).'" class="edit btn btn-primary btn-xs editRec" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-action="'.route('rider.store').'/'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-xs deleteRecord"><i class="fas fa-trash"></i> Del</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
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
        $rules=[
            'rider_id'=>'required',
            'name'=>'required',
            'personal_email'=>'required',
            'passport'=>'required',
            'passport_expiry'=>'required',
        ];
        $message=[
            'rider_id.required'=>'Rider ID Required',
            'name.required'=>'Rider Name Required',
            'personal_email.required'=>'Rider Email Required',
            'passport.required'=>'Passport Required',
            'passport_expiry.required'=>'Passport Expiry Required',
        ];
        $this->validate($request,$rules,$message);
        $data=$request->except(['code']);
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
            }else{
                $ret=Rider::where('id',$id)->update($data);
                TransactionAccount::where('Parent_Type',$id)->where('PID',9)->update($tData);
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
        $res=Rider::find($id);
        return $res;
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

        return view('riders.document',compact('files'));
     }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Models\Accounts\TransactionAccount;
use App\Models\Vendor;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=Vendor::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="#" data-toggle="tooltip" data-action="'.route('vendors.edit',$row->id).'" class="edit btn btn-primary btn-xs editRec" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-action="'.route('vendors.store').'/'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-xs deleteRecord"><i class="fas fa-trash"></i> Del</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return view('admin.settings.vendors.index',compact('data'));
        }
        return view('vendors.index');
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
            'name'=>'required',
            'email'=>'required',
        ];
        $message=[
            'name.required'=>'Vendor Name Required',
            'email.required'=>'Vendor Email Required'
        ];
        $this->validate($request,$rules,$message);
        $data=$request->except(['code','attach_documents']);
        $arrayFiles=[];
        if(isset($request->attach_documents)) {
            foreach ($request->attach_documents as $files) {
                $path=$files->storeAs('vendor',$files->getClientOriginalName());
                $arrayFiles[] = url('storage/app/'.$path);
            }
        }
        $data['attach_documents']=json_encode($arrayFiles);
        $id=$request->input('id');
        DB::beginTransaction();
        try {
            $tData['Trans_Acc_Name']=$request->name;
            $tData['PID']=9;
            if($id==0 || $id==''){
                $ret=Vendor::create($data);
                $tData['Parent_Type']=$ret->id;
                $code=Account::current_code('VC',$ret->id);
                Vendor::where('id',$ret->id)->update(['code'=>$code]);
                $tData['Parent_Type']=$ret->id;
                $tData['code']=$code;
                TransactionAccount::create($tData);
            }else{
                $ret=Vendor::where('id',$id)->update($data);
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
        $res=Vendor::find($id);
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
        TransactionAccount::where('PID',9)->where('Parent_Type',$id)->delete();
        return Vendor::destroy($id);
    }
}

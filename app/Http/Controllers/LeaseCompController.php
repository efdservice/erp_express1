<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Models\Accounts\TransactionAccount;
use App\Models\LeaseCompany;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use DB;

class LeaseCompController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=LeaseCompany::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="#" data-toggle="tooltip" data-action="'.route('lease_company.edit',$row->id).'" class="edit btn btn-primary btn-xs editRec" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-action="'.route('lease_company.store').'/'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-xs deleteRecord"><i class="fas fa-trash"></i> Del</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return  view('bikes.lease_companies.index');
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
        ];
        $message=[
            'name.required'=>'Name Required',
        ];
        $this->validate($request,$rules,$message);
        $data=$request->all();
        $id=$request->input('id');
        DB::beginTransaction();
        try {
            $tData['Trans_Acc_Name']=$request->name;
            $tData['PID']=22;
            if($id==0 || $id==''){
                $ret=LeaseCompany::create($data);
                $tData['Parent_Type']=$ret->id;
                $code=Account::current_code('LC',$ret->id);
                $tData['Parent_Type']=$ret->id;
                $tData['code']=$code;
                TransactionAccount::create($tData);
            }else{
                $ret=LeaseCompany::where('id',$id)->update($data);
                TransactionAccount::where('Parent_Type',$id)->where('PID',22)->update($tData);
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
        $res=LeaseCompany::find($id);
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
        TransactionAccount::where(['PID'=>22,'Parent_Type'=>$id])->delete();
        return LeaseCompany::destroy($id);
    }
}

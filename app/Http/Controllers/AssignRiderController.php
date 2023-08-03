<?php

namespace App\Http\Controllers;

use App\Models\AssignVendorRider;
use App\Models\Rider;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class AssignRiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=AssignVendorRider::with(['rider','vndor'])->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $btn = '<a href="#" data-toggle="tooltip" data-action="'.url('vendor/assign_rider/edit/'.$row->id.'').'" class="edit btn btn-primary btn-xs editRec" data-modalID="assign-modal-new"><i class="fas fa-edit"></i> Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-action="'.url('vendor/assign_rider/destroy/').'/'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-xs deleteRecord"><i class="fas fa-trash"></i> Del</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
            return view('admin.settings.vendors.index',compact('data'));
        }
        return view('vendors.assign_rider');
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
            'VID'=>'required',
            'RID'=>'required',
        ];
        $message=[
            'VID.required'=>'Vendor Required',
            'RID.required'=>'Rider Required'
        ];
        $this->validate($request,$rules,$message);
        $data=$request->except(['code','attach_documents']);
        $id=$request->input('id');
        DB::beginTransaction();
        try {
            $tData['Trans_Acc_Name']=$request->name;
            $tData['PID']=9;
            if($id==0 || $id==''){
                $ret=AssignVendorRider::create($data);
            }else{
                $ret=AssignVendorRider::where('id',$id)->update($data);
            }
            DB::commit();
            return $ret;
        }catch (\Exception $e){
            DB::rollback();
            return response()->json([
                'success' => 'false',
                'errors'  => $e->getCode()=="23000"?'Duplicate Entry':'Something Wrong with your request..',
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
        return AssignVendorRider::find($id);
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
        return AssignVendorRider::destroy($id);
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\AssignVendorRider;
use App\Models\Bike;
use App\Models\BikeHistory;
use App\Models\Rider;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class BikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=Bike::with('rider')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('rider_name', function($row){
                    return $row->rider->name.'('.$row->rider->rider_id.')';
                })
                ->addColumn('action', function($row){
                    $btn = '';
                    $btn=$btn.'<div class="dropdown">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Action
                      </button>
                      <div class="dropdown-menu">
                        <a href="#" data-toggle="tooltip" data-action="'.route('bike.edit',$row->id).'" class="edit editRec dropdown-item" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-action="'.route('bike.store').'/'.$row->id.'" data-original-title="Delete" class="dropdown-item deleteRecord"><i class="fas fa-trash"></i> Del</a>
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#change-rider" data-id="'.$row->id.'" class="dropdown-item get-bike-id"><i class="fas fa-user-edit"></i> Change Rider</a>
                      </div>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action','rider_name'])
                ->make(true);

        }
        return  view('bikes.index');
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
            'plate'=>'required',
            'chassis_number'=>'required',
            'engine'=>'required',
            'company'=>'required',
            'RID'=>'required',
        ];
        $message=[
            'plate.required'=>'Plate Required',
            'chassis_number.required'=>'Chassis number Required',
            'engine.required'=>'Engine number Required',
            'company.required'=>'Company Required',
            'RID.required'=>'Assigned To Rider Required',
        ];
        $this->validate($request,$rules,$message);
        $data=$request->except(['code']);
        $arrayFiles=[];
        if(isset($request->attach_documents)) {
            foreach ($request->attach_documents as $files) {
                $path=$files->storeAs('bikes',$files->getClientOriginalName());
                $arrayFiles[] = url('storage/app/'.$path);
            }
        }
        $data['attach_documents']=json_encode($arrayFiles);
        $id=$request->input('id');
        DB::beginTransaction();
        try {
            if($id==0 || $id==''){
                $ret=Bike::create($data);
                BikeHistory::create(['RID'=>$request->RID, 'BID'=>$id,'notes'=>$request->notes]);
            }else{
                $ret=Bike::where('id',$id)->update($data);
               BikeHistory::create(['RID'=>$request->RID, 'BID'=>$id,'notes'=>$request->notes]);
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
        return Bike::find($id);
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
        return Bike::destroy($id);
    }
    /*
     * change rider
     */
    public function change_rider(Request $request){
        $rules=[
            'BID'=>'required',
            'RID'=>'required',
        ];
        $message=[
            'BID.required'=>'ID Required',
            'RID.required'=>'Rider Required',
        ];
        $this->validate($request,$rules,$message);
        $data=$request->all();
        DB::beginTransaction();
        try {
            $ret=BikeHistory::create($data);
            Bike::where('id',$request->BID)->update(['RID'=>$request->RID]);
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
     * get_bike_history
     */
    public function get_bike_history($id){
        $res=BikeHistory::with('rider')->where('BID',$id)->get();
        return $res;
    }

    public function fetch_vendor_comp($id){
        $rider=Bike::where('id',$id)->value('RId');
        $vendor=AssignVendorRider::where('RID',$rider)->value('VID');
        return compact('rider','vendor');
    }
}

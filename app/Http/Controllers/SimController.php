<?php

namespace App\Http\Controllers;

use App\Models\Sim;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class SimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data=Sim::with('riderr')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('rider_name', function($row){
                    if($row->riderr){
                        return $row->riderr->name;
                    }else{
                        return '';
                    }
                })
                ->addColumn('rider_number', function($row){
                    if($row->riderr){
                        return $row->riderr->rider_id;
                    }else{
                        return '';
                    }
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="#" data-toggle="tooltip" data-action="'.route('sim.edit',$row->id).'" class="edit btn btn-primary btn-xs editRec" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>';
                    $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-action="'.route('sim.store').'/'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-xs deleteRecord"><i class="fas fa-trash"></i> Del</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return  view('sims.index');
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
            'sim_number'=>'required',
            'sim_company'=>'required',
            'assign_sim'=>'required|unique:sims',
        ];
        $message=[
            'sim_number.required'=>'Sim Number Required',
            'sim_company.required'=>'Sim Company Required',
            'assign_sim.required'=>'Sim must be assign to rider',
            'assign_sim.unique'=>'Sim already assigned to this rider.',
        ];
        $this->validate($request,$rules,$message);
        $data=$request->except(['code']);
        $id=$request->input('id');
        DB::beginTransaction();
        try {
            if($id==0 || $id==''){
                $ret=Sim::create($data);
            }else{
                $ret=Sim::where('id',$id)->update($data);
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
        return Sim::find($id);
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
        return Sim::destroy($id);
    }
}

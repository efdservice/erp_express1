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
    function __construct()
    {
        $this->middleware("permission:bikes_view", ['only' => ['index']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Bike::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('rider_name', function ($row) {
                    if ($row->rider) {
                        return $row->rider->name . '(' . $row->rider->rider_id . ')';
                    } else {
                        return '';
                    }
                })
                ->addColumn('vendor_name', function ($row) {
                    if ($row->rider) {
                        return $row->rider->vendor->name ?? '';
                    } else {
                        return '';
                    }
                })
                ->addColumn('sim_number', function ($row) {
                    if ($row->rider) {

                        return $row->rider->sims->sim_number ?? '';


                    } else {
                        return '';
                    }
                })
                ->addColumn('project_name', function ($row) {
                    if ($row->rider) {
                        return $row->rider->project->name ?? '';
                    } else {
                        return '';
                    }
                })
                ->addColumn('bike_status', function ($row) {

                    $stats = BikeHistory::where('BID', $row->id)->orderBy('id', 'desc')->first();
                    return $stats->warehouse ?? '';
                })
                ->addColumn('company', function ($row) {
                    if ($row->lease_company) {
                        return $row->lease_company->name ?? '';
                    } else {
                        return '';
                    }
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    $btn = $btn . '<div class="dropdown">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        Action
                      </button>
                      <div class="dropdown-menu">';
                    if (\Auth::user()->can('bikes_edit')) {
                        $btn = $btn . '
                        <a href="#" data-toggle="tooltip" data-action="' . route('bike.edit', $row->id) . '" class="edit editRec dropdown-item" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>';
                    }
                    if (\Auth::user()->can('bikes_delete')) {

                        $btn = $btn . '
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-action="' . route('bike.store') . '/' . $row->id . '" data-original-title="Delete" class="dropdown-item deleteRecord"><i class="fas fa-trash"></i> Del</a>';
                    }
                    if (\Auth::user()->can('bikes_status')) {

                        $btn = $btn . '
                        <div class="dropdown-divider"></div>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#change-rider" data-id="' . $row->id . '"  class="dropdown-item get-bike-id"><i class="fas fa-user-edit"></i> Change Status</a>';
                    }
                    $btn = $btn . '
                      </div>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['action', 'rider_name'])
                ->make(true);

        }

        $warehouse_count = Bike::groupBy('warehouse')->selectRaw('*,count(*) as total')->get();

        return view('bikes.index', compact('warehouse_count'));
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
            'plate' => 'required',
            'chassis_number' => 'required',
            'engine' => 'required',
            'company' => 'required',
            /* 'RID' => 'required|unique:bikes,RID,' . $request->input('id'), */
        ];
        $message = [
            'plate.required' => 'Plate Required',
            'chassis_number.required' => 'Chassis number Required',
            'engine.required' => 'Engine number Required',
            'company.required' => 'Company Required',
            /*  'RID.required' => 'Rider must be assign.',
             'RID.unique' => 'Rider has already assigned.', */
        ];
        $this->validate($request, $rules, $message);
        $data = $request->except(['code']);
        $arrayFiles = [];
        if (isset($request->attach_documents)) {
            foreach ($request->attach_documents as $key => $files) {
                $path = $files->storeAs('bikes', $files->getClientOriginalName());

                $arrayFiles[$key] = $path;
            }
        }
        $data['attach_documents'] = json_encode($arrayFiles);
        $id = $request->input('id');
        DB::beginTransaction();
        try {
            if ($id == 0 || $id == '') {
                $ret = Bike::create($data);
                //BikeHistory::create(['RID' => $request->RID, 'BID' => $id, 'notes' => $request->notes, 'warehouse' => 'Active']);
            } else {
                $ret = Bike::where('id', $id)->update($data);
                //BikeHistory::create(['RID' => $request->RID, 'BID' => $id, 'notes' => $request->notes, 'warehouse' => 'Active']);
            }
            DB::commit();
            return $ret;
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json([
                'success' => 'false',
                'errors' => $e->getMessage(),
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
    public function change_rider(Request $request)
    {
        $rules = [
            'BID' => 'required',
            'RID' => 'nullable|unique:bikes',
        ];
        $message = [
            'BID.required' => 'ID Required',
            'RID.unique' => 'Rider has already assigned.',
        ];
        $this->validate($request, $rules, $message);
        $data = $request->all();
        DB::beginTransaction();
        try {
            $ret = BikeHistory::create($data);
            Bike::where('id', $request->BID)->update(['RID' => $request->RID, 'warehouse' => $request->warehouse]);
            Rider::where('id', $request->RID)->update(['status' => 1]);
            DB::commit();
            return $ret;
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json([
                'success' => 'false',
                'errors' => $e->getMessage(),
            ], 400);
        }
    }
    /*
     * get_bike_history
     */
    public function get_bike_history($id)
    {
        $res = BikeHistory::with('rider')->where('BID', $id)->orderBy('note_date', 'DESC')->limit(10)->get();
        return $res;
    }


    public function fetch_vendor_comp($id)
    {
        $rider = Bike::where('id', $id)->value('RId');
        $vendor = AssignVendorRider::where('RID', $rider)->value('VID');
        return compact('rider', 'vendor');
    }

    public function contract($id)
    {
        $contract = BikeHistory::find($id);


        return view('bikes.contract', compact('contract'));
    }
    public function contract_upload(Request $request)
    {
        if (isset($request->contract)) {

            $doc = $request->contract;
            $extension = $doc->extension();
            $name = time() . '.' . $extension;
            $doc->storeAs('contract', $name);

            $contract = BikeHistory::find($request->id);
            $contract->contract = $name;
            $contract->save();

            return redirect(url('bike'))->with('success', $contract->rider->name . '( ' . $contract->rider->rider_id . ' ) Bike Plate # ' . $contract->bike->plate . ' Contract uploaded.');
        }
    }
}

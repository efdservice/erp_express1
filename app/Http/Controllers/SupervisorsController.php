<?php

namespace App\Http\Controllers;

use App\Helpers\Account;
use App\Models\Accounts\TransactionAccount;
use App\Models\Supervisors;
use Illuminate\Http\Request;
use DB;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class SupervisorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:supervisors_view', ['only' => ['index']]);

    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Supervisors::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (\Auth::user()->can('supervisors_edit')) {
                        $btn = $btn . '<a href="#" data-toggle="tooltip" data-action="' . route('supervisors.edit', $row->id) . '" class="edit btn btn-primary btn-xs editRec" data-modalID="modal-new"><i class="fas fa-edit"></i> Edit</a>';

                    }
                    if (\Auth::user()->can('supervisors_delete')) {
                        $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-action="' . route('supervisors.store') . '/' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-xs deleteRecord"><i class="fas fa-trash"></i> Del</a>';
                    }
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('supervisors.index');
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
            'name' => 'required',
            'phone' => 'required',
        ];
        $message = [
            'name.required' => 'Name is Required',
            'phone.required' => 'Phone is Required',
        ];
        $this->validate($request, $rules, $message);
        $data = $request->except(['id']);
        $id = $request->input('id');
        DB::beginTransaction();
        try {
            if ($id == 0 || $id == '') {

                $ret = Supervisors::create($request->all());
                /*  $tData['Parent_Type'] = $ret->id;
                 $code = Account::current_code('P', $ret->id);
                 $tData['Parent_Type'] = $ret->id;
                 $tData['Trans_Acc_Name'] = $ret->name;
                 $tData['code'] = $code;
                 $tData['PID'] = 2;
                 $tData['OB_Type'] = 1;
                 $tData['BID'] = 1;
                 TransactionAccount::create($tData); */
            } else {
                $ret = Supervisors::where('id', $id)->update($data);
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
        return supervisors::find($id);
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
        return supervisors::destroy($id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Requests\CreateLoansRequest;
use App\Http\Requests\UpdateLoansRequest;
use App\Models\Loans;
use App\Models\User;
use Illuminate\Http\Request;
use Flash;
use Response;
use Yajra\DataTables\DataTables;

class LoansController extends Controller
{
    /**
     * Display a listing of the Loans.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        /** @var Loans $loans */

        if ($request->ajax()) {
            $data = Loans::query()->orderBy('id', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', 'loans.datatables_actions')
                ->addColumn('created_by', function ($row) {
                    $user = User::find($row->Created_By);
                    if ($user) {
                        return $user->name . '<br/>' . $row->created_at->format('Y-m-d h:i a');
                    } else {
                        return null;
                    }
                })

                ->rawColumns(['action', 'created_by'])
                ->make(true);
        }
        $loans = Loans::all();

        return view('loans.index');
    }

    /**
     * Show the form for creating a new Loans.
     *
     * @return Response
     */
    public function create()
    {
        return view('loans.create');
    }

    /**
     * Store a newly created Loans in storage.
     *
     * @param CreateLoansRequest $request
     *
     * @return Response
     */
    public function store(CreateLoansRequest $request)
    {
        $input = $request->all();

        /** @var Loans $loans */
        $loans = Loans::create($input);

        Flash::success('Loans saved successfully.');

        return redirect(route('loans.index'));
    }

    /**
     * Display the specified Loans.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Loans $loans */
        $loans = Loans::find($id);

        if (empty($loans)) {
            Flash::error('Loans not found');

            return redirect(route('loans.index'));
        }

        return view('loans.show')->with('loans', $loans);
    }

    /**
     * Show the form for editing the specified Loans.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Loans $loans */
        $loans = Loans::find($id);

        if (empty($loans)) {
            Flash::error('Loans not found');

            return redirect(route('loans.index'));
        }

        return view('loans.edit')->with('loans', $loans);
    }

    /**
     * Update the specified Loans in storage.
     *
     * @param int $id
     * @param UpdateLoansRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLoansRequest $request)
    {
        /** @var Loans $loans */
        $loans = Loans::find($id);

        if (empty($loans)) {
            Flash::error('Loans not found');

            return redirect(route('loans.index'));
        }

        $loans->fill($request->all());
        $loans->save();

        Flash::success('Loans updated successfully.');

        return redirect(route('loans.index'));
    }

    /**
     * Remove the specified Loans from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Loans $loans */
        $loans = Loans::find($id);

        if (empty($loans)) {
            Flash::error('Loans not found');

            return redirect(route('loans.index'));
        }

        $loans->delete();

        Flash::success('Loans deleted successfully.');

        return redirect(route('loans.index'));
    }
}

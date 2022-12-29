<?php

namespace App\Http\Controllers;

use App\Tickets;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AdminArchivedController extends Controller
{
    public function index(Request $request) {

        if ($request->ajax()) {
            $data = Tickets::with('user')->where([['status', '=', 'archived']])->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data) {
                           $btnView = '<button type="button" name="view" id="'.$data->id.'" class="view btn btn-primary btn-sm">View</button>';
                           return $btnView;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        return view('admin.adminarchived');
    }
}

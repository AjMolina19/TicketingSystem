<?php

namespace App\Http\Controllers;

use App\Tickets;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Foundation\Auth\User;

class UserResolvedController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $id = auth()->user()->id;
            $data = Tickets::with('user')->where([['user_id', '=', $id], ['status', '=', 'resolved']])->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data) {
                           $btnView = '<button type="button" name="view" id="'.$data->id.'" class="view btn btn-primary btn-sm">View Ticket</button>';
                           return $btnView;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('users.resolved');
    }
}

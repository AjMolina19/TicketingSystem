<?php

namespace App\Http\Controllers;

use App\Tickets;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $id = auth()->user()->id;
            $data = Tickets::with('user')->where([['user_id', '=', $id], ['status', '=', 'open']])->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data) {
                           $btnView = '<button type="button" name="view" id="'.$data->id.'" class="view btn btn-primary btn-sm">View Ticket</button>';
                           return $btnView;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        return view('users.dashboard');
    }

    public function store()
    {
        request()->validate([
            'created_by' => 'required',
            'importance' => 'required',
            'title' => 'required',
            'status' => 'required',
            'created_at' => 'required'
        ]);
        $tickets = new Tickets();
        $tickets->user_id = auth()->user()->id;
        $tickets->created_by = request('created_by');
        $tickets->importance = request('importance');
        $tickets->title = request('title');
        $tickets->status = request('status');
        $tickets->created_at = request('created_at');
        $tickets->save();
        return response()->json();
    }
    public function edit($id)
    {
        $tickets = Tickets::find($id);
        if ($tickets){
            return response()->json([
                'status' => 200,
                'tickets' => $tickets,
            ]);
        }
        else
        {
            return response()->json([
                'status' => 404,
                'tickets' => 'tickets not Found',
            ]);
        }
    }
    public function update($id)
    {
        request()->validate([
            'created_by' => 'required',
            'importance' => 'required',
            'title' => 'required',
            'status' => 'required',
            'created_at' => 'required'
        ]);

        $tickets = Tickets::find($id);
        $tickets->created_by = request('created_by');
        $tickets->importance = request('importance');
        $tickets->title = request('title');
        $tickets->status = request('status');
        $tickets->remarks = request('remarks');
        $tickets->created_at = request('created_at');
        $tickets->save();
        return response()->json();

    }
}


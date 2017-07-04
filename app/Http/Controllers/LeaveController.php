<?php

namespace App\Http\Controllers;

use App\Leave;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;
use App\Logs;

class LeaveController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('spectator')->only(['store','update','drop']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'leave_to' => 'required|date',
            'leave_from' => 'required|date',
            'leave_form' => 'nullable|mimes:jpg,jpeg,png,gif,pdf|max:2048',
            'med_cert' => 'nullable|mimes:jpg,jpeg,png,gif,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error()->important();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = User::sort()->findOrFail($id);

        if($request->input('leave_from') > $request->input('leave_to')){
            flash('"From" date cannot be past the "To" date')->error()->important();
            return redirect()->back();
        }

        $data['type'] = $request->input('type');
        $data['leave_to'] = $request->input('leave_to');
        $data['leave_from'] = $request->input('leave_from');
        $data['emp_id'] = $user->id;

        $leave = Leave::create($data);

        if($request->file('med_cert')){
            $f = $request->file('med_cert');
            $f->storeAs('public/leave/'.$user->emp_id.'/'.$leave->id.'/','med_cert.'.$f->getClientOriginalExtension());
            $leave->med_cert = url('storage/leave/').'/'.$user->emp_id.'/'.$leave->id.'/'.'med_cert.'.$f->getClientOriginalExtension();
        }

        if($request->file('leave_form')){
            $f = $request->file('leave_form');
            $f->storeAs('public/leave/'.$user->emp_id.'/'.$leave->id.'/','leave_form.'.$f->getClientOriginalExtension());
            $leave->leave_form = url('storage/leave/').'/'.$user->emp_id.'/'.$leave->id.'/'.'leave_form.'.$f->getClientOriginalExtension();
        }

        $leave->save();
        $this->addLog('added leave records for '.$user->name);
        flash('Successfully added!')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'leave_to' => 'required|date',
            'leave_from' => 'required|date',
            'leave_form' => 'nullable|mimes:jpg,jpeg,png,gif,pdf|max:2048',
            'med_cert' => 'nullable|mimes:jpg,jpeg,png,gif,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error()->important();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $leave = Leave::findOrFail($id);
        $user = $leave->user()->first();

        if($request->input('leave_from') > $request->input('leave_to')){
            flash('"From" date cannot be past the "To" date')->error()->important();
            return redirect()->back();
        }

        $data['type'] = $request->input('type');
        $data['leave_to'] = $request->input('leave_to');
        $data['leave_from'] = $request->input('leave_from');
        $data['emp_id'] = $user->id;

        $leave->update($data);

        if($request->file('med_cert')){
            $f = $request->file('med_cert');
            if($leave->med_cert){
                Storage::delete('public/leave/'.$user->emp_id.'/'.$leave->id.'/'.Leave::fileName($leave->med_cert,$user->emp_id,$leave->id));
            }
            $f->storeAs('public/leave/'.$user->emp_id.'/'.$leave->id.'/','med_cert.'.$f->getClientOriginalExtension());
            $leave->med_cert = url('storage/leave/').'/'.$user->emp_id.'/'.$leave->id.'/'.'med_cert.'.$f->getClientOriginalExtension();
        }

        if($request->file('leave_form')){
            $f = $request->file('leave_form');
            if($leave->leave_form){
                Storage::delete('public/leave/'.$user->emp_id.'/'.$leave->id.'/'.Leave::fileName($leave->leave_form,$user->emp_id,$leave->id));
            }
            $f->storeAs('public/leave/'.$user->emp_id.'/'.$leave->id.'/','leave_form.'.$f->getClientOriginalExtension());
            $leave->leave_form = url('storage/leave/').'/'.$user->emp_id.'/'.$leave->id.'/'.'leave_form.'.$f->getClientOriginalExtension();
        }

        $leave->save();
        $this->addLog('updated leave records of '.$user->name);
        flash('Successfully updated!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function drop($id)
    {
        $leave = Leave::findOrFail($id);
        $user = $leave->user()->first();
        if($leave->med_cert){
            Storage::delete('public/leave/'.$user->emp_id.'/'.$leave->id.'/'.Leave::fileName($leave->med_cert,$user->emp_id,$leave->id));
        }
        if($leave->leave_form){
            Storage::delete('public/leave/'.$user->emp_id.'/'.$leave->id.'/'.Leave::fileName($leave->leave_form,$user->emp_id,$leave->id));
        }

        $leave->delete();
        $this->addLog('deleted leave records of '.$user->name);
        flash('Successfully deleted!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Leave  $leave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Leave $leave)
    {
        //
    }

    public function addLog($log){
        $user = Auth::user();
        $data['log_date'] = Carbon::now();
        $data['logs'] = $log;
        $user->logs()->save(Logs::create($data));
    }
}

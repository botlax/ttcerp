<?php

namespace App\Http\Controllers;

use App\Warning;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;
use App\Logs;

class WarningController extends Controller
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
    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'warning_date' => 'required|date',
            'warning_type' => 'required',
            'violation' => 'required',
            'warning_file' => 'nullable|mimes:jpeg,jpg,png,gif,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::sort()->findOrFail($id);

        $data['warning_type'] = $request->input('warning_type');
        $data['warning_date'] = $request->input('warning_date');
        $data['violation'] = $request->input('violation');
        $data['emp_id'] = $user->id;

        $warning = Warning::create($data);

        if($request->file('warning_file')){
            $f = $request->file('warning_file');
            $f->storeAs('public/warning/'.$user->emp_id.'/'.$warning->id.'/','warning.'.$f->getClientOriginalExtension());
            $warning->warning_file = url('storage/warning/').'/'.$user->emp_id.'/'.$warning->id.'/'.'warning.'.$f->getClientOriginalExtension();
        }

        $warning->save();
        $this->addLog('added a vacation record for '.$user->name);
        flash('Successfully added!')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warning  $warning
     * @return \Illuminate\Http\Response
     */
    public function show(Warning $warning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Warning  $warning
     * @return \Illuminate\Http\Response
     */
    public function edit(Warning $warning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Warning  $warning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'warning_date' => 'required|date',
            'warning_type' => 'required',
            'violation' => 'required',
            'warning_file' => 'nullable|mimes:jpeg,jpg,png,gif,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $warning = Warning::findOrFail($id);
        $user = $warning->user()->first();

        $data['warning_type'] = $request->input('warning_type');
        $data['warning_date'] = $request->input('warning_date');
        $data['violation'] = $request->input('violation');
        $data['emp_id'] = $user->id;

        $warning->update($data);

        if($request->file('warning_file')){
            $f = $request->file('warning_file');
            if($warning->warning_file){
                Storage::delete('public/warning/'.$user->emp_id.'/'.$warning->id.'/'.Warning::fileName($warning->warning_file,$user->emp_id,$warning->id));
            }
            $f->storeAs('public/warning/'.$user->emp_id.'/'.$warning->id.'/','warning.'.$f->getClientOriginalExtension());
            $warning->warning_file = url('storage/warning/').'/'.$user->emp_id.'/'.$warning->id.'/'.'warning.'.$f->getClientOriginalExtension();
        }

        $warning->save();
        $this->addLog('updated a vacation record of '.$user->name);
        flash('Successfully updated!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warning  $warning
     * @return \Illuminate\Http\Response
     */
    public function drop($id)
    {
        $warning = Warning::findOrFail($id);
        $user = $warning->user()->first();
        if($warning->warning_file){
            Storage::delete('public/warning/'.$user->emp_id.'/'.$warning->id.'/'.Warning::fileName($warning->warning_file,$user->emp_id,$warning->id));
        }

        $warning->delete();
        $this->addLog('deleted a warning record of '.$user->name);
        flash('Successfully deleted!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warning  $warning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warning $warning)
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

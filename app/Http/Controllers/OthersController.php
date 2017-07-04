<?php

namespace App\Http\Controllers;

use App\Others;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;
use App\Logs;

class OthersController extends Controller
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
            'ot_date' => 'required|date',
            'ot_type' => 'required',
            'ot_file' => 'nullable|mimes:jpeg,jpg,png,gif,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::sort()->findOrFail($id);

        $data['ot_type'] = $request->input('ot_type');
        $data['ot_date'] = $request->input('ot_date');
        $data['ot_desc'] = $request->input('ot_desc');
        $data['emp_id'] = $user->id;

        $ot = Others::create($data);

        if($request->file('ot_file')){
            $f = $request->file('ot_file');
            $f->storeAs('public/ot/'.$user->emp_id.'/'.$ot->id.'/','ot.'.$f->getClientOriginalExtension());
            $ot->ot_file = url('storage/ot/').'/'.$user->emp_id.'/'.$ot->id.'/'.'ot.'.$f->getClientOriginalExtension();
        }

        $ot->save();
        $this->addLog('added a record for '.$user->name);
        flash('Successfully added!')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Others  $others
     * @return \Illuminate\Http\Response
     */
    public function show(Others $others)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Others  $others
     * @return \Illuminate\Http\Response
     */
    public function edit(Others $others)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Others  $others
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ot_date' => 'required|date',
            'ot_type' => 'required',
            'ot_file' => 'nullable|mimes:jpeg,jpg,png,gif,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $ot = Others::findOrFail($id);
        $user = $ot->user()->first();

        $data['ot_type'] = $request->input('ot_type');
        $data['ot_date'] = $request->input('ot_date');
        $data['ot_desc'] = $request->input('ot_desc');
        $data['emp_id'] = $user->id;

        $ot->update($data);

        if($request->file('ot_file')){
            $f = $request->file('ot_file');
            if($ot->ot_file){
                Storage::delete('public/ot/'.$user->emp_id.'/'.$ot->id.'/'.Others::fileName($ot->ot_file,$user->emp_id,$ot->id));
            }
            $f->storeAs('public/ot/'.$user->emp_id.'/'.$ot->id.'/','ot.'.$f->getClientOriginalExtension());
            $ot->ot_file = url('storage/ot/').'/'.$user->emp_id.'/'.$ot->id.'/'.'ot.'.$f->getClientOriginalExtension();
        }

        $ot->save();
        $this->addLog('updated a record of '.$user->name);
        flash('Successfully updated!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AI  $aI
     * @return \Illuminate\Http\Response
     */
    public function drop($id)
    {
        $ot = Others::findOrFail($id);
        $user = $ot->user()->first();
        if($ot->ot_file){
            Storage::delete('public/ot/'.$user->emp_id.'/'.$ot->id.'/'.Others::fileName($ot->ot_file,$user->emp_id,$ot->id));
        }

        $ot->delete();
        $this->addLog('deleted a record of '.$user->name);
        flash('Successfully deleted!')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $user = Auth::user();
        $data['log_date'] = Carbon::now();
        $data['logs'] = $log;
        $user->logs()->save(Logs::create($data));
    }
}

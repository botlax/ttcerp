<?php

namespace App\Http\Controllers;

use App\AI;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Auth;
use App\Logs;

class AIController extends Controller
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
            'ai_date' => 'required|date',
            'ai_type' => 'required',
            'ai_file' => 'nullable|mimes:jpeg,jpg,png,gif,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::sort()->findOrFail($id);

        $data['ai_type'] = $request->input('ai_type');
        $data['ai_date'] = $request->input('ai_date');
        $data['emp_id'] = $user->id;

        $ai = AI::create($data);

        if($request->file('ai_file')){
            $f = $request->file('ai_file');
            $f->storeAs('public/ai/'.$user->emp_id.'/'.$ai->id.'/','ai.'.$f->getClientOriginalExtension());
            $ai->ai_file = url('storage/ai/').'/'.$user->emp_id.'/'.$ai->id.'/'.'ai.'.$f->getClientOriginalExtension();
        }

        $this->addLog('Added Accident / Injury record for '.$user->name);
        $ai->save();
        flash('Successfully added!')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AI  $aI
     * @return \Illuminate\Http\Response
     */
    public function show(AI $aI)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AI  $aI
     * @return \Illuminate\Http\Response
     */
    public function edit(AI $aI)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AI  $aI
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'ai_date' => 'required|date',
            'ai_type' => 'required',
            'ai_file' => 'nullable|mimes:jpeg,jpg,png,gif,pdf|max:2048'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $ai = AI::findOrFail($id);
        $user = $ai->user()->first();

        $data['ai_type'] = $request->input('ai_type');
        $data['ai_date'] = $request->input('ai_date');
        $data['emp_id'] = $user->id;

        $ai->update($data);

        if($request->file('ai_file')){
            $f = $request->file('ai_file');
            if($ai->ai_file){
                Storage::delete('public/ai/'.$user->emp_id.'/'.$ai->id.'/'.AI::fileName($ai->ai_file,$user->emp_id,$ai->id));
            }
            $f->storeAs('public/ai/'.$user->emp_id.'/'.$ai->id.'/','ai.'.$f->getClientOriginalExtension());
            $ai->ai_file = url('storage/ai/').'/'.$user->emp_id.'/'.$ai->id.'/'.'ai.'.$f->getClientOriginalExtension();
        }

        $ai->save();
        $this->addLog('Updated Accident / Injury record of '.$user->name);
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
        $ai = AI::findOrFail($id);
        $user = $ai->user()->first();
        if($ai->ai_file){
            Storage::delete('public/ai/'.$user->emp_id.'/'.$ai->id.'/'.AI::fileName($ai->ai_file,$user->emp_id,$ai->id));
        }

        $this->addLog('Deleted Accident / Injury record of '.$user->name);
        $ai->delete();
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

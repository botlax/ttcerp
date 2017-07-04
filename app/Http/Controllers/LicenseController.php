<?php

namespace App\Http\Controllers;

use App\License;
use App\User;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Logs;
use Carbon\Carbon;

class LicenseController extends Controller
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
        $user = User::sort()->findOrFail($id);
        $validator = Validator::make($request->all(), [
            'expiry_date' => 'required|date',
            'type' => 'required',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data['type'] = $request->input('type');
        $data['license'] = $user->qid;
        $data['expiry_date'] = $request->input('expiry_date');
        $data['emp_id'] = $user->id;
        if($request->file('file')){
            $f = $request->file('file');
            $f->storeAs('public/license/'.$user->emp_id.'/','license.'.$f->getClientOriginalExtension());
            $data['file'] = url('storage/license/').'/'.$user->emp_id.'/'.'license.'.$f->getClientOriginalExtension();
        }
       
        License::create($data);
        $this->addLog('added license record for '.$user->name);
        flash('Successfully added!')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function show(License $license)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function edit(License $license)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::sort()->findOrFail($id);
        $license = $user->license()->first();
        $validator = Validator::make($request->all(), [
            'expiry_date' => 'required|date',
            'type' => 'required',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $data['type'] = $request->input('type');
        $data['license'] = $user->qid;
        $data['expiry_date'] = $request->input('expiry_date');
        $data['emp_id'] = $user->id;
        if($request->file('file')){
            $f = $user->license()->first()->file;
            if($f){
                Storage::delete('public/license/'.$user->emp_id.'/'.License::fileName($f,$user->emp_id));
            }
            $request->file('file')->storeAs('public/license/'.$user->emp_id.'/','license.'.$request->file('file')->getClientOriginalExtension());
            $data['file'] = url('storage/license/').'/'.$user->emp_id.'/'.'license.'.$request->file('file')->getClientOriginalExtension();
        }

        $license->update($data);
        $this->addLog('updated license record of '.$user->name);
        flash('Successfully updated!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function drop($id)
    {
        $lic = License::findOrFail($id);
        $user = $lic->user()->first();
        if($lic->file){
            Storage::delete('public/license/'.$user->emp_id.'/'.License::fileName($lic->file,$user->emp_id));
        }
        License::destroy($id);
        $this->addLog('deleted license record of '.$user->name);
        flash('Successfully deleted!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\License  $license
     * @return \Illuminate\Http\Response
     */
    public function destroy(License $license)
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

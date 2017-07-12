<?php

namespace App\Http\Controllers;

use App\Emergency;
use App\User;
use Illuminate\Http\Request;
use Validator;

class EmergencyController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {   
        $this->middleware('intranet');
        $this->middleware('auth');
        $this->middleware('god')->only(['destroy']);
        $this->middleware('spectator');
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
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function show(Emergency $emergency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function edit(Emergency $emergency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $emp = User::findOrFail($id);
        $emergency = $emp->emergency()->first();

        $validator = Validator::make($request->all(), [
            'kin' => 'required',
            'relation' => 'required',
            'contact' => 'nullable',
            'address' => 'nullable',
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error()->important();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        if($emergency){
            $emergency->update($request->all());
        }
        else{
            $emp->emergency()->save(Emergency::create($request->all()));
        }

        flash('Operation successful!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $emergency = Emergency::findOrFail($id);
        $emergency->delete();
        flash('Successfully deleted!')->success();
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers;

use App\Salary;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Auth;
use App\Logs;
use Carbon\Carbon;

class SalaryController extends Controller
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
            'basic' => 'required|numeric',
            'transpo' => 'nullable|numeric',
            'accomodation' => 'nullable|numeric',
            'work_nature' => 'nullable|numeric',
            'others' => 'nullable|numeric',
            'food' => 'nullable|numeric',
            'special' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = User::findOrFail($id);
        $data['basic'] = $request->input('basic');
        $data['transpo'] = $request->input('transpo');
        $data['accomodation'] = $request->input('accomodation');
        $data['work_nature'] = $request->input('work_nature');
        $data['others'] = $request->input('others');
        $data['special'] = $request->input('special');
        $data['food'] = $request->input('food');
        $data['emp_id'] = $id;
        
        Salary::create($data);
        $this->addLog('added salary record for '.$user->name);
        flash('successfully added!')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show(Salary $salary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(Salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'basic' => 'required|numeric',
            'transpo' => 'nullable|numeric',
            'accomodation' => 'nullable|numeric',
            'work_nature' => 'nullable|numeric',
            'others' => 'nullable|numeric',
             'food' => 'nullable|numeric',
            'special' => 'nullable|numeric',
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $user = User::findOrFail($id);
        $data['basic'] = $request->input('basic');
        $data['transpo'] = $request->input('transpo');
        $data['accomodation'] = $request->input('accomodation');
        $data['work_nature'] = $request->input('work_nature');
        $data['others'] = $request->input('others');
        $data['special'] = $request->input('special');
        $data['food'] = $request->input('food');
        $data['emp_id'] = $id;
        
        $salary = User::sort()->findOrFail($id)->salary()->first();
        $salary->update($data);
        $this->addLog('updated salary record of '.$user->name);
        flash('successfully updated!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function drop($id)
    {
        $user = User::findOrFail($id);
        $salary = $user->salary()->first();
        $salary->delete();
        $this->addLog('deleted salary record of '.$user->name);
        flash('successfully deleted!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salary $salary)
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

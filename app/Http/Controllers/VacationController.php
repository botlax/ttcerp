<?php

namespace App\Http\Controllers;

use App\Vacation;
use App\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Logs;

class VacationController extends Controller
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
        $this->middleware('spectator')->only(['store','update','drop','add','create']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   

        $from = Carbon::today();
        $to = Carbon::tomorrow();
        
        $vacation = Vacation::where(function($q)use($from,$to){
            $q->where('vac_from','<=',$from)->where('vac_to','>=',$to);
        })->orWhere(function($q)use($from,$to){
            $q->where('vac_from','<=',$to)->where('vac_from','>=',$from);
        })->orWhere(function($q)use($from,$to){
            $q->where('vac_to','<=',$to)->where('vac_to','>=',$from);
        })->orderBy('vac_from','DESC')->get();

        //dd($vacation);
        return view('dashboard.vacation',compact('vacation','lowest','highest'));
    }

    public function search(Request $request){
        $this->validate($request,[
            'from' => 'required|date',
            'to' => 'required|date'
        ]);

        $from = new Carbon($request->input('from'));
        $to = new Carbon($request->input('to'));
        
        $vacation = Vacation::where(function($q)use($from,$to){
            $q->where('vac_from','<=',$from)->where('vac_to','>=',$to);
        })->orWhere(function($q)use($from,$to){
            $q->where('vac_from','<=',$to)->where('vac_from','>=',$from);
        })->orWhere(function($q)use($from,$to){
            $q->where('vac_to','<=',$to)->where('vac_to','>=',$from);
        })->get();

        return view('dashboard.vac-search',compact('vacation','from','to'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $employees = User::sort()->get();
        return view('dashboard.vacation-add',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $emp = User::sort()->findOrFail($id);
        return view('dashboard.vacation-create',compact('emp'));
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
            'vac_from' => 'required|date',
            'vac_to' => 'required|date',
            'vac_from_time' => 'nullable',
            'vac_to_time' => 'nullable',
            'airlines' => 'nullable',
            'ticket' => 'nullable|mimes:jpg,jpeg,gif,png,pdf|max:2048',
            'exit_permit' => 'nullable|mimes:jpg,jpeg,gif,png,pdf|max:2048',
            'original_form' => 'nullable|mimes:jpg,jpeg,gif,png,pdf|max:2048',
            'vacation_form' => 'nullable|mimes:jpg,jpeg,gif,png,pdf|max:2048',
            'leave_wpay' => 'nullable|numeric'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $user = User::sort()->findOrFail($id);
        if(!$user->salary()->first()){
            flash('Please add salary details for '.$user->name.' before adding vacation record.')->error()->important();
            return redirect()->back();
        }

        if($request->input('vac_from') > $request->input('vac_to')){
            flash('"From" date cannot be past the "To" date')->error()->important();
            return redirect()->back();
        }

        if($request->input('leave_wpay')){
            $from = new Carbon($request->input('vac_from'));
            $to = new Carbon($request->input('vac_to'));

            $diffDays = $from->diffInDays($to);

            if(intval($request->input('leave_wpay')) > $diffDays){
                $leave_wpay = $diffDays;
            }
            else{
                $leave_wpay = $request->input('leave_wpay');
            }

            $data['leave_wpay'] = $leave_wpay;
        }

        $data['vac_from'] = $request->input('vac_from');
        $data['vac_to'] = $request->input('vac_to');
        $data['vac_from_time'] = $request->input('vac_from_time');
        $data['vac_to_time'] = $request->input('vac_to_time');
        $data['airlines'] = $request->input('airlines');
        $data['emp_id'] = $id;

        $vac = Vacation::create($data);

        if($request->file('ticket')){
            $f = $request->file('ticket');
            $f->storeAs('public/vacation/'.$user->emp_id.'/'.$vac->id.'/','ticket.'.$f->getClientOriginalExtension());
            $vac->ticket = url('storage/vacation/').'/'.$user->emp_id.'/'.$vac->id.'/'.'ticket.'.$f->getClientOriginalExtension();
        }

        if($request->file('exit_permit')){
            $f = $request->file('exit_permit');
            $f->storeAs('public/vacation/'.$user->emp_id.'/'.$vac->id.'/','exit_permit.'.$f->getClientOriginalExtension());
            $vac->exit_permit = url('storage/vacation/').'/'.$user->emp_id.'/'.$vac->id.'/'.'exit_permit.'.$f->getClientOriginalExtension();
        }

        if($request->file('original_form')){
            $f = $request->file('original_form');
            $f->storeAs('public/vacation/'.$user->emp_id.'/'.$vac->id.'/','original_form.'.$f->getClientOriginalExtension());
            $vac->original_form = url('storage/vacation/').'/'.$user->emp_id.'/'.$vac->id.'/'.'original_form.'.$f->getClientOriginalExtension();
        }

        if($request->file('vacation_form')){
            $f = $request->file('vacation_form');
            $f->storeAs('public/vacation/'.$user->emp_id.'/'.$vac->id.'/','vacation_form.'.$f->getClientOriginalExtension());
            $vac->vacation_form = url('storage/vacation/').'/'.$user->emp_id.'/'.$vac->id.'/'.'vacation_form.'.$f->getClientOriginalExtension();
        }

        $vac->save();

        $this->addLog('added a vacation record for '.$user->name);
        flash('Successfully added!')->success();
        return redirect()->back();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function show(Vacation $vacation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function edit(Vacation $vacation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'vac_from' => 'required|date',
            'vac_to' => 'required|date',
            'vac_from_time' => 'nullable',
            'vac_to_time' => 'nullable',
            'ticket' => 'nullable|mimes:jpg,jpeg,gif,png,pdf|max:2048',
            'exit_permit' => 'nullable|mimes:jpg,jpeg,gif,png,pdf|max:2048',
            'original_form' => 'nullable|mimes:jpg,jpeg,gif,png,pdf|max:2048',
            'vacation_form' => 'nullable|mimes:jpg,jpeg,gif,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $vac = Vacation::findOrFail($id);
        $user = $vac->user()->first();
        if($request->input('vac_from') > $request->input('vac_to')){
            flash('"From" date cannot be past the "To" date')->error()->important();
            return redirect()->back();
        }

        if($request->input('leave_wpay')){
            $from = new Carbon($request->input('vac_from'));
            $to = new Carbon($request->input('vac_to'));

            $diffDays = $from->diffInDays($to);

            if(intval($request->input('leave_wpay')) > $diffDays){
                $leave_wpay = $diffDays;
            }
            else{
                $leave_wpay = $request->input('leave_wpay');
            }

            $data['leave_wpay'] = $leave_wpay;
        }

        $data['vac_from'] = $request->input('vac_from');
        $data['vac_to'] = $request->input('vac_to');
        $data['airlines'] = $request->input('airlines');

        if($request->input('var_from_time')){
            $data['vac_from_time'] = $request->input('vac_from_time');
        }

        if($request->input('var_to_time')){
            $data['vac_to_time'] = $request->input('vac_to_time');
        }

        if($request->file('ticket')){
            $f = $request->file('ticket');
            if($vac->ticket){
                Storage::delete('public/vacation/'.$user->emp_id.'/'.$vac->id.'/'.Vacation::fileName($vac->ticket,$user->emp_id,$vac->id));
            }
            $f->storeAs('public/vacation/'.$user->emp_id.'/'.$vac->id.'/','ticket.'.$f->getClientOriginalExtension());
            $data['ticket'] = url('storage/vacation/').'/'.$user->emp_id.'/'.$vac->id.'/'.'ticket.'.$f->getClientOriginalExtension();
        }

        if($request->file('exit_permit')){
            $f = $request->file('exit_permit');
            if($vac->exit_permit){
                Storage::delete('public/vacation/'.$user->emp_id.'/'.$vac->id.'/'.Vacation::fileName($vac->exit_permit,$user->emp_id,$vac->id));
            }
            $f->storeAs('public/vacation/'.$user->emp_id.'/'.$vac->id.'/','exit_permit.'.$f->getClientOriginalExtension());
            $data['exit_permit'] = url('storage/vacation/').'/'.$user->emp_id.'/'.$vac->id.'/'.'exit_permit.'.$f->getClientOriginalExtension();
        }

        if($request->file('original_form')){
            $f = $request->file('original_form');
            if($vac->original_form){
                Storage::delete('public/vacation/'.$user->emp_id.'/'.$vac->id.'/'.Vacation::fileName($vac->original_form,$user->emp_id,$vac->id));
            }
            $f->storeAs('public/vacation/'.$user->emp_id.'/'.$vac->id.'/','original_form.'.$f->getClientOriginalExtension());
            $data['original_form'] = url('storage/vacation/').'/'.$user->emp_id.'/'.$vac->id.'/'.'original_form.'.$f->getClientOriginalExtension();
        }

        if($request->file('vacation_form')){
            $f = $request->file('vacation_form');
            if($vac->vacation_form){
                Storage::delete('public/vacation/'.$user->emp_id.'/'.$vac->id.'/'.Vacation::fileName($vac->vacation_form,$user->emp_id,$vac->id));
            }
            $f->storeAs('public/vacation/'.$user->emp_id.'/'.$vac->id.'/','vacation_form.'.$f->getClientOriginalExtension());
            $data['vacation_form'] = url('storage/vacation/').'/'.$user->emp_id.'/'.$vac->id.'/'.'vacation_form.'.$f->getClientOriginalExtension();
        }

        $data['emp_id'] = $user->id;

        $vac->update($data);
        $this->addLog('updated a vacation record of '.$user->name);
        flash('Successfully updated!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function drop($id)
    {
        $vac = Vacation::findOrFail($id);
        $user = $vac->user()->first();

        if($vac->ticket){
            Storage::delete('public/vacation/'.$user->emp_id.'/'.$vac->id.'/'.Vacation::fileName($vac->ticket,$user->emp_id,$vac->id));
        }
        if($vac->exit_permit){
            Storage::delete('public/vacation/'.$user->emp_id.'/'.$vac->id.'/'.Vacation::fileName($vac->exit_permit,$user->emp_id,$vac->id));
        }
        if($vac->original_form){
            Storage::delete('public/vacation/'.$user->emp_id.'/'.$vac->id.'/'.Vacation::fileName($vac->original_form,$user->emp_id,$vac->id));
        }
        if($vac->vacation_form){
            Storage::delete('public/vacation/'.$user->emp_id.'/'.$vac->id.'/'.Vacation::fileName($vac->vacation_form,$user->emp_id,$vac->id));
        }

        Vacation::destroy($id);
        $this->addLog('deleted a vacation record of '.$user->name);
        flash('Successfully deleted!')->success();
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacation $vacation)
    {
        //
    }

    public function getMonth($month){
        switch ($month) {
            case 1:
                return 'January';
                break;
            case 2:
                return 'February';
                break;
            case 3:
                return 'March';
                break;
            case 4:
                return 'April';
                break;
            case 5:
                return 'May';
                break;
            case 6:
                return 'June';
                break;
            case 7:
                return 'July';
                break;
            case 8:
                return 'August';
                break;
            case 9:
                return 'September';
                break;
            case 10:
                return 'October';
                break;
            case 11:
                return 'November';
                break;
            case 12:
                return 'December';
                break;
        }
    }

    public function addLog($log){
        $user = Auth::user();
        $data['log_date'] = Carbon::now();
        $data['logs'] = $log;
        $user->logs()->save(Logs::create($data));
    }
}

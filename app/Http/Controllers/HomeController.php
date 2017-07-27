<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vacation;
use App\Others;
use App\License;
use App\Logs;
use App\Settings;
use App\Emergency;
use App\Cancel;
use App\Visa;
use Carbon\Carbon;
use Validator;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Expired;
use Illuminate\Support\Facades\Notification;
use Auth;
use Illuminate\Support\Collection;
use Excel;

class HomeController extends Controller
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
        $this->middleware('god')->only(['destroy','logs']);
        $this->middleware('spectator')->only(['store','update','delete','add','edit','drop','destroy']);
    }

    public function test()
    {
        return view('dashboard.test');
    }

    public function postTest(Request $request)
    {
        //dd($request->file());

        Excel::load($request->file('file'))->each(function (Collection $csvLine) {

             $test = [
                 'name' => "{$csvLine->get('first_name')} {$csvLine->get('last_name')}",
                 'job' => $csvLine->get('job'),
             ];

             dd($test);

        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = User::sort()->take(10)->get();
        return view('dashboard.home',compact('employees'));
    }

    public function employees()
    {
        $employees = User::sort()->get();

        $from = Carbon::today();
        $to = Carbon::tomorrow();

        $vacation = Vacation::where(function($q)use($from,$to){
            $q->where('vac_from','<=',$from)->where('vac_to','>=',$to);
        })->orWhere(function($q)use($from,$to){
            $q->where('vac_from','<=',$to)->where('vac_from','>=',$from);
        })->orWhere(function($q)use($from,$to){
            $q->where('vac_to','<=',$to)->where('vac_to','>=',$from);
        })->orderBy('vac_from','DESC')->get();

        return view('dashboard.employees',compact('employees','vacation'));
    }

    public function empSearch(Request $request)
    {

        $s = $request->input('q');
        $d = $request->input('designation');

        if(!$request->input('q') && !$request->input('designation')){
            $employees = User::sort();
        }
        elseif(!$request->input('q') && $request->input('designation')){
            $employees = User::sort()->where('designation',$d);
        }
        elseif($request->input('q') && !$request->input('designation')){
            $employees = User::sort()->where(function($q)use($s){
                $q->where('name','like','%'.$s.'%')->orWhere('qid','like',$s.'%')->orWhere('emp_id','like','%'.$s.'%');
            });
        }
        elseif($request->input('q') && $request->input('designation')){
            $employees = User::sort()->where('designation',$d)->where(function($q)use($s){
                $q->where('name','like','%'.$s.'%')->orWhere('qid','like', $s.'%')->orWhere('emp_id','like','%'.$s.'%');
            });
        }

        $emp_id = $employees->pluck('id')->toArray();
        $employees = $employees->get();

        $from = Carbon::today();
        $to = Carbon::tomorrow();
        
        $vacation = Vacation::whereHas('user',function($q)use($emp_id){
            $q->whereIn('id',$emp_id);
        })->where(function($q)use($from,$to){
            $q->where('vac_from','<=',$from)->where('vac_to','>=',$to);
        })->orWhere(function($q)use($from,$to){
            $q->where('vac_from','<=',$to)->where('vac_from','>=',$from);
        })->orWhere(function($q)use($from,$to){
            $q->where('vac_to','<=',$to)->where('vac_to','>=',$from);
        })->orderBy('vac_from','DESC')->get();

        return view('dashboard.employees-search',compact('employees','vacation','s','d'));
    }

    public function advSearch(Request $request)
    {

        $adj = intval($request->input('adj'));
        $attr = $request->input('attr');

        if($adj){
            if($attr == 'license'){
                $employees = User::sort()->whereHas('license');
            }
            elseif($attr == 'salary') {
                $employees = User::sort()->whereHas('salary');
            }
            else{
                $employees = User::sort()->whereHas('files',function($q)use($attr){
                    $q->where($attr,'!=',null)->orWhere($attr,'!=','');
                });
            }
        }
        else{
            if($attr == 'license'){
                $employees = User::sort()->whereDoesntHave('license');
            }
            elseif($attr == 'salary') {
                $employees = User::sort()->whereDoesntHave('salary');
            }
            else{
                $employees = User::sort()->where(function($q)use($attr){
                    $q->whereDoesntHave('files');
                })->orWhere(function($q)use($attr){
                    $q->whereHas('files',function($q)use($attr){
                        $q->where($attr,null)->orWhere($attr,'');
                    });
                });
            }
        }

        $employees = $employees->get();
        $adj = $adj == 1?'with':'without';

        return view('dashboard.employees-advsearch',compact('employees','adj','attr'));
    }

    public function cancelSearch(Request $request)
    {

        $s = $request->input('q');
        $d = $request->input('designation');

        if(!$request->input('q') && !$request->input('designation')){
            $employees = User::cancelled();
        }
        elseif(!$request->input('q') && $request->input('designation')){
            $employees = User::cancelled()->where('designation',$d);
        }
        elseif($request->input('q') && !$request->input('designation')){
            $employees = User::cancelled()->where(function($q)use($s){
                $q->where('name','like','%'.$s.'%')->orWhere('qid','like',$s.'%')->orWhere('emp_id','like','%'.$s.'%');
            });
        }
        elseif($request->input('q') && $request->input('designation')){
            $employees = User::cancelled()->where('designation',$d)->where(function($q)use($s){
                $q->where('name','like','%'.$s.'%')->orWhere('qid','like',$s.'%')->orWhere('emp_id','like','%'.$s.'%');
            });
        }
     
        $employees = $employees->get();

        return view('dashboard.employees-cancelled-search',compact('employees'));
    }

    public function empSummary()
    {

        $date = Carbon::today();

        $designations = ['plumber', 
                        'carpenter', 
                        'steel fixer', 
                        'leadman',
                        'foreman', 
                        'mason',
                        'driver',
                        'cleaner',
                        'painter',
                        'labor',
                        'mechanic',
                        'watchman',
                        'project engineer',
                        'project manager',
                        'safety officer',
                        'office staff',
                        'management'];

        foreach($designations as $des){

            $total[$des] = User::sort()->where('designation',$des)->count();
 
            $vac[$des] = User::sort()->where('designation',$des)->whereHas('vacation',function($q)use($date){ $q->where('vac_from','<=',$date)->where('vac_to','>=',$date); })->count();

            $duty[$des] = $total[$des] - $vac[$des];


            $pal[$des] = User::sort()->where('designation',$des)->where('nationality','Palestinian')->count();
            $jor[$des] = User::sort()->where('designation',$des)->where('nationality','Jordanian')->count();
            $pak[$des] = User::sort()->where('designation',$des)->where('nationality','Pakistani')->count();
            $egp[$des] = User::sort()->where('designation',$des)->where('nationality','Egyptian')->count();
            $ind[$des] = User::sort()->where('designation',$des)->where('nationality','Indian')->count();
            $nep[$des] = User::sort()->where('designation',$des)->where('nationality','Nepalese')->count();
            $phi[$des] = User::sort()->where('designation',$des)->where('nationality','Filipino')->count();
            $srl[$des] = User::sort()->where('designation',$des)->where('nationality','Sri Lankan')->count();
            $ban[$des] = User::sort()->where('designation',$des)->where('nationality','Bangladeshi')->count();
        }
        

        return view('dashboard.employees-summary',compact('vac','total','duty','pal','jor','pak','egp','ind','nep','phi','srl','ban'));
    }

    public function cancelled()
    {
        $employees = User::cancelled()->get();
        return view('dashboard.employees-cancelled',compact('employees'));
    }

    public function add()
    {
        $nats = $this->getNat();
        return view('dashboard.employees-add',compact('nats'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'nullable|email',
            'designation' => 'required',
            'position' => 'required',
            'nationality' => 'required',
            'joined' => 'required|date',
            'emp_id' => 'required|numeric',
            'qid' => 'nullable|numeric|digits:11|required_with:qid_expiry',
            'qid_expiry' => 'nullable|date|required_with:qid',
            'passport' => 'nullable|required_with:passport_expiry',
            'passport_expiry' => 'nullable|date|required_with:passport',
            'health_card' => 'nullable|required_with:hc_expiry',
            'hc_expiry' => 'nullable|date|required_with:health_card',
            'degree' => 'nullable|required_with:grad_date',
            'grad_date' => 'nullable|date|required_with:degree',
            'work_start_date' => 'nullable|date',
            'mobile' => 'nullable|numeric|digits:8',
            'children' => 'nullable|numeric',
            'location' => 'nullable|required_with:location_prefix',
            'location_prefix' => 'nullable|required_with:location'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $prefix = $request->input('location_prefix');

        User::create($request->all());

        $this->addLog('Added employee '.$request->input('name'));
        flash('Successfully Added!')->success();
        return redirect()->back();
    }

    public function show($id)
    {
        $emp = User::findOrFail($id);
        $next = User::sort()->where('emp_id','>',$emp->emp_id)->orderBy('emp_id','ASC')->first();
        $prev = User::sort()->where('emp_id','<',$emp->emp_id)->orderBy('emp_id','DESC')->first();

        $emergency = $emp->emergency()->first();

        $files = $emp->files()->first();
        $nats = $this->getNat();
        $vacation['on'] = false;
        $vacation['current'] = null;
        $vacation['upcoming'] = null;
        $vacation['past'] = null;
        if(!empty($emp->vacation()->get()->toArray())){
            if(!empty($emp->vacation()->where('vac_from','<=',Carbon::today())->where('vac_to','>',Carbon::today())->get()->toArray())){
                $vacation['on'] = true;
                $vacation['current'] = $emp->vacation()->where('vac_from','<=',Carbon::today())->where('vac_to','>',Carbon::today())->first();
            }
            else{
                $vacation['on'] = false;
            }
            if(!empty($emp->vacation()->where('vac_from','>',Carbon::today())->get()->toArray())){
                $vacation['upcoming'] = $emp->vacation()->where('vac_from','>',Carbon::today())->orderBy('vac_from','ASC')->first();
            }
            else{
                $vacation['upcoming'] = null;
            }
            if(!empty($emp->vacation()->where('vac_to','<',Carbon::today())->get()->toArray())){
                $vacation['past'] = $emp->vacation()->where('vac_to','<',Carbon::today())->get();
            }else{
                $vacation['past'] = null;
            }
        }

        $ot['Increment Requests'] = null;
        $ot['Increment Approved Form'] = null;
        $ot['Cash Advance'] = null;
        $ot['Personal Loan'] = null;
        $ot['Salary Loan'] = null;
        $ot['Car Loan'] = null;
        $ot['Previous Contract'] = null;
        $ot['Bank Account'] = null;
        if($emp->ot()->first()){
            foreach($emp->ot()->orderBy('ot_date','DESC')->get() as $other){
                switch ($other->ot_type) {
                    case 'increment request':
                        $ot['Increment Requests'][] = $other;
                        break;
                    case 'increment approved form':
                        $ot['Increment Approved Form'][] = $other;
                        break;
                    case 'cash advance':
                        $ot['Cash Advance'][] = $other;
                        break;
                    case 'personal loan':
                        $ot['Personal Loan'][] = $other;
                        break;
                    case 'car loan':
                        $ot['Car Loan'][] = $other;
                        break;
                    case 'salary loan':
                        $ot['Salary Loan'][] = $other;
                        break;
                    case 'previous contract':
                        $ot['Previous Contract'][] = $other;
                        break;
                    case 'bank account':
                        $ot['Bank Account'][] = $other;
                        break;
                }
            }
        }

        $salary = $emp->salary()->first();
        if($salary){
            $basic = $emp->salary()->first()->basic;
            $margin = new Carbon('2005-1-1');
            if($emp->joined < $margin){
                $gratuity = ($margin->diffInYears(Carbon::today()))*(($basic/30)*21);
            }
            else{
                $gratuity = ($emp->joined->diffInYears(Carbon::today()))*(($basic/30)*21);
            }
        }else{
            $gratuity = null;
        }
        return view('dashboard.employee',compact('emp','files','nats','vacation','ot','next','prev','emergency','gratuity'));
    }

    public function edit($id)
    {
        $nats = $this->getNat();
        $emp = User::findOrFail($id);
        return view('dashboard.employee-edit',compact('emp','nats'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'joined' => 'date',
            'email' => 'nullable|email',
            'emp_id' => 'numeric',
            'qid' => 'nullable|numeric|digits:11|required_with:qid_expiry',
            'qid_expiry' => 'nullable|date|required_with:qid',
            'passport' => 'nullable|required_with:passport_expiry',
            'passport_expiry' => 'nullable|date|required_with:passport',
            'health_card' => 'nullable|required_with:hc_expiry',
            'hc_expiry' => 'nullable|date|required_with:health_card',
            'degree' => 'nullable|required_with:grad_date',
            'grad_date' => 'nullable|date|required_with:degree',
            'work_start_date' => 'nullable|date',
            'mobile' => 'nullable|numeric|digits:8',
            'children' => 'nullable|numeric',
            'location' => 'nullable|required_with:location_prefix',
            'location_prefix' => 'nullable|required_with:location'
        ]);

        if ($validator->fails()) {
            flash('Wooops! Please try again and review the error messages.')->error();
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = User::findOrFail($id);

        foreach($request->input() as $field => $value){

            if($field != "_token"){
                switch ($field) {
                    case 'emp_id':
                        $user->emp_id = $value;
                        break;
                    case 'name':
                        $user->name = $value;
                        break;
                    case 'email':
                        $user->email = $value;
                        break;
                    case 'designation':
                        $user->designation = $value;
                        break;
                    case 'position':
                        $user->position = $value;
                        break;
                    case 'nationality':
                        $user->nationality = $value;
                        break;
                    case 'religion':
                        $user->religion = $value;
                        break;
                    case 'gender':
                        $user->gender = $value;
                        break;
                    case 'joined':
                        $user->joined = $value;
                        break;
                    case 'dob':
                        $user->dob = $value;
                        break;
                    case 'qid':
                        $user->qid = $value;
                        break;
                    case 'qid_expiry':
                        $user->qid_expiry = $value;
                        break;
                    case 'passport':
                        $user->passport = $value;
                        break;
                    case 'passport_expiry':
                        $user->passport_expiry = $value;
                        break;
                    case 'health_card':
                        $user->health_card = $value;
                        break;
                    case 'hc_expiry':
                        $user->hc_expiry = $value;
                        break;
                    case 'mobile':
                        $user->mobile = $value;
                        break;
                    case 'airport':
                        $user->airport = $value;
                        break;
                    case 'status':
                        $user->status = $value;
                        break;
                    case 'children':
                        $user->children = $value;
                        break;
                    case 'degree':
                        $user->degree = $value;
                        break;
                    case 'grad_date':
                        $user->grad_date = $value;
                        break;
                    case 'work_start_date':
                        $user->work_start_date = $value;
                        break;
                    case 'location':
                        $user->location = $value;
                        break;
                    case 'location_prefix':
                        $user->location_prefix = $value;
                        break;
                }
            }
        }

        $user->save();

        $this->addLog('Updated employee '.$user->name);
        flash('Successfully Updated!')->success();
        return redirect()->back();
    }

    public function showCancel($id)
    {
        $emp = User::cancelled()->findOrFail($id);
        return view('dashboard.employee-cancelled',compact('emp'));
    }

    public function delete($id)
    {
        $user = User::sort()->findOrFail($id);
        $user->role = 'cancel';
        $user->save();

        $this->addLog('Cancelled employee '.$user->name);
        flash('Employee successfully cancelled.')->success();

        return redirect('employees/'.$id.'/cancellation');
    }

    public function revive($id)
    {
        $user = User::cancelled()->findOrFail($id);
        $user->role = 'emp';
        $user->save();

        $user->cancel()->first()->delete();

        $this->addLog('Rehired employee '.$user->name);
        flash('Employee successfully rehired.')->success();

        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = User::cancelled()->findOrFail($id);

        if(count($user->toArray())){
            $this->addLog('Permanently deleted employee '.$user->name);
            Storage::deleteDirectory('public/vacation/'.$user->emp_id);
            Storage::deleteDirectory('public/license/'.$user->emp_id);
            Storage::deleteDirectory('public/files/'.$user->emp_id);
        }

        if(User::destroy($id)){
            flash('Successfully deleted.')->success();
        }
        else{
            flash('An error has occurred. Please refresh the page and try again.')->error();
        }

        return redirect()->back();
    }

    public function drop(Request $request, $id)
    {
        $field = $request->input('field');
        $user = User::findOrFail($id);
        switch ($field) {
            
            case 'religion':
                $user->religion = null;
                break;
            case 'gender':
                $user->gender = null;
                break;
            case 'dob':
                $user->dob = null;
                break;
            case 'qid':
                $user->qid = null;
                $user->qid_expiry = null;
                break;
            case 'passport':
                $user->passport = null;
                $user->passport_expiry = null;
                break;
            case 'health_card':
                $user->health_card = null;
                $user->hc_expiry = null;
                break;
            case 'mobile':
                $user->mobile = null;
                break;
            case 'airport':
                $user->airport = null;
                break;
            case 'status':
                $user->status = null;
                break;
            case 'children':
                $user->children = null;
                break;
            case 'degree':
                $user->degree = null;
                $user->grad_date = null;
                break;
            case 'work_start_date':
                $user->work_start_date = null;
                break;
        }
        $user->save();

        $this->addLog('Deleted '.$field.' details of '.$user->name);
        flash('successfully deleted!')->success();
        return redirect()->back();


    }

    public function qidExpiry(){

        $from = Carbon::today();
        $to = Carbon::today()->addMonth(1);

        $emps = User::sort()->where('qid_expiry','>=',$from)->where('qid_expiry','<=',$to)->orderBy('qid_expiry','DESC')->get();

        return view('dashboard.qid-expiry',compact('emps'));
    }

    public function qidExpired(){

        $date = Carbon::today();

        $emps = User::sort()->where('qid_expiry','<',$date)->orderBy('qid_expiry','DESC')->get();

        return view('dashboard.qid-expired',compact('emps'));
    }

    public function passportExpiry(){
        $from = Carbon::today();
        $to = Carbon::today()->addMonth(1);

        $emps = User::sort()->where('passport_expiry','>=',$from)->where('passport_expiry','<=',$to)->orderBy('passport_expiry','DESC')->get();

        return view('dashboard.passport-expiry',compact('emps'));
    }

    public function passportExpired(){
        $date = Carbon::today();

        $emps = User::sort()->where('passport_expiry','<',$date)->orderBy('passport_expiry','DESC')->get();

        return view('dashboard.passport-expired',compact('emps'));
    }

    public function hcExpiry(){
        $from = Carbon::today();
        $to = Carbon::today()->addMonth(1);

        $emps = User::sort()->where('hc_expiry','>=',$from)->where('hc_expiry','<=',$to)->orderBy('hc_expiry','DESC')->get();

        return view('dashboard.hc-expiry',compact('emps'));
    }

    public function hcExpired(){
        $date = Carbon::today();

        $emps = User::sort()->where('hc_expiry','<',$date)->orderBy('hc_expiry','DESC')->get();

        return view('dashboard.hc-expired',compact('emps'));
    }

    public function licenseExpiry(){

        $from = Carbon::today();
        $to = Carbon::today()->addMonth(1);

        $lics = License::where('expiry_date','>=',$from)->where('expiry_date','<=',$to)->orderBy('expiry_date','DESC')->get();

        return view('dashboard.license-expiry',compact('lics'));
    }

    public function licenseExpired(){

        $date = Carbon::today();

        $lics = License::where('expiry_date','<',$date)->orderBy('expiry_date','DESC')->get();

        return view('dashboard.license-expired',compact('lics'));
    }

    public function qidSearch(Request $request){
        $this->validate($request,[
            'from' => 'required|date',
            'to' => 'required|date'
        ]);

        $from = new Carbon($request->input('from'));
        $to = new Carbon($request->input('to'));
        
        $emps = User::sort()->where('qid_expiry','>=',$from)->where('qid_expiry','<=',$to)->orderBy('qid_expiry','DESC')->get();

        return view('dashboard.qid-search',compact('emps','from','to'));
    }

    public function passSearch(Request $request){
        $this->validate($request,[
            'from' => 'required|date',
            'to' => 'required|date'
        ]);

        $from = new Carbon($request->input('from'));
        $to = new Carbon($request->input('to'));
        
        $emps = User::sort()->where('passport_expiry','>=',$from)->where('passport_expiry','<=',$to)->orderBy('passport_expiry','DESC')->get();

        return view('dashboard.pass-search',compact('emps','from','to'));
    }

    public function hcSearch(Request $request){
        $this->validate($request,[
            'from' => 'required|date',
            'to' => 'required|date'
        ]);

        $from = new Carbon($request->input('from'));
        $to = new Carbon($request->input('to'));
        
        $emps = User::sort()->where('hc_expiry','>=',$from)->where('hc_expiry','<=',$to)->orderBy('hc_expiry','DESC')->get();

        return view('dashboard.hc-search',compact('emps','from','to'));
    }

    public function licSearch(Request $request){
        $this->validate($request,[
            'from' => 'required|date',
            'to' => 'required|date'
        ]);

        $from = new Carbon($request->input('from'));
        $to = new Carbon($request->input('to'));
        
        $lics = License::where('expiry_date','>=',$from)->where('expiry_date','<=',$to)->orderBy('expiry_date','DESC')->get();

        return view('dashboard.lic-search',compact('lics','from','to'));
    }

    public function logs(){
        $logs = Logs::sort()->paginate(30);
        return view('dashboard.logs',compact('logs'));
    }

    public function addLog($log){
        $user = Auth::user();
        $data['log_date'] = Carbon::now();
        $data['logs'] = $log;
        $user->logs()->save(Logs::create($data));
    }

    public function settings(){
        $settings = Settings::first();
        return view('dashboard.settings',compact('settings'));
    }

    public function updateSettings(Request $request){
        $field = $request->input('field');

        if($field == 'ip'){
            $settings = Settings::first();
            if($request->input('intranet')){
                $validator = Validator::make($request->all(), [
                    'public_ip1' => 'required_with:public_ip2|required_with:public_ip3|required_with:public_ip4|max:255|numeric',
                    'public_ip2' => 'required_with:public_ip1|required_with:public_ip3|required_with:public_ip4|max:255|numeric',
                    'public_ip3' => 'required_with:public_ip1|required_with:public_ip2|required_with:public_ip4|max:255|numeric',
                    'public_ip4' => 'required_with:public_ip1|required_with:public_ip2|required_with:public_ip3|max:255|numeric',
                ]);

                if ($validator->fails()) {
                    flash('Wooops! Please try again and review the error messages.')->error()->important();
                    return redirect()->back()
                                ->withErrors($validator)
                                ->withInput();
                }

                $settings->public_ip1 = $request->input('public_ip1');
                $settings->public_ip2 = $request->input('public_ip2');
                $settings->public_ip3 = $request->input('public_ip3');
                $settings->public_ip4 = $request->input('public_ip4');
                $settings->save();
            }
            else{
                $settings->public_ip1 = null;
                $settings->public_ip2 = null;
                $settings->public_ip3 = null;
                $settings->public_ip4 = null;
                $settings->save();
            }
        }
        elseif($field == 'report'){
            $this->validate($request,[
                'qid' => 'required|numeric',
                'passport' => 'required|numeric',
                'hc' => 'required|numeric',
                'license' => 'required|numeric',
                'visa' => 'required|numeric',
                'vac' => 'required|numeric',
            ]);

            $settings = Settings::first();

            $settings->update($request->all());
        }

        flash('Successfully updated!')->success();
        return redirect()->back();
    }

   

    public function getNat(){
        return ["" => "--Select Nationality--",
        "afghan" => "Afghan",
      "albanian" => "Albanian",
      "algerian" => "Algerian",
      "american" => "American",
      "andorran" => "Andorran",
      "angolan" => "Angolan",
      "antiguans" => "Antiguans",
      "argentinean" => "Argentinean",
      "armenian" => "Armenian",
      "australian" => "Australian",
      "austrian" => "Austrian",
      "azerbaijani" => "Azerbaijani",
      "bahamian" => "Bahamian",
      "bahraini" => "Bahraini",
      "bangladeshi" => "Bangladeshi",
      "barbadian" => "Barbadian",
      "barbudans" => "Barbudans",
      "batswana" => "Batswana",
      "belarusian" => "Belarusian",
      "belgian" => "Belgian",
      "belizean" => "Belizean",
      "beninese" => "Beninese",
      "bhutanese" => "Bhutanese",
      "bolivian" => "Bolivian",
      "bosnian" => "Bosnian",
      "brazilian" => "Brazilian",
      "british" => "British",
      "bruneian" => "Bruneian",
      "bulgarian" => "Bulgarian",
      "burkinabe" => "Burkinabe",
      "burmese" => "Burmese",
      "burundian" => "Burundian",
      "cambodian" => "Cambodian",
      "cameroonian" => "Cameroonian",
      "canadian" => "Canadian",
      "cape verdean" => "Cape Verdean",
      "central african" => "Central African",
      "chadian" => "Chadian",
      "chilean" => "Chilean",
      "chinese" => "Chinese",
      "colombian" => "Colombian",
      "comoran" => "Comoran",
      "congolese" => "Congolese",
      "costa rican" => "Costa Rican",
      "croatian" => "Croatian",
      "cuban" => "Cuban",
      "cypriot" => "Cypriot",
      "czech" => "Czech",
      "danish" => "Danish",
      "djibouti" => "Djibouti",
      "dominican" => "Dominican",
      "dutch" => "Dutch",
      "east timorese" => "East Timorese",
      "ecuadorean" => "Ecuadorean",
      "egyptian" => "Egyptian",
      "emirian" => "Emirian",
      "equatorial guinean" => "Equatorial Guinean",
      "eritrean" => "Eritrean",
      "estonian" => "Estonian",
      "ethiopian" => "Ethiopian",
      "fijian" => "Fijian",
      "filipino" => "Filipino",
      "finnish" => "Finnish",
      "french" => "French",
      "gabonese" => "Gabonese",
      "gambian" => "Gambian",
      "georgian" => "Georgian",
      "german" => "German",
      "ghanaian" => "Ghanaian",
      "greek" => "Greek",
      "grenadian" => "Grenadian",
      "guatemalan" => "Guatemalan",
      "guinea-bissauan" => "Guinea-Bissauan",
      "guinean" => "Guinean",
      "guyanese" => "Guyanese",
      "haitian" => "Haitian",
      "herzegovinian" => "Herzegovinian",
      "honduran" => "Honduran",
      "hungarian" => "Hungarian",
      "i-kiribati" => "I-Kiribati",
      "icelander" => "Icelander",
      "indian" => "Indian",
      "indonesian" => "Indonesian",
      "iranian" => "Iranian",
      "iraqi" => "Iraqi",
      "irish" => "Irish",
      "israeli" => "Israeli",
      "italian" => "Italian",
      "ivorian" => "Ivorian",
      "jamaican" => "Jamaican",
      "japanese" => "Japanese",
      "jordanian" => "Jordanian",
      "kazakhstani" => "Kazakhstani",
      "kenyan" => "Kenyan",
      "kittian and nevisian" => "Kittian and Nevisian",
      "kuwaiti" => "Kuwaiti",
      "kyrgyz" => "Kyrgyz",
      "laotian" => "Laotian",
      "latvian" => "Latvian",
      "lebanese" => "Lebanese",
      "liberian" => "Liberian",
      "libyan" => "Libyan",
      "liechtensteiner" => "Liechtensteiner",
      "lithuanian" => "Lithuanian",
      "luxembourger" => "Luxembourger",
      "macedonian" => "Macedonian",
      "malagasy" => "Malagasy",
      "malawian" => "Malawian",
      "malaysian" => "Malaysian",
      "maldivan" => "Maldivan",
      "malian" => "Malian",
      "maltese" => "Maltese",
      "marshallese" => "Marshallese",
      "mauritanian" => "Mauritanian",
      "mauritian" => "Mauritian",
      "mexican" => "Mexican",
      "micronesian" => "Micronesian",
      "moldovan" => "Moldovan",
      "monacan" => "Monacan",
      "mongolian" => "Mongolian",
      "moroccan" => "Moroccan",
      "mosotho" => "Mosotho",
      "motswana" => "Motswana",
      "mozambican" => "Mozambican",
      "namibian" => "Namibian",
      "nauruan" => "Nauruan",
      "nepalese" => "Nepalese",
      "new zealander" => "New Zealander",
      "nicaraguan" => "Nicaraguan",
      "nigerian" => "Nigerian",
      "nigerien" => "Nigerien",
      "north korean" => "North Korean",
      "northern irish" => "Northern Irish",
      "norwegian" => "Norwegian",
      "omani" => "Omani",
      "palestinian" => "Palestinian",
      "pakistani" => "Pakistani",
      "palauan" => "Palauan",
      "panamanian" => "Panamanian",
      "papua new guinean" => "Papua New Guinean",
      "paraguayan" => "Paraguayan",
      "peruvian" => "Peruvian",
      "polish" => "Polish",
      "portuguese" => "Portuguese",
      "qatari" => "Qatari",
      "romanian" => "Romanian",
      "russian" => "Russian",
      "rwandan" => "Rwandan",
      "saint lucian" => "Saint Lucian",
      "salvadoran" => "Salvadoran",
      "samoan" => "Samoan",
      "san marinese" => "San Marinese",
      "sao tomean" => "Sao Tomean",
      "saudi" => "Saudi",
      "scottish" => "Scottish",
      "senegalese" => "Senegalese",
      "serbian" => "Serbian",
      "seychellois" => "Seychellois",
      "sierra leonean" => "Sierra Leonean",
      "singaporean" => "Singaporean",
      "slovakian" => "Slovakian",
      "slovenian" => "Slovenian",
      "solomon islander" => "Solomon Islander",
      "somali" => "Somali",
      "south african" => "South African",
      "south korean" => "South Korean",
      "spanish" => "Spanish",
      "sri lankan" => "Sri Lankan",
      "sudanese" => "Sudanese",
      "surinamer" => "Surinamer",
      "swazi" => "Swazi",
      "swedish" => "Swedish",
      "swiss" => "Swiss",
      "syrian" => "Syrian",
      "taiwanese" => "Taiwanese",
      "tajik" => "Tajik",
      "tanzanian" => "Tanzanian",
      "thai" => "Thai",
      "togolese" => "Togolese",
      "tongan" => "Tongan",
      "trinidadian/tobagonian" => "Trinidadian/Tobagonian",
      "tunisian" => "Tunisian",
      "turkish" => "Turkish",
      "tuvaluan" => "Tuvaluan",
      "ugandan" => "Ugandan",
      "ukrainian" => "Ukrainian",
      "uruguayan" => "Uruguayan",
      "uzbekistani" => "Uzbekistani",
      "venezuelan" => "Venezuelan",
      "vietnamese" => "Vietnamese",
      "welsh" => "Welsh",
      "yemenite" => "Yemenite",
      "zambian" => "Zambian",
      "zimbabwean" => "Zimbabwean"];
    }

}


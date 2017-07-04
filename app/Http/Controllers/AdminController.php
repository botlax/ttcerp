<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use App\Logs;
use Carbon\Carbon;

class AdminController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('spectator');
        $this->middleware('god')->only(['admins']);
    }

    public function password(){
    	return view('dashboard.password');
    }

    public function changePassword(Request $request){
    	$this->validate($request,[
            'old_password' => 'required|required_with:new_password',
            'new_password' => 'required|confirmed'
        ]);

        if(Hash::check($request->input('old_password'),Auth::user()->password)){
           Auth::user()->password = bcrypt($request->input('new_password'));
           Auth::user()->save();

            flash('Successfully updated!')->success();
        }
        else{
            flash("Old Password incorrect!")->error();
        }

        return redirect()->back();
    }

    public function admins(){
    	$admins = User::admin()->whereNotIn('id',[Auth::user()->id])->get();
    	$emps = User::emp()->pluck('name','id');
    	$emps = $emps->all();
       	return view('dashboard.admins',compact('admins','emps'));
    }

    public function store(Request $request){
    	$this->validate($request,[
    		'role' => 'required',
    		'emp' => 'required',
    		'password' => 'required|confirmed|min:6'
    	]);

    	$emp = User::emp()->findOrFail($request->input('emp'));
    	$emp->role = $request->input('role');
    	$emp->password = bcrypt($request->input('password'));
    	$emp->save();
    	flash('Successfully added!')->success();

    	return redirect()->back();
    }

    public function edit($id){
    	$admin = User::admin()->findOrFail($id);
    	return view('dashboard.admin-edit',compact('admin'));
    }

    public function update(Request $request,$id){
    	$this->validate($request,[
    		'role' => 'required',
    		'name' => 'required',
    		'old_password' => 'required_with:new_password',
    		'new_password' => 'nullable|confirmed|min:6'
    	]);

    	$emp = User::admin()->findOrFail($id);
    	$emp->role = $request->input('role');
    	$emp->name = $request->input('name');
    	
    	if($request->input('old_password')){
    		if(Hash::check($request->input('old_password'),$emp->password)){
	          	$emp->password = bcrypt($request->input('new_password'));
	        }
    	}

    	$emp->save();
    	flash('Successfully updated!')->success();

    	return redirect()->back();
    }

    public function delete($id){
    	$admin = User::admin()->findOrFail($id);
    	$admin->role = 'emp';
    	$admin->password = null;
    	$admin->save();

    	flash('Successfully deleted!')->success();
    	return redirect()->back();
    }
}

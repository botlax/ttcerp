<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Files;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Excel;
use Carbon\Carbon;

class BatchController extends Controller
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
        $this->middleware('spectator');
    }

    public function index()
    {
        return view('dashboard.batch');
    }

    public function upload(Request $request)
    {
    	if($request->input('mode') == 'file'){
	        $files = $request->file('files');
	        $errorMessages = [];

	        for($i = 0;$i < count($files);$i++){
	            $errorMessages['files.'.$i.'.mimes'] = $files[$i]->getClientOriginalName().' Invalid file type. Accepted file type:pdf,jpg,png,jpeg,gif,bmp,docx,doc,xlsx,xls';
	            $errorMessages['files.'.$i.'.max'] = $files[$i]->getClientOriginalName().' Max file size exceeded. Max:50mb';
	        }

	        $validator = Validator::make($request->all(), [
	            'files.*' => 'mimes:pdf,jpg,png,jpeg,gif,bmp,docx,doc,xlsx,xls|max:2048',
	        	'file_type' => 'required'
	        ],$errorMessages);

	        if ($validator->fails()) {
	            flash('Wooops! Please try again and review the error messages.')->error()->important();
	            return redirect()->back()
	                        ->withErrors($validator)
	                        ->withInput();
	        }

	        $type = $request->input('file_type');



	        $fails = [];
	        foreach($files as $file){
	        	$emp_id = str_replace('.'.$file->getClientOriginalExtension(), '', $file->getClientOriginalName());
	        	$user = User::where('emp_id',$emp_id)->first();       	

	        	if($user){
		        	if($user->files()->first()){
		        		$f = $user->files()->first();

		        		if(Files::fileName($f,$type,$emp_id) != ''){
				            Storage::delete('public/files/'.$emp_id.'/'.Files::fileName($f,$type,$emp_id));
				        }

		        		$file->storeAs('public/files/'.$emp_id.'/',$type.'.'.$file->getClientOriginalExtension());
			            switch ($type) {
			                case 'cv':
			                    $f->cv = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'photo':
			                    $f->photo = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'contract':
			                    $f->contract = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'visa':
			                    $f->visa = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'passport':
			                    $f->passport = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'qid':
			                    $f->qid = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'job_offer':
			                    $f->job_offer = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'blood_group':
			                    $f->blood_group = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'diploma':
			                    $f->diploma = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'englic':
			                    $f->englic = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'hc_file':
			                    $f->hc_file = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			            }

			            $f->save();
		        	}
		        	else{
		        		$f = New Files(['emp_id' => $user->id]);

		        		$file->storeAs('public/files/'.$emp_id.'/',$type.'.'.$file->getClientOriginalExtension());
			            switch ($type) {
			                case 'cv':
			                    $f->cv = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'photo':
			                    $f->photo = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'contract':
			                    $f->contract = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'visa':
			                    $f->visa = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'passport':
			                    $f->passport = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'qid':
			                    $f->qid = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'job_offer':
			                    $f->job_offer = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'blood_group':
			                    $f->blood_group = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'diploma':
			                    $f->diploma = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'englic':
			                    $f->englic = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			                case 'hc_file':
			                    $f->hc_file = url('storage/files/').'/'.$emp_id.'/'.$type.'.'.$file->getClientOriginalExtension();
			                    break;
			            }

			            $f->save();
		        	}
		        }
		        else{
		        	$fails[] = $emp_id;
		        }
	        }



	        if(!empty($fails)){
	        	flash('Operation was succefull though some files did not match any record.')->important();
	        	session(['fails' => $fails]);
	        	return redirect()->back();
	        }

	        flash('All files were successfully added!')->success();
	        return redirect()->back();
	    }
	    else{

	    	$validator = Validator::make($request->all(), [
	            'files.*' => 'mimes:csv,xlsx,xls|max:2048',
	        	'file_type' => 'required'
	        ]);

	        if ($validator->fails()) {
	            flash('Wooops! Please try again and review the error messages.')->error()->important();
	            return redirect()->back()
	                        ->withErrors($validator)
	                        ->withInput();
	        }

	        $files = $request->file('files');
	        $type = $request->input('file_type');

	        foreach($files as $file){
	        	Excel::load($file, function($reader)use($type) {

				    $results = $reader->all();
				    foreach($results as $result){

				    	switch ($type) {
			                case 'passport':
			                    $user = User::where('emp_id',intval($result->id))->first();
			                    if($user){
			                    	$user->passport_expiry = $result->expiry;
				                    $user->save();
			                    }
				                else{
				                	$fails[] = intval($result->id);
				                }
			                    break;
			                case 'qid':
			                  	$user = User::where('emp_id',intval($result->id))->first();
			                    if($user){
			                    	$user->qid_expiry = $result->expiry;
				                    $user->save();
			                    }
				                else{
				                	$fails[] = intval($result->id);
				                }
			                    break;
			                case 'hc_file':
			                   	$user = User::where('emp_id',intval($result->id))->first();
			                    if($user){
			                    	$user->hc_expiry = $result->expiry;
				                    $user->save();
			                    }
				                else{
				                	$fails[] = intval($result->id);
				                }
			                break;
			            }
				    }
				});
	        }

	        if(!empty($fails)){
	        	flash('Operation was succefull though some files did not match any record.')->important();
	        	session(['fails' => $fails]);
	        	return redirect()->back();
	        }

	        flash('All expiry date entries were successfully updated!')->success();
	        return redirect()->back();
	    }
    }
}

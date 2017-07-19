<?php

namespace App\Http\Controllers;

use App\Files;
use App\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Logs;
use Carbon\Carbon;

class FileController extends Controller
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
        $this->middleware('spectator')->only(['store','update','delete']);
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
        $user = User::sort()->findOrFail($id);

        $errorMessages['cv.mimes'] = $request->file('cv')?$request->file('cv')->getClientOriginalName().' invalid file type. Accepted file type:doc,docx,xls,xlsx,pdf':'';
        $errorMessages['photo.image'] = $request->file('photo')?$request->file('photo')->getClientOriginalName().' invalid file type. Accepted file type:jpeg,jpg,png,gif':'';
        $errorMessages['contract.mimes'] = $request->file('contract')?$request->file('contract')->getClientOriginalName().' invalid file type. Accepted file type:doc,docx,xls,xlsx,pdf,jpg,jpeg,png,gif':'';
        $errorMessages['visa.mimes'] = $request->file('visa')?$request->file('visa')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['passport.mimes'] = $request->file('passport')?$request->file('passport')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['qid.mimes'] = $request->file('qid')?$request->file('qid')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['passport1.mimes'] = $request->file('passport1')?$request->file('passport1')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['qid1.mimes'] = $request->file('qid1')?$request->file('qid1')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['job_offer.mimes'] = $request->file('job_offer')?$request->file('job_offer')->getClientOriginalName().' invalid file type. Accepted file type:doc,docx,xls,xlsx,pdf,jpg,jpeg,png,gif':'';
        $errorMessages['blood_group.mimes'] = $request->file('blood_group')?$request->file('blood_group')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';

        $errorMessages['cv.max'] = 'Max file size exceeded:2mb';
        $errorMessages['photo.max'] = 'Max file size exceeded:1mb';
        $errorMessages['contract.max'] = 'Max file size exceeded:2mb';
        $errorMessages['visa.max'] = 'Max file size exceeded:2mb';
        $errorMessages['passport.max'] = 'Max file size exceeded:2mb';
        $errorMessages['qid.max'] = 'Max file size exceeded:2mb';
        $errorMessages['passport1.max'] = 'Max file size exceeded:2mb';
        $errorMessages['qid1.max'] = 'Max file size exceeded:2mb';
        $errorMessages['job_offer.max'] = 'Max file size exceeded:2mb';
        $errorMessages['blood_group.max'] = 'Max file size exceeded:2mb';

        $this->validate($request,[
            'cv' => 'mimes:doc,docx,xls,xlsx,pdf|max:2048',
            'photo' => 'image|max:1024',
            'contract' => 'mimes:doc,docx,xls,xlsx,pdf,jpg,jpeg,png,gif|max:2048',
            'visa' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'passport' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'qid' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'passport1' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'qid1' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'job_offer' => 'mimes:doc,docx,xls,xlsx,pdf,jpg,jpeg,png,gif|max:2048',
            'blood_group' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ],$errorMessages);

        $file = New Files(['emp_id' => $id]);

        foreach($request->file() as $field => $f){
            $f->storeAs('public/files/'.$user->emp_id.'/',str_replace('1', '', $field).'.'.$f->getClientOriginalExtension());
            switch ($field) {
                case 'cv':
                    $file->cv = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'photo':
                    $file->photo = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'contract':
                    $file->contract = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'visa':
                    $file->visa = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'passport':
                    $file->passport = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'qid':
                    $file->qid = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'passport1':
                    $file->passport = url('storage/files/').'/'.$user->emp_id.'/'.str_replace('1', '', $field).'.'.$f->getClientOriginalExtension();
                    break;
                case 'qid1':
                    $file->qid = url('storage/files/').'/'.$user->emp_id.'/'.str_replace('1', '', $field).'.'.$f->getClientOriginalExtension();
                    break;
                case 'job_offer':
                    $file->job_offer = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'blood_group':
                    $file->blood_group = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
            }
        }

        $file->save();
        $this->addLog('Added file records for '.$user->name);

        flash('files successfully uploaded!')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function show(Files $files)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function edit(Files $files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $errorMessages['cv.mimes'] = $request->file('cv')?$request->file('cv')->getClientOriginalName().' invalid file type. Accepted file type:doc,docx,xls,xlsx,pdf':'';
        $errorMessages['photo.image'] = $request->file('photo')?$request->file('photo')->getClientOriginalName().' invalid file type. Accepted file type:jpeg,jpg,png,gif':'';
        $errorMessages['contract.mimes'] = $request->file('contract')?$request->file('contract')->getClientOriginalName().' invalid file type. Accepted file type:doc,docx,xls,xlsx,pdf,jpg,jpeg,png,gif':'';
        $errorMessages['visa.mimes'] = $request->file('visa')?$request->file('visa')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['passport.mimes'] = $request->file('passport')?$request->file('passport')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['qid.mimes'] = $request->file('qid')?$request->file('qid')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['passport1.mimes'] = $request->file('passport1')?$request->file('passport1')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['qid1.mimes'] = $request->file('qid1')?$request->file('qid1')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';
        $errorMessages['job_offer.mimes'] = $request->file('job_offer')?$request->file('job_offer')->getClientOriginalName().' invalid file type. Accepted file type:doc,docx,xls,xlsx,pdf,jpg,jpeg,png,gif':'';
        $errorMessages['blood_group.mimes'] = $request->file('blood_group')?$request->file('blood_group')->getClientOriginalName().' invalid file type. Accepted file type:pdf,jpg,jpeg,png,gif':'';

        $errorMessages['cv.max'] = 'Max file size exceeded:2mb';
        $errorMessages['photo.max'] = 'Max file size exceeded:1mb';
        $errorMessages['contract.max'] = 'Max file size exceeded:2mb';
        $errorMessages['visa.max'] = 'Max file size exceeded:2mb';
        $errorMessages['passport.max'] = 'Max file size exceeded:2mb';
        $errorMessages['qid.max'] = 'Max file size exceeded:2mb';
        $errorMessages['passport1.max'] = 'Max file size exceeded:2mb';
        $errorMessages['qid1.max'] = 'Max file size exceeded:2mb';
        $errorMessages['job_offer.max'] = 'Max file size exceeded:2mb';
        $errorMessages['blood_group.max'] = 'Max file size exceeded:2mb';

        $this->validate($request,[
            'cv' => 'mimes:doc,docx,xls,xlsx,pdf|max:2048',
            'photo' => 'image|max:1024',
            'contract' => 'mimes:doc,docx,xls,xlsx,pdf,jpg,jpeg,png,gif|max:2048',
            'visa' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'passport' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'qid' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'passport1' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'qid1' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
            'job_offer' => 'mimes:doc,docx,xls,xlsx,pdf,jpg,jpeg,png,gif|max:2048',
            'blood_group' => 'mimes:pdf,jpg,jpeg,png,gif|max:2048',
        ],$errorMessages);

        $file = Files::findOrFail($id);
        $user = $file->user()->first();

        if(Files::fileName($file,$request->input('field'),$user->emp_id) != ''){
            Storage::delete('public/files/'.$user->emp_id.'/'.Files::fileName($file,$request->input('field'),$user->emp_id));
        }
      
        foreach($request->file() as $field => $f){
            $f->storeAs('public/files/'.$user->emp_id.'/',str_replace('1', '', $field).'.'.$f->getClientOriginalExtension());
            switch ($field) {
                case 'cv':
                    $file->cv = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'photo':
                    $file->photo = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'contract':
                    $file->contract = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'visa':
                    $file->visa = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'passport':
                    $file->passport = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'qid':
                    $file->qid = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'passport1':
                    $file->passport = url('storage/files/').'/'.$user->emp_id.'/'.str_replace('1', '', $field).'.'.$f->getClientOriginalExtension();
                    break;
                case 'qid1':
                    $file->qid = url('storage/files/').'/'.$user->emp_id.'/'.str_replace('1', '', $field).'.'.$f->getClientOriginalExtension();
                    break;
                case 'job_offer':
                    $file->job_offer = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
                case 'blood_group':
                    $file->blood_group = url('storage/files/').'/'.$user->emp_id.'/'.$field.'.'.$f->getClientOriginalExtension();
                    break;
            }
        }

        $file->save();
        $this->addLog('Updated file records of '.$user->name);
        flash('files successfully updated!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified column from resource.
     *
     * @param  \App\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $file = Files::findOrFail($id);
        $user = $file->user()->first();
        
        if(!Storage::delete('public/files/'.$user->emp_id.'/'.Files::fileName($file,$request->input('field'),$user->emp_id))){
           flash('An error has occurred. Please refresh the page and try again.')->error();
           return redirect()->back();
        }

        switch ($request->input('field')) {
            case 'cv':
                $file->cv = null;
                break;
            case 'photo':
                $file->photo = null;
                break;
            case 'contract':
                $file->contract = null;
                break;
            case 'visa':
                $file->visa = null;
                break;
            case 'passport':
                $file->passport = null;
                break;
            case 'qid':
                $file->qid = null;
                break;
            case 'job_offer':
                $file->job_offer = null;
                break;
            case 'blood_group':
                $file->blood_group = null;
                break;
        }

        $file->save();
        $this->addLog('Deleted '.$request->input('field').' file of '.$user->name);
        flash('successfully deleted!')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Files  $files
     * @return \Illuminate\Http\Response
     */
    public function destroy(Files $files)
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Cancel;

class AjaxController extends Controller
{
    public function empSearch(Request $request){
    	$this->validate($request,[
    		'search' => 'required'
    	]);

    	$s = $request->input('search');

    	$employees = User::sort()->where(function($q)use($s){
    		$q->where('name','like','%'.$s.'%')->orWhere('designation','like','%'.$s.'%')->orWhere('emp_id','like','%'.$s.'%');
    	})->get();
    	echo json_encode($employees);
    }

    public function empAll(){

    	$employees = User::sort()->get();

    	echo json_encode($employees);
    }

    public function cancelSearch(Request $request){
    	$this->validate($request,[
    		'search' => 'required'
    	]);

    	$s = $request->input('search');

    	$employees = User::cancelled()->where(function($q)use($s){
    		$q->where('name','like','%'.$s.'%')->orWhere('designation','like','%'.$s.'%')->orWhere('emp_id','like','%'.$s.'%');
    	})->get();
    	echo json_encode($employees);
    }

    public function cancelAll(){

    	$employees = User::cancelled()->get();

    	echo json_encode($employees);
    }

    public function info(Request $request){
        $emp = User::findOrFail($request->input('id'));
        $info = $emp->cancel()->first();

        if($info){
            $data['reason'] = $info->reason;
            $data['date'] = $info->cancel_date->format('F d, Y');
            echo json_encode($data);
        }
        else{
            echo 'empty';
        }
    }

}

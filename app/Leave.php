<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leave';
    protected $fillable = ['type','med_cert','leave_form','leave_from','leave_to','emp_id'];
    public $timestamps = false;
    protected $dates = ['leave_from','leave_to'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public static function fileName($file,$user_id,$vacation_id){
    	return str_replace(url('storage/leave/').'/'.$user_id.'/'.$vacation_id.'/', '', $file);
    }
}

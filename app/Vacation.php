<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vacation extends Model
{
    protected $table = 'vacation';
    protected $fillable = ['vac_from','vac_to','ticket','exit_permit','vacation_form','original_form','leave_wpay','emp_id'];
    public $timestamps = false;
    protected $dates = ['vac_from','vac_to'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public static function fileName($file,$user_id,$vacation_id){
    	return str_replace(url('storage/vacation/').'/'.$user_id.'/'.$vacation_id.'/', '', $file);
    }
}

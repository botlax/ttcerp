<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    protected $table = 'warning';
    protected $fillable = ['violation','warning_type','warning_file','emp_id','warning_date'];
    public $timestamps = false;
    protected $dates = ['warning_date'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public static function fileName($file,$user_id,$warning_id){
    	return str_replace(url('storage/warning/').'/'.$user_id.'/'.$warning_id.'/', '', $file);
    }
}

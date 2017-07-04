<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AI extends Model
{
	protected $table = 'accident_injury';
    protected $fillable = ['ai_file','ai_date','ai_type','emp_id'];
    public $timestamps = false;
    protected $dates = ['ai_date'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public static function fileName($file,$user_id,$ai_id){
    	return str_replace(url('storage/ai/').'/'.$user_id.'/'.$ai_id.'/', '', $file);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Others extends Model
{
    protected $table = 'others';
    protected $fillable = ['ot_file','ot_date','ot_type','ot_desc','emp_id'];
    public $timestamps = false;
    protected $dates = ['ot_date'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public static function fileName($file,$user_id,$ot_id){
    	return str_replace(url('storage/ot/').'/'.$user_id.'/'.$ot_id.'/', '', $file);
    }
}

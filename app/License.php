<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $table = 'license';
    protected $fillable = ['license','type','expiry_date','emp_id','file'];
    public $timestamps = false;
    protected $dates = ['expiry_date'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public static function fileName($file,$user_id){
    	return str_replace(url('storage/license/').'/'.$user_id.'/', '', $file);
    }
}

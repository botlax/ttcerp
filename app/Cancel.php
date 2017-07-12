<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cancel extends Model
{
    protected $table = 'cancel';
    protected $fillable = ['reason','cancel_date'];
    public $timestamps = false;
    protected $dates = ['cancel_date'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public function getCDateAttribute($date){
    	$date = new Carbon($date);
    	return $date->format('F d, Y');
    }
}

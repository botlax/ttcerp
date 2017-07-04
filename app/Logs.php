<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $table = 'logs';
    protected $fillable = ['logs','log_date','emp_id'];
    public $timestamps = false;
    protected $dates = ['log_date'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public function scopeSort($q){
        $q->orderBy('log_date','DESC');
    }
}

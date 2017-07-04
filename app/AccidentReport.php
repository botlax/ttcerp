<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccidentReport extends Model
{
    protected $table = 'accident_report';
    protected $fillable = ['file','date','emp_id'];
    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }
}

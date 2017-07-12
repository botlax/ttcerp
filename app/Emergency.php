<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    protected $table = 'emergency';
    protected $fillable = ['kin','relation','contact','address'];
    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SiteInjury extends Model
{
    protected $table = 'site_injury';
    protected $fillable = ['file','date','emp_id'];
    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }
}

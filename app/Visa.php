<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visa extends Model
{
    protected $table = 'visas';
    protected $fillable = ['interior','app_num','occupation','nationality','gender','status','year','visa_expiry_date','emp_id'];
    public $timestamps = false;
    protected $dates = ['visa_expiry_date'];

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public function getVisaExpiryAttribute(){
    	return $this->visa_expiry_date->format('F d, Y');
    }

    public function getInteriorAttribute($interior){
    	return strtoupper($interior);
    }
}

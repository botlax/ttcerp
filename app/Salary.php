<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salary';
    protected $fillable = ['basic','transpo','accomodation','work_nature','others','emp_id'];
    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public function getTotalAttribute(){
    	return intval($this->basic)+intval($this->transpo)+intval($this->accomodation)+intval($this->work_nature)+intval($this->others);
    }
    public function getSubTotalAttribute(){
    	return intval($this->transpo)+intval($this->accomodation)+intval($this->work_nature)+intval($this->others);
    }
}

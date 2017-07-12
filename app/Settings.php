<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';
    protected $fillable = ['visa','license','hc', 'vac', 'passport','qid', 'public_ip1', 'public_ip2', 'public_ip3', 'public_ip4'];
    public $timestamps = false;

    public function getVisaAttribute($str){
    	return intval($str);
    }

    public function getQidAttribute($str){
    	return intval($str);
    }

    public function getHcAttribute($str){
    	return intval($str);
    }

    public function getLicenseAttribute($str){
    	return intval($str);
    }

    public function getPassportAttribute($str){
    	return intval($str);
    }

    public function getIpAttribute(){
        return $this->public_ip1.'.'.$this->public_ip2.'.'.$this->public_ip3.'.'.$this->public_ip4;
    }
    
}

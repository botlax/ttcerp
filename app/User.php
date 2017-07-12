<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','designation','position', 'nationality', 'joined', 'qid', 'passport', 'health_card', 'dob', 'mobile', 'airport', 'children' ,'religion', 'degree', 'grad_date', 'work_start_date', 'status', 'role', 'password', 'emp_id', 'qid_expiry', 'passport_expiry', 'hc_expiry', 'location', 'location_prefix'
    ];

    protected $dates = [
        'joined', 'dob', 'grad_date', 'work_start_date', 'qid_expiry', 'passport_expiry', 'hc_expiry'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function files(){
        return $this->hasOne('App\Files','emp_id');
    }

    public function leave(){
        return $this->hasMany('App\Leave','emp_id');
    }

    public function license(){
        return $this->hasOne('App\License','emp_id');
    }

    public function visa(){
        return $this->hasOne('App\Visa','emp_id');
    }

    public function salary(){
        return $this->hasOne('App\Salary','emp_id');
    }

    public function emergency(){
        return $this->hasOne('App\Emergency','emp_id');
    }

    public function cancel(){
        return $this->hasOne('App\Cancel','emp_id');
    }

    public function ai(){
        return $this->hasMany('App\AI','emp_id');
    }

    public function ot(){
        return $this->hasMany('App\Others','emp_id');
    }

    public function vacation(){
        return $this->hasMany('App\Vacation','emp_id');
    }

    public function logs(){
        return $this->hasMany('App\Logs','emp_id');
    }

    public function warning(){
        return $this->hasMany('App\Warning','emp_id');
    }

    public function scopeSort($q){
        $q->where('role','<>','cancel')->orderBy('emp_id','ASC');
    }

    public function scopeEmp($q){
        $q->where('role','emp')->orderBy('emp_id','ASC');
    }

    public function scopeAdmin($q){
        $q->where('role','admin')->orWhere('role','god')->orWhere('role','spectator')->orderBy('emp_id','ASC');
    }

    public function scopeCancelled($q){
        $q->where('role','cancel')->orderBy('emp_id','ASC');
    }

    public function getNationalityAttribute($s){
        return ucwords($s);
    }
    public function getGenderAttribute($s){
        return ucwords($s);
    }

    public function getReligionAttribute($s){
        return ucwords($s);
    }

    public function getStatusAttribute($s){
        return ucwords($s);
    }

    public function getDesignationAttribute($s){
        return ucwords($s);
    }
    public function getPositionAttribute($s){
        return ucwords($s);
    }
    
    public function isAdmin(){
        if(\Auth::user()->role == 'admin'){
            return true;
        }
        else{
            return false;
        }
    }

    public function isGod(){
        if(\Auth::user()->role == 'god'){
            return true;
        }
        else{
            return false;
        }
    }

    public function isSpectator(){
        if(\Auth::user()->role == 'spectator'){
            return true;
        }
        else{
            return false;
        }
    }

    public function authorized(){
        if(\Auth::user()->role == 'god' || \Auth::user()->role == 'admin' || \Auth::user()->role == 'spectator'){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * Route notifications for the mail channel.
     *
     * @return string
     */
    public function routeNotificationForMail()
    {
        return $this->email;
    }
}

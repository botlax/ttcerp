<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Files extends Model
{
    protected $table = 'files';
    protected $fillable = ['cv','passport','contract','qid','visa','photo','job_offer','emp_id','blood_group','diploma','englic','hc_file'];
    public $timestamps = false;

    public function user(){
    	return $this->belongsTo('App\User','emp_id');
    }

    public static function fileName($file,$field,$user_id){
    	switch ($field) {
            case 'cv':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->cv);
                break;
            case 'photo':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->photo);
                break;
            case 'contract':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->contract);
                break;
            case 'visa':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->visa);
                break;
            case 'passport':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->passport);
                break;
            case 'qid':
               return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->qid);
                break;
            case 'job_offer':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->job_offer);
                break;
            case 'blood_group':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->blood_group);
                break;
            case 'diploma':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->diploma);
                break;
            case 'englic':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->englic);
                break;
            case 'hc_file':
                return str_replace(url('storage/files/').'/'.$user_id.'/', '', $file->hc_file);
                break;
        }
    }
}

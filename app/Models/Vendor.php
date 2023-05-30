<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use Notifiable;
    protected $fillable = ['id', 'name','password', 'mobile', 'address', 'email', 'status', 'logo', 'categorie_id', 'created_at', 'updated_at'];

    public function scopeStatus($query)
    {
        return $query->where('active', 1);
    }

    public function getStatusAttribute($val)
    {
        return $val == 1 ? 'مفعل' : 'غير مفعل';
    }
    public function setActiveAttribute($val){
        $val=='on' ?  $this->attributes['active'] =1: $this->attributes['active']=0;
    }

    public function getLogoAttribute($val)
    {
        return $val != null ? asset('admin/image/upload/vendors/' . $val) : '';
    }
    public function main_catigorie(){
        return $this->belongsTo('App\Models\Main_categorie','categorie_id','id');
    }
    public function setPasswordAttribute($val){
     $this->attributes['password']=bcrypt($val);
    }
    public function getPasswordAttribute($val){
      return encrypt($val);
    }
}

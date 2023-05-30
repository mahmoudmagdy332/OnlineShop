<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $table="languages";
    protected $fillable=['abbr','name','local','direction','active','created_at	','updated_at'];
    protected $hidden=['created_at','updated_at'];
    public function scopeActive($query){
        return $query->where('active',1);
    }
    public function setActiveAttribute($val){
     $val=='on' ?  $this->attributes['active'] =1: $this->attributes['active']=0;
    }
    public function getActiveAttribute($val){
        return $val==1 ? 'مفعل' : 'غير مفعل';
    }
    public function getDirectionAttribute($val){
        return $val=='rtl' ? 'من اليمين الى اليسار' : 'من اليسار الى اليمين';
    }
}

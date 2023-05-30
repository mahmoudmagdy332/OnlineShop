<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sub_catigorie extends Model
{
    protected $table="sub_categories";
    protected $fillable=['id','catigorie_id','parent_id','translation_lang','translation_of','name','slug','photo','active','created_at','updated_at'];
    protected $hidden=['created_at','updated_at'];
    public function scopeActive($query){
        return $query->where('active',1);
    }
    public function scopeDefaultCategorie($query){
        return $query->where('translation_of',0);
    }
    public function getActiveAttribute($val){
        return $val==1 ? 'مفعل' : 'غير مفعل';
    }
    public function getPhotoAttribute($val){
        return $val!=null ? asset('admin\image\upload\main_categories\\'.$val) : '';
    }
}

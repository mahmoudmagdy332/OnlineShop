<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Main_catigoriesRequest;
use App\Models\Main_categorie;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\str;

class MainCategoryController extends Controller
{
   public function index(){
       $defualt_lang= get_default_lang();
      $Main_categories= Main_categorie::where('translation_lang',$defualt_lang)->get();
      return view('admin.main_categories.index',compact('Main_categories'));
   }
   public function get_add(){
       return view('admin.main_categories.addlanguage');
   }
   public function store(Main_catigoriesRequest $req){
       try {
           if($req->photo!=null){
               $image = saveImage($req->photo, 'admin/image/upload/main_categories');
           }

           $defaultCategorie = $req->categories[get_default_lang()];
           try {
               $active=$defaultCategorie['active'] ;
           }
           catch (\Exception $ex){
               $active= 0 ;
           }

           DB::beginTransaction();
           $defaultCategorieId = Main_categorie::insertGetId([
               'translation_lang' => get_default_lang(),
               'translation_of' => 0,
               'name' => $defaultCategorie['name'],
               'slug' => $defaultCategorie['name'],
               'photo' => $image,
               'active' => $active
           ]);
           $mains = collect($req->categories)->filter(function ($value, $key) {
               return $key != get_default_lang();
           });
           if (isset($mains) && $mains->count()) {
               $categories_arr = [];
               foreach ($mains as $key => $main) {
                   try {
                       $active=$main['active'] ;
                   }
                   catch (\Exception $ex){
                       $active= 0 ;
                   }
                   $categories_arr[] = [
                       'translation_lang' => $key,
                       'translation_of' => $defaultCategorieId,
                       'name' => $main['name'],
                       'slug' => $main['name'],
                       'photo' => $image,
                       'active' => $active
                   ];
               }
               Main_categorie::insert($categories_arr);
       }
           DB::commit();
           return redirect()->route('admin.main_catigories')->with(['success'=>'تم االحفظ بنجاح']);
       }catch (\Exception $ex){
           DB::rollBack();
           return redirect()->route('admin.main_catigories')->with(['error'=>'حدث خطأ    ة يرجى المحاولة فيما بعد']);
       }

   }
   public  function edit($id){
       $default=Main_categorie::find($id);
       $categories=Main_categorie::where('translation_of',$id)->get();
     return view('admin.main_categories.edit',['default'=>$default,'categories'=>$categories]);
       //return $categories;
   }
   public  function update($id,Main_catigoriesRequest $req){

       try {
           $main = Main_categorie::find($id);
           if (!$main)
               return redirect()->route('admin.main_catigories')->with(['error' => 'حدث خطأة يرجى المحاولة فيما بعد']);

           try {
               $active = $req->categories[$req->tran]['active'];
           } catch (\Exception $ex) {
               $active = 0;
           }
           if($req->has('photo')){
               $image = saveImage($req->photo, 'admin/image/upload/main_categories');
               $main->photo=$image;
           }

           $main->name = $req->categories[$req->tran]['name'];
           $main->active = $active;
           $main->save();

           return redirect()->route('admin.main_catigories')->with(['success' => 'تم التعديل بنجاح']);
       }catch (\Exception $ex){
           return redirect()->route('admin.main_catigories')->with(['error' => 'حدث خطأة يرجى المحاولة فيما بعد']);
       }
   }
   public function delete($id){
       $categorie=Main_categorie::find($id);

       if(!$categorie)
           return redirect()->route('admin.main_catigories')->with(['error' => 'هذا القسم غير موجود']);
       $vendors=Vendor::where('categorie_id',$id);
       if(isset($vendors)&&$vendors->count()>0)
           return redirect()->route('admin.main_catigories')->with(['error' => 'هذا القسم لا يمكنك حذفة لوجود تجار به']);
       $photo= $categorie->photo;

       $photo=str::after($photo,'admin');
       $photo= base_path('public\admin\\'.$photo);
       unlink($photo);
       $categorie->delete();
       return redirect()->route('admin.main_catigories')->with(['success' => 'تم الحذف بنجاح']);

   }
}

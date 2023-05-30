<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
  public function index(){
    //PAGINATION_COUNT
    $lang=Language::paginate(10);
    return view('admin.languages.index',compact('lang'));
  }
  public function get_add(){
      return view('admin.languages.addlanguage');
  }
  public function store(LanguageRequest $req){
      try {
          $l=new Language();
          $l->name=$req->name;
          $l->abbr=$req->abbr;
          $l->direction=$req->direction;
          $l->active=$req->status;
          $l->save();
          return redirect()->route('admin.languages')->with(['success'=>'تم االحفظ بنجاح']);
      }
      catch (\Exception $ex){
          return redirect()->route('admin.languages')->with(['error'=>'يرجى المحاولة فيما بعد']);
      }


  }
  public function edit($id){
      $language=Language::find($id);
      return view('admin.languages.edit',compact('language'));
  }
    public function  update(LanguageRequest $req,$id){
      try {
        $l = Language::find($id);
        $l->name = $req->name;
        $l->abbr = $req->abbr;
        $l->direction = $req->direction;
        $l->active = $req->status;
        $l->save();
        return redirect()->route('admin.languages')->with(['success' => 'تم التعديل بنجاح']);
        }
        catch(\Exception $ex){
            return redirect()->route('admin.languages')->with(['error'=>'يرجى المحاولة فيما بعد']);
        }
      }
    public function  delete($id){
        try {
            $l = Language::where('id', $id)->delete();
            return redirect()->route('admin.languages')->with(['success' => 'تم الحذف بنجاح']);
        }
        catch (\Exception $ex){
            return redirect()->route('admin.languages')->with(['error'=>'يرجى المحاولة فيما بعد']);
        }
        }
}

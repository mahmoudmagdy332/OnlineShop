<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VendorRequest;
use App\Models\Main_categorie;
use App\Models\Vendor;
use App\Notifications\VendorCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class VendorController extends Controller
{
    public function index(){
     $vendors= Vendor::all();
     return view('admin.vendors.index',compact('vendors'));
    }
    public function get_add(){
        $categories=Main_categorie::select('name')->where('translation_lang',get_default_lang())->active()->get();

     return view('admin.vendors.add',compact('categories'));
    }
    public function store(VendorRequest $req){
        try {
            if ($req->has('status'))
                $status = 1;
            else
                $status = 0;
            $image = saveImage($req->logo, 'admin/image/upload/vendors');
            $categorie = Main_categorie::where('name', $req->catigories)->first();
            $vendor = Vendor::create([
                'name' => $req->name,
                'mobile' => $req->mobile,
                'email' => $req->email,
                'password' => $req->password,
                'status' => $status,
                'address' => $req->address,
                'logo' => $image,
                'categorie_id' => $categorie->id
            ]);

            Notification::send($vendor, new VendorCreated($vendor));
            return redirect()->route('admin.vendors')->with(['success' => 'تم االحفظ بنجاح']);
        }catch (\Exception $ex){
            return redirect()->route('admin.vendors')->with(['error'=>'حدث خطأ يرجى المحاولة فيما بعد']);
        }


    }
    public  function edit($id){
        $categories=Main_categorie::select('name')->where('translation_lang',get_default_lang())->active()->get();
        $vendor = Vendor::find($id);
     return view('admin.vendors.edit',compact('categories','vendor'));
    }
    public  function update($id,VendorRequest $req){
        try {
            if ($req->has('status'))
                $status = 1;
            else
                $status = 0;
            DB::beginTransaction();
            $vendor=Vendor::find($id);
            $categorie=Main_categorie::where('name',$req->catigories)->first();
            if($req->has('logo')){
                $image = saveImage($req->logo, 'admin/image/upload/vendors');
                $vendor->logo=$image;
            }
            if($req->password!=null){
                $vendor->password=$req->password;
            }
            $vendor->name=$req->name;
            $vendor->mobile=$req->mobile;
            $vendor->email=$req->email;
            $vendor->status=$status;
            $vendor->address=$req->address;
            $vendor->categorie_id=$categorie->id;
            $vendor->save();


            DB::commit();
            return redirect()->route('admin.vendors')->with(['success'=>'تم التعديل بنجاح']);
        }catch (\Exception $ex){
            DB::rollBack();

            return redirect()->route('admin.vendors')->with(['error'=>'حدث خطأ يرجى المحاولة فيما بعد']);
        }
    }
    public  function delete($id){

    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    //
    public $SuccessCode = 200;
    public $errorCode = 401;
    public function index()
    {
        $permission=DB::table('permissions')->get(['id','name'])->toArray();
        if ($permission){
            return response()->json(['success' => $permission], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }

    }

    public function create()
    {
//        $http_path=config('variable.http_path');
//        return response()->json(['success' => $http_path], $this->SuccessCode);

    }

    public function store(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
        $addpermiss=DB::table('permissions')->insert(['name'=>$request['name'],'http_path'=>$request['http_path'],'created_at'=>$time]);
        if ($addpermiss){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }

    public function edit(Request $request)
    {
        $permission=DB::table('permissions')->where('id',$request['id'])->first();
        if ($permission){
            return response()->json(['success' => $permission], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }

    }

    public function update(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
        $uppermiss=DB::table('permissions')->where('id',$request['id'])->update(['name'=>$request['name'],'http_path'=>$request['http_path'],'updated_at'=>$time]);
        if ($uppermiss){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }
    }

    public function destroy(Request $request)
    {
        $delete=DB::table('permissions')->where('id',$request['id'])->delete();
        if ($delete){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }
}

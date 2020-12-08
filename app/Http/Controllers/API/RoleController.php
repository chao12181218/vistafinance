<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //
    public $SuccessCode = 200;
    public $errorCode = 401;
    public function index()
    {
        $role=DB::table('roles as a')
            ->get(['a.id','a.name'])
            ->toArray();
        $data=[];
        foreach ($role as $r=>$value){
            $role_permission=DB::table('role_permissions as a')
                ->leftJoin('permissions as b','a.permission_id','=','b.id')
                ->where('a.role_id',$value->id)
                ->get(['b.name'])->toArray();
            $role_permissionstring=implode(',',array_column($role_permission,'name'));
            $data[$r]['id']=$value->id;
            $data[$r]['rolename']=$value->name;
            $data[$r]['permission']=$role_permissionstring;
        }
        if ($role){
            return response()->json(['success' => $data], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }

    }

    public function create()
    {
        $permission=DB::table('permissions')->get(['id as permissid','name as permissname'])->toArray();
        if ($permission){
            return response()->json(['success' => $permission], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }

    }

    public function store(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
        $addrole=DB::table('roles')->insertGetId(['name'=>$request['name'],'created_at'=>$time]);
        $addrolepermiss=DB::table('role_permissions')->insert(['role_id'=>$addrole,'permission_id'=>$request['permissid']]);
        if ($addrole and $addrolepermiss){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }

    public function edit(Request $request)
    {
        $role=DB::table('roles')->where('id',$request['id'])->first();
        $rolepermiss=DB::table('role_permissions as a')
            ->leftJoin('permissions as b','a.permission_id','=','b.id')
            ->where('a.role_id',$request['id'])
            ->get(['b.id as permissid','b.name as permissname'])->toArray();
        $data=['id'=>$request['id'],'name'=>$role->name,'role_permission'=>$rolepermiss];
        if ($role){
            return response()->json(['success' => $data], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }

    }

    public function update(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
        $updaterole=DB::table('roles')->where('id',$request['id'])->update(['name',$request['rolename'],'updated_at'=>$time]);
        $updateroleper=DB::table('role_permissions')->where('role_id',$request['id'])->delete();
        $addrolepermiss=DB::table('role_permissions')->insert(['role_id'=>$request['id'],'permission_id'=>$request['permissid']]);
        if ($updaterole and $updateroleper and $addrolepermiss){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }
    }

    public function destroy(Request $request)
    {
        $role=DB::table('roles')->where('id',$request['id'])->delete();
        $roleper=DB::table('role_permissions')->where('role_id',$request['id'])->delete();
        if ($role and $roleper){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }
    }
}

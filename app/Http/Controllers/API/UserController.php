<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public $SuccessCode = 200;

    public function login(){
        if (Auth::attempt(['name' => request('name'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken(request('name').'logintoken')->accessToken;
            return Response()->json(['success' => $success], $this->SuccessCode);
        }
        else {
            return Response()->json(['error' => '授权失败'], 401);
        }
    }

    //获取用户信息
    public function usermessage(Request $request){
        $user = Auth::user();
        $role=DB::table('role_users as a')
            ->leftJoin('roles as b','a.role_id','=','b.id')
            ->where('a.user_id',$user->id)
            ->get(['b.name'])->toArray();
        $rolename=array_column($role,'name');
        $permiss1=DB::table('permissions as a')
            ->leftJoin('role_permissions as b','a.id','=','b.permission_id')
            ->leftJoin('roles as c','b.role_id','=','c.id')
            ->leftJoin('role_users as d','d.role_id','=','c.id')
            ->leftJoin('users as e','d.user_id','=','e.id')
            ->where('e.id',$user->id)
            ->get(['a.id as permissid'])->toArray();
        $permiss=array_unique(array_column($permiss1,'permissid'));
        $permissdata1= array_column(DB::table('permissions')->whereIn('id',$permiss)->get(['http_path'])->toArray(),'http_path');
        $res="";
        $count=count($permissdata1);
        for ($i=0;$i<$count;$i++){
            $res.=$permissdata1[$i];
        }
        $permissdata2=array_unique(array_values(array_filter(explode('/',$res))));
//    $count=count($permissdata1);
//    for($i=0;$i<$count;$i++){
//            $res .= $data[$i];
//    }

//        $permissdata2=[];
//        foreach (array_column($permissdata1,'http_path') as $p){
//            $permissdata2[]=explode(',',$p);
//        }
        $data=['name'=>$user->name,'nickname'=>$user->nickname,'rolename'=>$rolename,'permiss'=>$permissdata2];
        return Response()->json(['success'=>$data],$this->SuccessCode);
    }
}

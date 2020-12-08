<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public $SuccessCode = 200;
    public $errorCode = 401;
    public function index()
    {
        $user=Auth::user();
        $role=DB::table('role_users as a')
            ->leftJoin('roles as b','a.role_id','=','b.id')
            ->where('a.user_id',$user->id)
            ->get(['b.name as rolename'])->toArray();
        $rolename=implode(',',array_column($role,'rolename'));
        $data=['nickname'=>$user->nickname,'name'=>$user->name,'rolename'=>$rolename];
        return response()->json(['success'=>$data],$this->SuccessCode);
    }

    public function create()
    {
        $role=DB::table('roles')->get(['id as roleid','name as rolename'])->toArray();
        if ($role){
            return response()->json(['success' =>$role],$this->SuccessCode);
        }else{
            return response()->json(['success' =>[]],$this->errorCode);
        }
    }

    public function store(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'nickname' => 'required',
            'password' => 'required',
            'role' => 'required',
            'passwords' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return Response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->except('role');
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $create_role_user=DB::table('role_users')->insert(['role_id'=>$request['role'],'user_id'=>$user->id,'created_at'=>$time]);
        $success['token'] = $user->createToken($input['name'].'registertoken')->accessToken;
        $success['name'] = $user->name;
        return Response()->json(['success' => $success], $this->SuccessCode);
    }

    public function edit(Request $request)
    {
        $user=DB::table('users as a')
            ->leftjoin('role_users as b','a.id','=','b.user_id')
            ->leftJoin('roles as c','b.role_id','=','c.id')
            ->where('a.id',$request['id'])
            ->get(['a.id','a.name','a.nickname','b.role_id','c.name as rolename'])->toArray();
        if ($user){
            return response()->json(['success' => $user], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }
    }

    public function update(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
       $updateuser=DB::table('users')->where('id',$request['id'])->update(['name'=>$request['name'],'nickname'=>$request['nickname'],'updated_at'=>$time]);
       $updaterole=DB::table('role_users')->where('user_id',$request['id'])->update(['role_id'=>$request['role_id'],'created_at'=>$time]);
       if ($updateuser and $updaterole){
           return response()->json(['success' => 'success'], $this->SuccessCode);
       }else{
           return response()->json(['success' => 'false'], $this->errorCode);
       }
    }

    public function destroy(Request $request)
    {
        $deluser=DB::table('users')->where('id',$request['id'])->delete();
        $delrole=DB::table('role_users')->where('user_id',$request['id'])->delete();
        if ($deluser and $delrole){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' => 'false'], $this->errorCode);
        }

    }
}

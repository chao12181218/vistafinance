<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public $SuccessCode = 200;
    public function login(){
        if (Auth::attempt(['name' => request('name'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return Response()->json(['success' => $success], $this->SuccessCode);
        }
        else {
            return Response()->json(['error' => '授权失败'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'passwords' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return Response()->json(['error' => $validator->errors()], 401);
        }

        // 这里根据自己表结构修改
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['avatar'] = '/images/avatars/default.jpg';
        $input['emailverfiy_token'] = '';
        $input['state'] = 1;
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return Response()->json(['success' => $success], $this->SuccessCode);
    }

    //获取用户信息
    public function user(Request $request){
        $user = Auth::user();
        return Response()->json(['success'=>$user],$this->SuccessCode);
    }
}
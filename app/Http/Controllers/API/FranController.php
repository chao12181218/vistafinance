<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FranController extends Controller
{
    //
    public $SuccessCode = 200;
    public $errorCode = 401;
    public function index()
    {
        $fran=DB::table('frans')->get()->toArray();
        if ($fran){
            return response()->json(['success' => $fran], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
        $addfran=DB::table('frans')->insert(['fran_school'=>$request['fran_school'],'fran_manage'=>$request['fran_manage'],'created_at'=>$time]);
        if ($addfran){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }

    public function edit(Request $request)
    {
        $fran=DB::table('frans')->where('id',$request['id'])->first();
        if ($fran){
            return response()->json(['success' => $fran], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }

    }

    public function update(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
        $upfran=DB::table('frans')->where('id',$request['id'])->update(['fran_school'=>$request['fran_school'],'fran_manage'=>$request['fran_manage'],'updated_at'=>$time]);
        if ($upfran){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }

    public function destroy(Request $request)
    {
        $delfran=DB::table('frans')->where('id',$request['id'])->delete();
        if ($delfran){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }
}

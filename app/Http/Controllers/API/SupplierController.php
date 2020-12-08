<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    //
    public $SuccessCode = 200;
    public $errorCode = 401;
    public function index()
    {
        $supplier=DB::table('suppliers')->get()->toArray();
        if ($supplier){
            return response()->json(['success' => $supplier], $this->SuccessCode);
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
        $addsup=DB::table('suppliers')->insert(['sup_name'=>$request['sup_name'],'sup_phone'=>$request['sup_phone'],'created_at'=>$time]);
        if ($addsup){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }

    public function edit(Request $request)
    {
        $supplier=DB::table('suppliers')->where('id',$request['id'])->first();
        if ($supplier){
            return response()->json(['success' => $supplier], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }

    }

    public function update(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
        $upsup=DB::table('suppliers')->where('id',$request['id'])->update(['sup_name'=>$request['sup_name'],'sup_phone'=>$request['sup_phone'],'updated_at'=>$time]);
        if ($upsup){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }

    public function destroy(Request $request)
    {
        $delsup=DB::table('suppliers')->where('id',$request['id'])->delete();
        if ($delsup){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }
}

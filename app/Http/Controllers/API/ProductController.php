<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //
    public $SuccessCode = 200;
    public $errorCode = 401;
    public function index()
    {
        $product=DB::table('products')->get()->toArray();
        if ($product){
            return response()->json(['success' => $product], $this->SuccessCode);
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
        $addproduct=DB::table('products')->insert(['product_code'=>$request['product_code'],'product_name'=>$request['product_name'],
            'product_spec'=>$request['product_spec'],'product_unit'=>$request['product_unit'],'product_price'=>$request['product_price'], 'created_at'=>$time]);
        if ($addproduct){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }

    public function edit(Request $request)
    {
        $product=DB::table('products')->where('id',$request['id'])->first();
        if ($product){
            return response()->json(['success' => $product], $this->SuccessCode);
        }else{
            return response()->json(['success' =>[]], $this->errorCode);
        }

    }

    public function update(Request $request)
    {
        $time=date('Y-m-d H:i:s',time());
        $upproduct=DB::table('products')->where('id',$request['id'])->update(['product_name'=>$request['product_name'],'product_spec'=>$request['product_spec'],
            'product_unit'=>$request['product_unit'],'product_price'=>$request['product_price'],'updated_at'=>$time]);
        if ($upproduct){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }

    public function destroy(Request $request)
    {
        $delproduct=DB::table('products')->where('id',$request['id'])->delete();
        if ($delproduct){
            return response()->json(['success' => 'success'], $this->SuccessCode);
        }else{
            return response()->json(['success' =>'false'], $this->errorCode);
        }

    }
}

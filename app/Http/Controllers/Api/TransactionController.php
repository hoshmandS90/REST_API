<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\transaction;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\StoreTransactionRequest;
use Illuminate\support\Carbon;
use Illuminate\Http\Response;
class TransactionController extends Controller
{
  
    public function index()
    {
        $transaction =TransactionResource::collection(transaction::with('category')->get());
        return $transaction;
    }

  
    public function store(StoreTransactionRequest $request)
    {
         $transaction=Auth()->user()->transactions()->create($request->validated()+['user_id'=>\Auth::user()->id]);
            return new TransactionResource($transaction);
    }

 
    public function show($id)
    {
        $category = transaction::FindOrFail($id);
        if(!$category){
          return response()->json(['message'=>'Category not found'],404);
        }
        return new TransactionResource($category);
    }

   
    public function update(StoreTransactionRequest $request, transaction $transaction)
    {
        $transaction->update($request->validated());
        return new TransactionResource($transaction);
    }

    public function destroy(transaction $transaction)
    {
        $transaction->delete();
        return response()->json(['message'=>'Transaction deleted successfully'],200);
    }
}

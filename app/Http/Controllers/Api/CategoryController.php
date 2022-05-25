<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Response;
use App\Models\User;
class CategoryController extends Controller
{
   
    public function index()
    {
        $categories =CategoryResource::collection(Category::select('id', 'name')->get());
        return $categories;

    }

  



    
    public function store(StoreCategoryRequest $request)
    {
         $category=Auth()->user()->categories()->create($request->validated()+['user_id'=>\Auth::user()->id]);
         return new categoryResource($category);
    }

 
    public function show($id)
    {
        $category = Category::FindOrFail($id);
        if(!$category){
          return response()->json(['message'=>'Category not found'],404);
        }
        return new CategoryResource($category);
    }

 
    public function update(StoreCategoryRequest $request, Category $category)
    {
        
        $category->update($request->validated());
        return new CategoryResource($category);
    }

  
    public function destroy(Category $category)
    {
    
        $category->delete();
        return response()->json(['message'=>'Category deleted successfully'],200);
    }
}

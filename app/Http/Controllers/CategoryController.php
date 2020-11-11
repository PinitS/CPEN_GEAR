<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function getCategories()
    {
        $categories = Category::all();
        return response()->json(['status' => true , 'categories' => $categories]);
    }
    public function getCategory($id)
    {
        $category = Category::find($id);
        return response()->json(['status' => true , 'category' => $category]);
    }
    public function getDropdownCategory($id)
    {
        $category = Category::where('type',$id)->get();
        return response()->json(['status' => true , 'categories' => $category]);
    }
    public function create(Request $request)
    {
        $item = new Category;
        $item->type = $request->input('type');
        $item->name = $request->input('name');
        $item->delete_active = 0;
        if($item->save()){
            return response()->json(['status' => true]);
        }
        else{
            return response()->json(['status' => false]);
        }
    }
    public function update(Request $request , $id)
    {
        $item = Category::find($id);
        $item->type = $request->input('type');
        $item->name = $request->input('name');
        if($item->save()){
            return response()->json(['status' => true]);
        }
        else{
            return response()->json(['status' => false]);
        }
    }
    public function delete($id)
    {
        $item = Category::find($id);
        if($item->delete_active == 1){
            return response()->json(['status' => false]);
        }
        else{
            $item->delete();
            return response()->json(['status' => true]);
        }
    }
    //
}

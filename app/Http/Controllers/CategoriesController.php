<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;

class CategoriesController extends Controller
{
    public function createCategory(Request $request)
    {
        $category = new Categories();
        $category->parent_category = $request->input('parent_category');
        $category->category_name = $request->input('category_name');
        $category->description = $request->input('description');
        $image = $request->icon->store('public/category_icon');
        $category->icon = $request->icon->hashName();
        // $category['picture'][]=[
        //     $request->input('picture')
        //     ];
        $category->status = $request->input('status');
        $category->save();
        return response()->json(['category'=>$category,'msg'=>'category created successfully!!']);
    }

    public function getAllCategories()
    {
        //if(Categories::where('status' => '10'))
        $category = Categories::where('status','!=','10')->get();  
        return response()->json($category);
    }

    public function getParentCategory()
    {
        $category = Categories::where([['parent_category','=', NULL],['status','!=','10']])->get();  
        return response()->json($category);
    }

    public function getCategoryById($parentId)
    {
        $category = Categories::where([['parent_category','=',$parentId],['status','!=','10']])->get();  
        $response = !$category->isEmpty() ? ['category'=>$category] : ["error"=> "Category Not found",'msg'=>'Category Not Found!!']; 
        return response()->json($response);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Categories::find($id);
        if($category){
            $category->category_name = $request->input('category_name');
            $category->description = $request->input('description');
            $category->status = $request->input('status');
            $icon[] = $request->icon;
            $this->storeIcon($icon,$id);
            // $picture[] = $request->picture;
            // $this->storeImage($picture,$id);
            // $image = $request->icon->store('public/category_icon');
            // $category->icon = $request->icon->hashName();
            // $image = $request->picture->store('public/category_img');
            // $category->picture = $request->picture->hashName();
            
            $category->save();
            $response = ['category'=>$category,'msg'=>'category Updated successfully!!'];
        } else {
            $response = ["error"=> "category Not found",'msg'=>'category Not Found!!'];
        }
        
        return response()->json($response);
    }
    
    public function deleteCategory($id)
    {
        $category = Categories::where('id','=',$id)->update(['status'=>'10']);
        $response = $category ? ['category'=>$category,'msg'=>'Category deleted successfully!!'] : ["error"=> "Category Not found",'msg'=>'Category Not Found!!'];
        return response()->json($response);
    }

    public function storeIcon($icon,$id)
    {
    // if(!$request->hasFile('image')) {
    //     return response()->json(['upload_file_not_found'], 400);
    // }
 
    $allowedfileExtension=['jpg','png'];
    $files = $icon; 
    $errors = [];
 
        foreach ($files as $file) {     
            $extension = $file->getClientOriginalExtension();
            $check = in_array($extension,$allowedfileExtension);
    
            if($check) {
                foreach($icon as $mediaFiles) {
    
                    $path = $mediaFiles->store('public/category_icon');
                    $name = $mediaFiles->getClientOriginalName();
        
                    //store image file into directory and db
                    $category = Categories::find($id);
                    $category->icon = $name;
                    // $save->path = $path;
                    $save->save();
                }
            } else {
                return response()->json(['invalid_file_format'], 422);
            }
    
            return response()->json(['file_uploaded'], 200);
    
        }
    }
}

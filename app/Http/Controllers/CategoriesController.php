<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\User;
use Storage;
use Illuminate\Support\Facades\File;

class CategoriesController extends Controller
{
    public function createCategory(Request $request)
    {
        $category = new Categories();
        $category->parent_category = $request->input('parent_category');
        $category->category_name = $request->input('category_name');
        $category->description = $request->input('description');
        $category->status = $request->input('status');

        $file = $request->file('icon');
        $destinationPath = "public/assets/img/category_icons/";
        $pic = $file->hashName();
        //$filename = 'https://shambhoo-app-pfm6i.ondigitalocean.app/storage/category_icon/'.$file->hashname();
        Storage::putFileAs($destinationPath, $file, $pic);
        $category->icon = $pic;
        
        $category->save();
        return response()->json(['category'=>$category,'msg'=>'category created successfully!!']);
    }

    public function getAllCategories()
    {
        //if(Categories::where('status' => '10'))
        $category = Categories::where('status','!=','10')->get();  
        return response()->json($category);
    }

    public function getParentCategory(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $category = Categories::where([['parent_category','=', NULL],['status','!=','10']])->get();
            if($category){
                $response = response()->json($category,200);
            }  
            else{
                $response = response()->json(['msg'=>'category not found'],403);
            }
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
       
    }

    public function getCategoryById(Request $request)
    {
        $header = $request->bearerToken();
        $q = User::where('id',$request->user_id)->get('token');
        if($q = $header) 
        {
            $category = Categories::where([['parent_category','=',$request->parentId],['status','!=','10']])->get(); 
            if($category){
                $response = response()->json($category,200);
            }  
            else{
                $response = response()->json(['msg'=>'category not found'],403);
            }
        }
        else
        {
            $response = response()->json(['msg'=>'Token not matched'],403);
        }
        return $response;
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
}

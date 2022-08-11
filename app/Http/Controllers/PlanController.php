<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function createPlan(Request $request)
    {
        $plan = new Plan();
        $plan->plan_type = $request->input('plan_type');
        $plan->cost = $request->input('cost');
        $plan->limitations = $request->input('limitations');
        $plan->duration = $request->input('duration');
        $plan->description = $request->input('description');
    
        $plan->save();
        return response()->json(['plan'=>$plan,'msg'=>'plan created successfully!!']);
    }

    public function getAllPlans()
    {
        $plan = Plan::all();  
        return response()->json($plan);
    }

    public function updatePlan(Request $request, $id)
    {
        $plan = Plan::find($id);
        if($plan){
            $plan->plan_type = $request->input('plan_type');
            $plan->cost = $request->input('cost');
            $plan->limitations = $request->input('limitations');
            $plan->duration = $request->input('duration');
            $plan->description = $request->input('description');
            
            $plan->save();
            $response = ['plan'=>$plan,'msg'=>'plan Updated successfully!!'];
        } else {
            $response = ["error"=> "plan Not found",'msg'=>'plan Not Found!!'];
        }
       
        return response()->json(['plan'=>$plan,'msg'=>'plan updated successfully!!']);
    }

    public function deletePlan($id)
    {
        $plan = Plan::where('id','=',$id)->delete();
        $response = $plan ? ['plan'=>$plan,'msg'=>'plan deleted successfully!!'] : ["error"=> "plan Not found",'msg'=>'plan Not Found!!'];
        return response()->json($response);
    }
}

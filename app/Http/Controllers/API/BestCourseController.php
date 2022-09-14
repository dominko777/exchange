<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BestCourse;
use App\Http\Resources\BestCourseResource;

class BestCourseController extends Controller
{
    public function getFiltered(Request $request) {

    	if ($request->has('s') && $request->has('r')) {
    		$courses = BestCourse::where(['send_currency' => $request->s, 'receive_currency' => $request->r])->get();
    	} elseif ($request->has('s')) {
    		$courses = BestCourse::where(['send_currency' => $request->s])->get();
    	} elseif ($request->has('r')) {
    		$courses = BestCourse::where(['receive_currency' => $request->r])->get();
    	} else {
    		$courses = BestCourse::get();
    	}      
    	
    	return BestCourseResource::collection($courses);    
    }

    public function get(Request $request, $sendCurrency, $receiveCurrency) {
    	$course = BestCourse::where(['send_currency' => $sendCurrency, 'receive_currency' => $receiveCurrency])->firstOrFail();  
    	return BestCourseResource::make($course);         
    }
}

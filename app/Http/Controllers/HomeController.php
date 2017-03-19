<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function case_choice()
    {
        
        //Auth::user()->id;
        $case_togle = 0;
        //dd(Auth::user()->id);
        $cases_available = App\Cases::where('user_id', '=', 3)->get();
        
        if($cases_available != null){
          $case_togle = 1;
          
          
        }
      
      
      return view('dashboard/case_choice', ['case_toggle'=>  $case_togle, 'cases_available' => $cases_available]); 

    }
  
    
    public function userdashboard(Request $caseid)
    {
        
        $workflows_active = 0;
        $notifications_active = null;
        //Auth::user()->id;
        $case_togle = 0;
      //  dd($caseid);
        
        $case_info = App\Cases::where('id', '=', $caseid->caseid)->first();

      
      
        $workflows_active = App\Cases::select('name','user_id')->where('user_id', '=', 3)->get();
        
      /*
        if($cases_available != null){
          $case_togle = 1;
          
          
        }*/
      
      
      return view('dashboard/userdashboard', ['case_info'=>  $case_info, 'workflows_active'=>  $workflows_active, 'notifications_active'=>  $notifications_active]); 

    }
  
    
}

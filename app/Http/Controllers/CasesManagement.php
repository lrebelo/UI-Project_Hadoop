<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use Auth;
use Carbon\Carbon;
use Laracurl;

class CasesManagement extends Controller
{
  
    public function __construct()
    {
        $this->middleware('auth');
    }
  
  
    public function case_list()
    {
        $case_togle = 0;
        //dd(Auth::user()->id);
        $cases_available = App\Cases::where('user_id', '=', 3)->get();
        
        if($cases_available != null){
          $case_togle = 1;
          
          
        }
      
      return view('cases/case_choice', ['case_toggle'=>  $case_togle, 'cases_available' => $cases_available]); 

    }
  
  
  
    public function case_dashboard($id)
    {
      
      $workflows_active = 0;
      $notifications_active = null;
      $case_togle = 0;
      //  dd($caseid);
        
      $case_info = App\Cases::where('id', '=', $id)->first();

      $workflows_active = App\Cases::select('name','user_id')->where('user_id', '=', 3)->get();
      
      $active_jobs = App\Jobs::where('case_id', $id)->where('state','!=', 'failed')->get();//whereNot('state', 'failed')->get();
      
      
   //   dd($active_jobs);
      $idcoll_tooold = collect([]);
      foreach($active_jobs as $job)
      {
        $response = Laracurl::get('HADOOP_SERVER/batches/'.$job->server_id);
        
        //dd($response);
        if($response->body == 'session not found')
        {
          
          $update_job = App\Jobs::where('id', $job->id)->update(['state' => 'error']);
          $idcoll_tooold->prepend($job->id);
          
        }else
        {
          $array = json_decode($response->body, true);
          //if($array['state'] == 'error')
          //{
            $update_job = App\Jobs::where('id', $job->id)->update(['state' => $array['state'], 'log'=>$response->body]);
            
            
            
          //}else
        }
      }
      
      $display_jobs = App\Jobs::where('case_id', $id)->whereNotIn('id',$idcoll_tooold)->get();
      $notifications_jobs = App\Jobs::where('case_id', $id)->whereIn('id',$idcoll_tooold)->orderBy('created_at', 'desc')->get();
      //dd($display_jobs);
      
      return view('cases/casedashboard', ['case_info'=>  $case_info, 'workflows_active'=>  $workflows_active, 'notifications_active'=>  $notifications_active, 'display_jobs' => $display_jobs, 'notifications_jobs'=>$notifications_jobs]); 

    }
  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_case()
    {
        //
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_user($caseid)
    {
        //
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_case($caseid)
    {
        //
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_case($caseid)
    {
        //
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function case_users($caseid)
    {
        //
    }
  
    
    
  
  
}

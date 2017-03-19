<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;

class AnalysisResultsManagement extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }
  
  
  
    public function aresults_list($caseid)
    {
          
        $case_info = App\Cases::where('id', '=', $caseid)->first();
        $aresults_list = App\Jobs::where('case_id', $caseid)->get();

      
      return view('analysisresults/analysisresults_list', ['case_info'=>  $case_info,'aresults_list'=>  $aresults_list]); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_aresult($caseid, $workflowid, $workflowsexecutionsid)
    {
        //
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function aresult_details($caseid, $workflowid, $workflowsexecutionsid, $aresultsid)
    {
        //
    }
  
  
}

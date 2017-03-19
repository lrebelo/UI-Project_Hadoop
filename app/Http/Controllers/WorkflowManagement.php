<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use Validator;
use DB;
use Laracurl;
use Storage;
use Carbon\Carbon;

class WorkflowManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workflows_list($caseid)
    {
      
        $case_info = App\Cases::where('id', '=', $caseid)->first();
        $workflow_list = App\Workflows::where('case_id', '=', $caseid)->get();
      
        
      
        return view('workflows/workflow_dashboard', ['case_info'=>  $case_info, 'workflow_list' => $workflow_list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_workflow(Request $request, $caseid)
    {
       $validator = Validator::make($request->all(), [
          'workflow_name' => 'required|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }  
      
      
        $task = new App\Workflows;
        $task->name = $request->workflow_name;
        $task->case_id = $caseid;

        $task->save();
      
        return redirect()->back();
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage_workflow($caseid, $workflowid)
    {
      
      $case_info = App\Cases::where('id', '=', $caseid)->first();
      $workflow_info = App\Workflows::where('id', '=', $workflowid)->first();
      
      $available_datasets = App\Datasets::where('case_id', '=', $caseid)->get();
      
     //dd($available_datasets);
      
      
      
      
      $workflowsdatasets_query = DB::table('workflows_datasets')
         ->join('datasets','workflows_datasets.dataset_id','=','datasets.id')
         ->join('workflows','workflows_datasets.workflow_id','=','workflows.id')
         ->select('datasets.name','workflows_datasets.id','workflows_datasets.dataset_id','workflows_datasets.workflow_id')
         ->where('workflows_datasets.workflow_id', '=',$workflowid)
         ->orderBy('workflows_datasets.workflow_id', 'desc')->get(); 
      
      
        $adatasets_query = App\Workflows::with('workflow_datasets')->get();
      
        $idcollection = collect([]);
        $datasets_available;
      
      
      
      foreach($adatasets_query as $datasets){
       
        if($datasets->workflow_datasets->all() == null){//$users_query[0]->branch_users->all() == null){
           
          //$users_available = App\User::whereNotIn('id', $idcollection)->where('usertype_ID','=' ,'3')->get();
        }else{
          $h = $datasets->workflow_datasets;
          //dd($h);
          foreach($h as $ha){
            $idcollection->prepend($ha->id);
            
          }

        }
      }
      $datasets_available = App\Datasets::whereNotIn('id', $idcollection)->where('case_id','=' ,$caseid)->get();
      
      
      //dd($workflowsdatasets_query);
      /*
      $users_for_branch_query = App\Branch_Users::with('user')->where('branch_ID','=' ,$id)->get();

        $idcollection_users = collect([]);

      //dd($users_for_branch_query);
        foreach($users_for_branch_query as $useract){
         if($useract->branch_ID == $id){
            
            $idcollection_users->prepend($useract->user_ID);

          }
        }
      
        //dd($idcollection_avai);

        $users_actv_query = App\User::where('usertype_ID','=' ,'3')->whereIn('id',$idcollection_users)->get();
      
      
      
      */
      
      
      
      
      
      return view('workflows/manage_workflow', ['case_info'=>  $case_info, 'workflow_info' => $workflow_info, 'workflowsdatasets_query' => $workflowsdatasets_query, 'datasets_available' => $datasets_available]);

    }

  
  
    public function workflow_toggle_dataset(Request $request, $caseid, $workflowid)
    {
        $task = App\Datasets::find($request->id);

        if(App\Workflows_Datasets::where('workflow_id', $workflowid)->where('id',$request->id)->first() == null){
         
            $task->workflow_datasets()->attach($workflowid);
          
        }else{
            $task->workflow_datasets()->detach($workflowid);
          
            
          
        }
      
        $task->save();
        
      
        return redirect()->back();
    }
  
  
  
    public function workflow_toggle_analytics($caseid, $workflowid)
    {
        //
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_workflow($caseid, $workflowid)
    {
        //
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workflow_details($caseid, $workflowid)
    {
        //
    }
  
    public function workflow_execute($caseid, $workflowid)
    {
      
      $commandbase = 'import os'."\n";
      
      /*LR(20160523):: just for demo, get rid off after
      */
      
      $commd1 = '/usr/local/spark/bin/spark-submit --master yarn-cluster --executor-memory 2560M ngsFiltering-semisparked.py TCR y y y y 0.0 null null null /CASE1/20160523_1.dat /CASE1/20160523_2.dat /CASE1/20160523_3.dat null null null sampleDataset';
        
      $commandbase = $commandbase .'os.system(' .$commd1 .')'."\n";
      //$commandbase = $commandbase .'os.system(' .$commd2 .')\n';

      $time = Carbon::now();
      $out= $time->format('Ymdhis'); 
      
      //dd($out);
      
      $jobfname = 'CASE1'.$out .'.py';
       
      Storage::disk('local')->put( $jobfname, $commandbase);
      //$url = Storage::url($jobfname);
      
      //dd($commandbase);
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .'CASE1/'.$jobfname .'?user.name=root&op=CREATE'; 
      $redirect = Laracurl::put($server_response);
      
      //dd($redirect);
      $file = 'http://LOCAL_STORAGE/storage/' .$jobfname; 
      $redirect_link = $redirect->headers;
      
      $filea = curl_file_create('/storage/' .$jobfname);
      $gg = array_get($redirect_link, 'Location');
      $response = Laracurl::post($gg, ['file' => $filea] );
      
      //dd($response);
      
      $file = "/CASE1/" .$jobfname;
      $args = "";//array("/" .$getdatasets->server_location ."/" .$getdatasets->name, "TCR", "y", "y", "y", "y", "0.0", "null", "null", "null", "/CASE1/output1.dat", "/CASE1/output2.dat", "/CASE1/output3.dat", "null", "null", "null", "sampleDataset");
      $name = "PROJECT UI-API pyton test";
      $ct = "application/json";

      $coll = collect(['file'=>$file,'args'=>$args, 'name'=>$name]);
      
      $a = $coll->toArray();
      $response = Laracurl::jsonPost('HADOOP_SERVER/batches', $a);
      

      if( $response->code == '201 Created'){
        
        $array = json_decode($response->body, true);
        
        $k = $response->getheaders();
        //dd($k['Server']);
        
        $task = new App\Jobs;
        $task->server_id = $array['id'];//$k['Server'];
        $task->case_id = $caseid;
        $task->state = $array['state'];

        $task->save();
        
      }
      return redirect('cases/' .$caseid);
      
      
    }
  
   
    public function workflow_execute_old($caseid, $workflowid)
    {
      
        /*LR(20160521):: all of this bellow is now deprecated, the requirements have made all these lines obsolete,
                          check the ExternalCallsController for some new commands for the execution and creation of the python scripts/
        */
      
      
        //will need to write this properly later, but right now the point is this will be hardcoded
        //first get the datsets for this execution
        
        $getdatasets = App\Datasets::where('server_file_id',16796)->first();
      
        //dd($getdatasets);
        
        //dd($file);
        
        /* Sparked ngsFiltering */
        
        //curl -X POST --data '{"file": "/CASE1/ngsFiltering-semisparked.py", "args": ["/CASE1/input.dat", "TCR", "y", "y", "y", "y", "0.0", "null", "null", "null", "/CASE1/output1.dat", "/CASE1/output2.dat", "/CASE1/output3.dat", "null", "null", "null", "sampleDataset"], "name": "Sparked ngsFiltering"}' -H "Content-Type: application/json" HADOOP_SERVER/batches  
      
        //dd($getdatasets);
        $file = "/" .$getdatasets->server_location ."/" ."ngsFiltering-semisparked.py";
        //$args = "["."/" .$getdatasets->server_location ."/" .$getdatasets->name .",TCR,y,y" ."," ."y" ."," ."y" ."," ."0.0" ."," ."null" ."," ."null" ."," ."null" ."," ."/CASE1/output_1.dat" ."," ."/CASE1/output_2.dat" ."," ."/CASE1/output_3.dat" ."," ."null" ."," ."null" ."," ."null" ."," ."sampleDataset" ."]";
        //$args = "[\"/CASE1/input.dat\", \"TCR\", \"y\", \"y\", \"y\", \"y\", \"0.0\", \"null\", \"null\", \"null\", \"/CASE1/output1.dat\", \"/CASE1/output2.dat\", \"/CASE1/output3.dat\", \"null\", \"null\", \"null\", \"sampleDataset\"]";
        //$args = "[/CASE1/input.dat, TCR, y, y, y, y, 0.0, null, null, null, /CASE1/output1.dat, /CASE1/output2.dat, /CASE1/output3.dat, null, null, null, sampleDataset]";
          
        $args = array("/" .$getdatasets->server_location ."/" .$getdatasets->name, "TCR", "y", "y", "y", "y", "0.0", "null", "null", "null", "/CASE1/output1.dat", "/CASE1/output2.dat", "/CASE1/output3.dat", "null", "null", "null", "sampleDataset");
      
      
      
      
      
      
        $name = "PROJECT UI-API ".$getdatasets->server_location;
        $ct = "application/json";

        //
      
      
        /* Sparked wordcound 
        //curl -X POST --data '{"file": "/wordcount/wc.java", "args": ["/test_sunday.txt", "/wordcount/output_test1.txt"], "name": "Wordcount"}' -H "Content-Type: application/json" HADOOP_SERVER/batches

        $file = "/wordcount/WordCount.java";
        $args = "["."/test_sunday.txt" ."," ."/wordcount/output_test_12.txt" ."]";
        $name = "Wordcount";
        $ct = "application/json";

        */
        
      
        //$args = "["."/" .$getdatasets->server_location ."/" .$getdatasets->name .",TCR,y,y" ."," ."y" ."," ."y" ."," ."0.0" ."," ."null" ."," ."null" ."," ."null" ."," ."/CASE1/output_1.dat" ."," ."/CASE1/output_2.dat" ."," ."/CASE1/output_3.dat" ."," ."null" ."," ."null" ."," ."null" ."," ."sampleDataset" ."]";

      
        
      //curl -X POST --data '{"file": "/wordcount/wc.java", "args": ["/test_sunday.txt", "/wordcount/output_test1.txt"], "name": "Wordcount"}' -H "Content-Type: application/json" HADOOP_SERVER/batches
       // $data ="{\"file\": \"/CASE1/ngsFiltering-semisparked.py\",\"args\": [\"/CASE1/input.dat\", \"TCR\", \"y\", \"y\", \"y\", \"y\", \"0.0\", \"null\", \"null\", \"null\", \"/CASE1/output1.dat\", \"/CASE1/output2.dat\", \"/CASE1/output3.dat\", \"null\", \"null\", \"null\", \"sampleDataset\"], \"name\": \"Sparked ngsFiltering\"}";
         
        $coll = collect(['file'=>$file,'args'=>$args, 'name'=>$name]);
       /* $coll->prepend(['file'=>$file]);
        $coll->prepend('args'=>$args);
      $coll->prepend('name'=>$name);*/
      
      
      $a = $coll->toArray();
      //dd(Laracurl::jsonPost('HADOOP_SERVER/batches', $a));
      $response = Laracurl::jsonPost('HADOOP_SERVER/batches', $a);
      //dd($a);
      
      //dd(Laracurl::jsonPost('HADOOP_SERVER/batches', $a));
      if( $response->code == '201 Created'){
        
        $array = json_decode($response->body, true);
        
        $k = $response->getheaders();
        //dd($k['Server']);
        
        $task = new App\Jobs;
        $task->server_id = $array['id'];//$k['Server'];
        $task->case_id = $caseid;
        $task->state = $array['state'];

        $task->save();
        
      }
      return redirect('cases/' .$caseid);
    }
  
  
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workflow_executions_list($caseid, $workflowid)
    {
        //
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workflow_execution($caseid, $workflowid, $workflowsexecutionsid)
    {
        //lrebelo : Check on the curent status of the workflow execution
    }
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function workflow_analysisblock($caseid, $workflowid, $ablockid)
    {
        //
    }
  
     
  
  
}

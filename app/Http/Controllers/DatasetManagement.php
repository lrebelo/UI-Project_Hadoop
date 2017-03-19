<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use Laracurl;

class DatasetManagement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function datasets_list($caseid)
    {
      
      $case_info = App\Cases::where('id', '=', $caseid)->first();

      $datasets_list = App\Datasets::where('case_id', '=', $caseid)->get();
      
      
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/?user.name=root&op=LISTSTATUS';
      $path_raw = Laracurl::get($server_response);
      $path_list = json_decode($path_raw, true);
      
      
      return view('datasets/datasets_list', ['case_info'=>  $case_info, 'datasets_list'=>  $datasets_list, 'path_list' => $path_list]);    
    }
  
  
  
  
    public function server_ls($caseid)
    {
      
      $case_info = App\Cases::where('id', '=', $caseid)->first();

      //$datasets_list = App\Datasets::where('case_id', '=', $caseid)->get();
      
      //$case_info->server_location
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/CASE1/?user.name=root&op=LISTSTATUS';
      $path_raw = Laracurl::get($server_response);
      $path_list = json_decode($path_raw, true);
      
      $plist = $path_list['FileStatuses'];
      
      //dd($plist['FileStatus']);
      return view('datasets/add_dataset', ['case_info'=>  $case_info, 'path_list' => $plist['FileStatus']]);    
    }

  
  
  
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_dataset(Request $request, $id)
    {
        /*LR(20160521):: The lines bellow are now incomplete, missing paramnmeter added to migration as per new requiremnets
                          some of teh necessary changes are already present in the 'ExternalCallsController' as that is the place where I have been 
                          testing all new changes comming to the system as a result of new requiremnst
        */
        $task = new App\Datasets;
        $task->name = $request->fileName;
        $task->case_id = $id;
        $task->server_file_id = $request->fileId;
        $task->server_location = $request->filePath;

        $task->save();
      
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

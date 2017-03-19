<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laracurl;

class ExternalCallsController extends Controller
{
  
    public function __construct()
    {
        //$this->middleware('auth');
    }
  
  
  
    public function test(Request $file_name)
    {
      
        //$json = json_decode(file_get_contents('http://HADOOP_SERVER/webhdfs/v1/new_file.txt?user.name=root&op=CREATE'), true);
      
      //  $file = 'test_sunday1.txt';
      
      //  $sss = 'HADOOP_SERVER/webhdfs/v1/' .$file .'?user.name=root&op=CREATE';
        //$url = Laracurl::buildUrl('http://HADOOP_SERVER/webhdfs/v1/new_file.txt?user.name=root&op=CREATE');
       // $redirect = Laracurl::put($sss);
  
        //$a = $redirect->headers;
      
        //"http://HADOOP_SERVER/webhdfs/v1/new_file.txt?op=CREATE&user.name=root&namenoderpcaddress=HADOOP_SERVER&overwrite=false"
        //dd(array_get($redirect, 'Location'));
        
        
      
        //$response = Laracurl::put(array_get($a, 'Location'));
      
      
        //$fff = json_decode($response, true);
      
        //$batches_status_raw = Laracurl::get("http://HADOOP_SERVER/webhdfs/v1/wordcount/WordCount.java?user.name=root&op=OPEN");
      //$batches_status_json = json_decode($batches_status_raw, true);
      
      /*
            $redirect_link = $batches_status_raw->headers;
      $response = Laracurl::put(array_get($redirect_link, 'Location'));
      
      */
      
      
        $server_response = 'http://HADOOP_SERVER/webhdfs/v1/?user.name=root&op=LISTSTATUS';
      $path_raw = Laracurl::get($server_response);
      $sessions_status_json = json_decode($path_raw, true);
      //return $sessions_status_json;
       dd($sessions_status_json);
    }
  
  
  
    public function create_file(Request $file_name)
    {
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .$file_name .'?user.name=root&op=CREATE';
      $redirect = Laracurl::get($server_response);
      
      $redirect_link = $redirect->headers;
      $response = Laracurl::put(array_get($redirect_link, 'Location'));
      
    }
  
    
    public function read_file(Request $file_name)
    {
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .$file_name .'?user.name=root&op=OPEN';
      $redirect = Laracurl::get($server_response);

      $redirect_link = $redirect->headers;
      $response = Laracurl::get(array_get($redirect_link, 'Location'));
      
      return $response;
      
    }
  
    
    public function send_file(Request $file_name)
    {
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .$file_name .'?user.name=root&op=CREATE';
      $redirect = Laracurl::get($server_response);
      
      
      
    }
  
    
    public function create_job()
    {
      
      $response = Laracurl::post($url, ['post' => 'data']);
      
      
    }
  
        
    public function list_directory(Request $path)
    {
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .$path->path .'?user.name=root&op=LISTSTATUS';
      $path_raw = Laracurl::get($server_response);
      dd($path_raw);
      $redirect_link = $redirect->headers;
      
      $sessions_status_json = json_decode($path_raw, true);
      
      
      return $path_raw;
    }
  
  
    public function create_batch(Request $file_name)
    {
      
      $commandbase = 'import os\n';
      
      /*LR(20160521):: $commdids works as an array and the lengh of the array becaumes the number of commands to execute with each command inside.
        LR(20160522):: 
      */
      
      foreach($commdids as $commd)
      {
        
        $commandbase = $commandbase .'os.system(' .$commd .')\n';

      }
      
      $jobfname = ''.'.py';
       
      Storage::disk('local')->put( $jobfname, $commandbase);
      $url = Storage::url($jobfname);
      
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .$file_name .'?user.name=root&op=CREATE';
      $redirect = Laracurl::put($server_response);
      
      $redirect_link = $redirect->headers;
      $response = Laracurl::put(array_get($redirect_link, 'Location'));
      
    }
  
  
  
  
  
    public function read_tools_xml(Request $file_name)
    {
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .$file_name .'?user.name=root&op=LISTSTATUS';
      $path_raw = Laracurl::get($server_response);
      $path_list = json_decode($path_raw, true);
      
      $plist = $path_list['FileStatuses'];
      
      $allfiles = $plist['FileStatus'];
      
      
      foreach($allfiles as $file)
      {
        if($file['type'] == "FILE")
        {
          
          $keyword = explode(".", $file['pathSuffix']);
          
          if($keyword[1] == "xml")
          {
            
            
            $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .$file_name .'?user.name=root&op=OPEN';
            $redirect = Laracurl::get($server_response);

            $redirect_link = $redirect->headers;

            $xml = XmlParser::load(array_get($redirect_link, 'Location'));
            $xmlfile = $xml->parse([
                'id' => [ 'uses' => 'tool::id'],
                'name' => [ 'uses' => 'tool::name'],
                'version' => [ 'uses' => 'tool::version'],
            ]);
            
            if(!($xmlfile->isEmpty()))
            {
            
              $tools = App\Tools::select('tool_id','version')->where('tool_id', '=', $xmlfile['id'])->get();
              if(!($tools->isEmpty()))
              {
                foreach($tools as $tool)
                {
                  if($xmlfile['version'] == $tool->version)
                  {
                    //do nothing as it is the correct one!  
                  }else{
                    App\Tools::where('tool_id', $xmlfile['id'])->update(['version' => $xmlfile['version'],'xml' => $xml ]); //still needs the inputs and soutputs to be saved as CSV or something

                  }
                }
              }else{
                $task = new App\Tools;
                $task->tool_id = $xmlfile['id'];
                $task->tool_name = $xmlfile['name'];
                $task->version = $xmlfile['version'];
                $task->xml = $xml;

                $task->save();

                //missing inputs and outputs

              }
            
            }
            
          }
          
          
        }
        
      }
      
      
    }
  
  
   /* For the files metaddate this si the following format
    *
    *    <Dataset>
    *      <Dataset-Type>CSV</Dataset-Type>
    *      <Dataset-Name></Dataset-Name>
    *      <Dataset-Version></Dataset-Version>
    *      <Dataset-Author></Dataset-Author>
    *      <Dataset-Lines></Dataset-Lines>
    *      <Dataset-Description></Dataset-Description>
    *      <Dataset-Licence></Dataset-Licence>
    *      <Dataset-Header></Dataset-Header>
    *    </Dataset>
    *
    *
    *
    */
  
     
    public function read_files_xml(Request $file_name)
    {
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .$file_name .'?user.name=root&op=LISTSTATUS';
      $path_raw = Laracurl::get($server_response);
      $path_list = json_decode($path_raw, true);
      
      $plist = $path_list['FileStatuses'];
      
      $allfiles = $plist['FileStatus'];
      
      
      foreach($allfiles as $file)
      {
        if($file['type'] == "FILE")
        {
          
          $keyword = explode(".", $file['pathSuffix']);
          
          if($keyword[1] == "xml")
          {
            
            
            $server_response = 'http://HADOOP_SERVER/webhdfs/v1/' .$file_name .'?user.name=root&op=OPEN';
            $redirect = Laracurl::get($server_response);

            $redirect_link = $redirect->headers;

            $xml = XmlParser::load(array_get($redirect_link, 'Location'));
            $xmlfile = $xml->parse([
                'file_type' => [ 'uses' => 'Dataset.Dataset-Type'],
                'file_name' => [ 'uses' => 'Dataset.Dataset-Name'],
                'file_version' => [ 'uses' => 'Dataset.Dataset-Version'],
                'file_author' => [ 'uses' => 'Dataset.Dataset-Author'],
                'file_lines' => [ 'uses' => 'Dataset.Dataset-Lines'],
                'file_description' => [ 'uses' => 'Dataset.Dataset-Description'],
                'file_licence' => [ 'uses' => 'Dataset.Dataset-Licence'],
                'file_header' => [ 'uses' => 'Dataset.Dataset-Header'],
            ]);
            
            if(!($xmlfile->isEmpty()))
            {
            
              /* Dataset table altared for teh benifit of these new needs
               *
                $table->increments('id');
                $table->string('name');
                $table->integer('case_id')->unsigned();
                $table->string('type');
                $table->string('version');
                $table->string('author');
                $table->integer('lines');
                $table->string('description');
                $table->string('licence');
                $table->string('header');
                $table->integer('server_file_id');
                $table->string('server_location');
                $table->timestamps();
              */
              
              
              $datasets = App\Datasets::select('name','version')->where('file_name', '=', $xmlfile['file_name'])->get();
              if(!($tools->isEmpty()))
              {
                foreach($datasets as $dataset)
                {
                  if($xmlfile['version'] == $dataset->version)
                  {
                    //do nothing as it is the correct one!  
                  }else{
                    App\Datasets::where('name', $xmlfile['file_name'])->update(['version' => $xmlfile['version'], 'type' => $xmlfile['file_type'], 'author' => $xmlfile['file_author'], 'lines' => $xmlfile['file_lines'], 'description' => $xmlfile['file_description'], 'licence' => $xmlfile['file_licence'], 'header' => $xmlfile['file_header'], 'xml' => $xml ]); 

                  }
                }
              }else{
                $task = new App\Datasets;
                $task->name = $xmlfile['id'];
                $task->type = $xmlfile['name'];
                $task->version = $xmlfile['version'];
                $table->type = $xmlfile['file_type'];
                $table->author = $xmlfile['file_author'];
                $table->lines = $xmlfile['file_lines'];
                $table->description = $xmlfile['file_description'];
                $table->licence = $xmlfile['file_licence'];
                $table->header = $xmlfile['file_header'];
                $table->server_file_id = $file['fileId'];
                $table->server_location = $file_name;
                $task->xml = $xml;

                $task->save();

              }
            
            }
            
          }
          
          
        }
        
      }
      
      
    }
  
  
  
  
  
  
  
    public function status()
    {
      
      
      //batches status
      $batches_status_raw = Laracurl::get("HADOOP_SERVER/batches");
      $batches_status_json = json_decode($batches_status_raw, true);
      
      //sessions status    
      $sessions_status_raw = Laracurl::get("HADOOP_SERVER/sessions");
      $sessions_status_json = json_decode($sessions_status_raw, true);
      
    }
  
  
  
    public function readCASE1(Request $file_name)
    {

      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/CASE1/?user.name=root&op=LISTSTATUS';
      $path_raw = Laracurl::get($server_response);
      $sessions_status_json = json_decode($path_raw, true);
      //return $sessions_status_json;
       dd($sessions_status_json);
    }
  
    public function readfile(Request $file_name)
    {

      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/CASE1/pyton_chain1.py?user.name=root&op=OPEN';
      $redirect_link = Laracurl::get($server_response);
  
      $link = $redirect_link->headers;
      $response = Laracurl::get(array_get($link, 'Location'));
      
      dd($response);

      
    }
  
    public function executecmd()
    {
      
        //$getdatasets = App\Datasets::where('server_file_id',16796)->first();

        $file = "/CASE1/" ."ngsFiltering-semisparked.py";

        $args = array("/CASE1/input.dat", "TCR", "y", "y", "y", "y", "0.0", "null", "null", "null", "/CASE1/output1.dat", "/CASE1/output2.dat", "/CASE1/output3.dat", "null", "null", "null", "sampleDataset");
      
      
      
      
      
      
        $name = "PROJECT UI-API demo!";
        $ct = "application/json";

        
        $coll = collect(['file'=>$file,'args'=>$args, 'name'=>$name]);
       
        $a = $coll->toArray();
      
        $response = Laracurl::jsonPost('HADOOP_SERVER/batches', $a);
        dd($response);
      
    }
  
  
    public function exec(){
      
      $server_response = 'http://HADOOP_SERVER/webhdfs/v1/CASE1/pyton_chain.py?user.name=root&op=CREATE';
      $redirect = Laracurl::put($server_response);
      dd($redirect);
      $redirect_link = $redirect->headers;
      
    }
  
}

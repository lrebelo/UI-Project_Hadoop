<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('user_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');          
            $table->timestamps();
                    
        });
        
      
        Schema::create('cases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id')->unsigned();
            $table->integer('dataset_id')->unsigned();
            $table->integer('visualisation_id')->unsigned();
            $table->integer('analysisresult_id')->unsigned();
            $table->string('server_location');
            $table->timestamps();
                    
        });
      
        Schema::create('workflows', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('case_id')->unsigned();
            $table->string('analysis_steps'); //maybe this can be reused as 'csv' type
            $table->string('output_tags');
            $table->string('python_batch'); //command sent over for execution.
            $table->timestamps();
                                
            //LR(20160521):: rewite for extra requirements 
        });
      
      
        Schema::create('workflows_datasets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('workflow_id')->unsigned();
            $table->integer('dataset_id')->unsigned();
            $table->integer('step'); //LR(20160521):: 
            $table->timestamps();
            //pivot table for workflowdatsets          
        });
      
      
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id');
            $table->string('state');
            $table->longText('log');
            $table->integer('case_id')->unsigned();
            $table->integer('workflow_id')->unsigned();
            $table->timestamps();
                                
        });
      
      
        Schema::create('analysisresults', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('server_id'); //not sure where to get this from.
            $table->integer('workflow_id')->unsigned();
            $table->longText('data');
            $table->binary('datab');
            $table->timestamps();
                                
        });
      
        Schema::create('datasets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('case_id')->unsigned(); // really?
            $table->string('type');
            $table->string('version');
            $table->string('author');
            $table->integer('lines');
            $table->string('description');
            $table->string('licence');
            $table->string('header');
            $table->integer('server_file_id');
            $table->string('server_location');
            $table->string('xml');
            $table->timestamps();
             //might need new table for indevidual dataset files.   For future 
          
             /* LR(20160521):: now its the future and these feacture creeping that Nada dumped on me are costing me hours of rewrites
                                In any case I belive the table now contains all that is needed for the suer interface.. (lets say for now since the requerements have changed so much in 2 weeks...)
             */
             //LR(20160522):: forgot the xml coll....
        });
      
        Schema::create('visualisations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('data_source'); //not sure where to get this from.
            $table->timestamps();
            //this need to write this from scratch as we go along
                      
        });
      
        Schema::create('analysisblocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps(); 
          
            //will need a pivot table if this needs to be for more than one case
                      
        });
      
        Schema::create('tools', function (Blueprint $table) {
            $table->increments('id'); //laravel id
            $table->string('tool_id'); //xml id
            $table->string('tool_name'); //xml name
            $table->string('version');  //xml version
            $table->string('command');  //xml command
            $table->string('input_tags'); //csv of all input tags
            $table->string('output_tags'); //csv of all output tags   
            $table->string('xml'); //xml file dump
            $table->timestamps(); 
          
            //LR(20160521):: table to hold all xml tools retrived from server
                      
        });
      
        //pivot tables bellow
        Schema::create('usercases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('case_id')->unsigned();
            $table->timestamps();
                                 
        });

      
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('cases');
        Schema::drop('workflows');
        Schema::drop('analysisresults');
        Schema::drop('datasets');
        Schema::drop('visualisations');
        Schema::drop('analysisblocks');
        Schema::drop('usercases');
        Schema::drop('user_types');
        Schema::drop('jobs');
        Schema::drop('workflows_datasets');
        Schema::drop('tools');
      
    }
}

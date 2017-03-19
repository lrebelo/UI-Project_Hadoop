<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*Route::get('/', function () {
    return view('welcome');
});

*/

Route::get('test1/', 'ExternalCallsController@readcll');
Route::get('test2/', 'ExternalCallsController@readfile');
Route::get('test3/', 'ExternalCallsController@executecmd');

Route::get('test4/', 'ExternalCallsController@exec');



//Route::get('/', 'HomeController@case_choice');


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
  
    Route::auth();
    
    Route::get('/', 'CasesManagement@case_list');
    Route::get('/home', 'CasesManagement@case_list');
  

    //routes for user management
    Route::get('user/', 'UserManagement@user_list');
    Route::put('user/adduser', 'UserManagement@add_user');
    Route::get('user/{user}', 'UserManagement@manage_user');
    Route::post('user/{user}', 'UserManagement@change_user');
    Route::delete('users/{user}', 'UserManagement@delete_user');
  
  
    //routes for case manegement 
    Route::get('cases/', 'CasesManagement@case_list');
    Route::put('cases/addcase', 'UserManagement@add_case');
    Route::get('cases/{caseid}', 'CasesManagement@case_dashboard');
    Route::post('cases/{caseid}', 'CasesManagement@change_case');
    Route::delete('cases/{caseid}', 'CasesManagement@delete_case');
    Route::get('cases/{caseid}/users', 'CasesManagement@case_users');
  
  
    //routes for case workflows 
    Route::get('cases/{caseid}/workflows', 'WorkflowManagement@workflows_list');
    Route::post('cases/{caseid}/workflows/createworkflow', 'WorkflowManagement@create_workflow');
    Route::get('cases/{caseid}/workflows/{workflowid}', 'WorkflowManagement@manage_workflow');
    Route::delete('cases/{caseid}/workflows/{workflowid}', 'WorkflowManagement@delete_workflow');
    Route::post('cases/{caseid}/workflows/{workflowid}/dataset', 'WorkflowManagement@workflow_toggle_dataset');
    Route::post('cases/{caseid}/workflows/{workflowid}/analytics', 'WorkflowManagement@workflow_toggle_analytics');
    //Route::get('cases/{caseid}/workflows/{workflowid}', 'WorkflowManagement@workflow_details'); //repeat?!
    Route::get('cases/{caseid}/workflows/{workflowid}/execute', 'WorkflowManagement@workflow_execute'); 
    Route::get('cases/{caseid}/workflows/{workflowid}/execute_old', 'WorkflowManagement@workflow_execute_old'); //for Nada presenation
        //routes for workflow exectutions
        Route::get('cases/{caseid}/workflows/{workflowid}/workflowsexecutions', 'WorkflowManagement@workflow_executions_list');
        Route::get('cases/{caseid}/workflows/{workflowid}/{workflowsexecutionsid}', 'WorkflowManagement@workflow_execution');
        Route::put('cases/{caseid}/workflows/{workflowid}/{workflowsexecutionsid}/analysisresults/createaresults', 'AnalysisResultsManagement@create_aresult');
        Route::put('cases/{caseid}/workflows/{workflowid}/{workflowsexecutionsid}/analysisresults/{aresultsid}', 'AnalysisResultsManagement@aresult_details'); //redundant?? 
    
    Route::post('cases/{caseid}/workflows/{workflowid}/{ablockid}', 'WorkflowManagement@workflow_analysisblock'); //need confirmation on purpose of this
  
  
    //routes for case analysis results 
    Route::get('cases/{caseid}/analysisresults', 'AnalysisResultsManagement@aresults_list');
    Route::get('cases/{caseid}/analysisresults/{aresultsid}', 'AnalysisResultsManagement@aresult_details'); //redundant??
    Route::post('cases/{caseid}/analysisresults/{aresultsid}', 'AnalysisResultsManagement@alter_aresult');
    //Route::put('cases/{caseid}/analysisresults/createaresults', 'AnalysisResultsManagement@create_aresult');//wrong moved to workflow exectutions

    //needinfo on the purpose of "share analysis results" Route::post('cases/{caseid}/analysisresults/{aresultsid}/shareresults', 'AnalysisResultsManagement@share_aresult');
  
  
    //routes for case datasets 
    Route::get('cases/{caseid}/datasets', 'DatasetManagement@datasets_list');
    /* Will need to undertand if the datasets are equivalent to files on the server OR just groups of files
     * for now will assume files to shorten the jorney 
     */
    Route::get('cases/{caseid}/datasets/createdataset', 'DatasetManagement@server_ls');//DatasetManagement@create_dataset
    Route::post('cases/{caseid}/datasets/createdataset', 'DatasetManagement@create_dataset');//DatasetManagement@create_dataset
    Route::get('cases/{caseid}/datasets/{datasetid}', 'DatasetManagement@dataset');
    Route::post('cases/{caseid}/datasets/{datasetid}', 'DatasetManagement@alter_dataset');
    Route::post('cases/{caseid}/datasets/{datasetid}/add', 'DatasetManagement@server_ls');//NOT in use(LR: 31st march)
    Route::delete('cases/{caseid}/datasets/{datasetid}', 'DatasetManagement@delete_dataset');
  
  
    //routes for case visualisations 
    Route::get('cases/{caseid}/visualisations', 'VisualisationManagement@visualisations_list');
    Route::put('cases/{caseid}/visualisations/create', 'VisualisationManagement@create_visualisation');
    Route::get('cases/{caseid}/visualisations/{visualisationid}', 'VisualisationManagement@visualisation_details');
    Route::post('cases/{caseid}/visualisations/{visualisationid}', 'VisualisationManagement@alter_visualisation');
  
  
    //routes for analysis blocks
    Route::get('analysisblocks/', 'AnalysisBlocksManagement@ablocks_list');
    Route::delete('analysisblocks/remove/{ablockid}', 'AnalysisBlocksManagement@delete_block');
    Route::post('analysisblocks/createblock', 'AnalysisBlocksManagement@create_block');
    Route::get('cases/{caseid}/analysisblocks/{ablockid}', 'AnalysisBlocksManagement@ablocks_bycase');
    Route::post('cases/{caseid}/analysisblocks/{ablockid}', 'AnalysisBlocksManagement@alter_ablock');
  
  
});

@extends('layouts.case_app')

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();
});
</script>

<div class="container">
    <div class="row">
      
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
            </div>
        </div>
        
        <div class="col-md-5 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Notifications</b></div>

                <table class="table task-table">
                                 

                          <!-- Table Body -->
                          <tbody>
                            @if (count($notifications_jobs) > 0)
                              @foreach($notifications_jobs as $notification)
                                <tr>
                                  <!-- Task Name -->
                                  <td class="table-text">
                                    Job {{$notification->server_id}} started at: {{$notification->created_at}} ended in: {{$notification->state}}



                                  </td>
                                </tr>  
                              @endforeach
                             @else
                            <tr>
                                  <td class="table-text">
                                     No New Notifications
                                  </td>
                                </tr>  
                            @endif
                          </tbody>
                        </table>  
 
            </div>
        </div>
      
      
      
        <div class="col-md-5">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Workflows</b></div>             
                    

                      <table class="table task-table">
                                 

                          <!-- Table Body -->
                          <tbody>
                            @foreach($display_jobs as $job)
                              <tr>
                                <!-- Task Name -->
                                <td class="table-text">
                                    
                                  <div>Workflow {{$job->server_id}}</div><!-- workflow_id -->
                                  <div class="progress">
                                    @if($job->state == 'error')
                                    <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                      <span class="sr-only"></span>
                                      ERROR: Job failed!
                                    </div>
                                  </div>
                                  <button type="button" class="btn btn-xs btn-info" data-toggle="popover" title="Server Error Message" data-content="{{$job->log}}">Details</button>
                                  

                                  @elseif($job->state == 'running')
                                  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                      <span class="sr-only"></span>
                                      Job in Progress
                                    </div>
                                  </div>
                                  @elseif($job->state == 'finished')
                                  <div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                      <span class="sr-only"></span>
                                      Job in Finished
                                    </div>
                                  </div>
                                  <button type="button" class="btn btn-xs btn-info" data-toggle="popover" title="Server Message" data-content="{{$job->log}}">Details</button>

                                  @else
                                    <div class="progress-bar progress-bar-default progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                      <span class="sr-only"></span>
                                      Unknown 
                                    </div>
                                  </div>
                            
                                @endif
                                  
                                  
                                </td>
                              </tr>  
                            @endforeach
                          </tbody>
                        </table>  

            </div>
        </div>
    </div>
</div>
@endsection
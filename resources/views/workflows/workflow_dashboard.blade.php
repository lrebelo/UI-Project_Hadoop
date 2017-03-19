@extends('layouts.case_app')

@section('content')
<div class="container">
    <div class="row">
      
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Workflows for '{{ $case_info->name }}'</div>
                <div class="panel-body">
                  <table class="table">
                      <tbody>
                        <tr>
                          <form action="/cases/{{$case_info->id}}/workflows/createworkflow" method="POST">
                            {{ csrf_field() }}
                            
                            <div class="form-group{{ $errors->has('branch_name') ? ' has-error' : '' }}">
                            <input type="text" class="form-control" name="workflow_name" placeholder="Workflow name">
                            
                              @if ($errors->has('workflow_name'))
                                  <span class="help-block">
                                      <strong>{{ $errors->first('workflow_name') }}</strong>
                                  </span>
                              @endif
                              
                              <button class="btn btn-info btn-sm">Create Workflow</button>
                            </div>
                              
                          </form>
                        </tr>
                      </tbody>
                    </table>
   
                </div>
            </div>
        </div>
        
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Workflows</b></div>
      
                <table class="table task-table">
                 @if (count($workflow_list) > 0)
                 
                    <!-- Table Body -->
                    <tbody>

                        @foreach($workflow_list as $workflow)
                          <tr>
                              <!-- File Name -->
                              <td class="table-text">
                                  {{$workflow->name}}
                              </td>
  
                            
                              <td class="table-text">
                                  <a href="/cases/{{$case_info->id}}/workflows/{{$workflow->id}}" class="btn btn-default btn-lg center-block" role="button">Manage Workflow</a>
                              </td>
                            
                              
                          </tr>  
                        @endforeach
                       @else
                      <tr>
                            <td class="table-text">
                               No Workflows
                            </td>
                          </tr>  

                    </tbody>
                  @endif
                  </table>  
            </div>
        </div> 
    </div>
</div>
@endsection
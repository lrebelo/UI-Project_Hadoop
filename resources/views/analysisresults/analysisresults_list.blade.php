@extends('layouts.case_app')

@section('content')
<div class="container">
    <div class="row">
      
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Case '{{ $case_info->name }}' Analysis Results</div>
            </div>
        </div>
        
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Analysis Results</b></div>

                <table class="table task-table">
                          
                        <thead>
                          <th>Job ID</th>
                          <th>Server Batch ID</th>
                          <th>Log</th>
                          <th>Result</th>
                          <th>&nbsp;</th>
                        </thead>

                          <!-- Table Body -->
                          <tbody>
                            @if (count($aresults_list) > 0)
                              @foreach($aresults_list as $results)
                                <tr>
                                  <!-- Task Name -->
                                  <td class="table-text">
                                    {{$results->id}}
                                  </td>
                                  <td class="table-text">
                                    {{$results->server_id}}

                                    
                                    
                                    
                                  </td>
                                  <td class="table-text">
                                    
                                    -
                                    
                                  </td>
                                  
                                  <td class="table-text">
                                                                        
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalData{{$results->id}}">
                                      Data
                                    </button>
                                                                        
                                    <!-- Modal -->
                                    <div class="modal fade" id="modalData{{$results->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Data Output</h4>
                                          </div>
                                          <div class="modal-body">
                                            {{$results->log}}
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  
                                </tr>  
                              @endforeach
                             @else
                            <tr>
                                  <td class="table-text">
                                     No Datasets
                                  </td>
                                </tr>  
                            @endif
                          </tbody>
                        </table>  
 
            </div>
        </div>
      
      
      
        
    </div>
</div>
@endsection
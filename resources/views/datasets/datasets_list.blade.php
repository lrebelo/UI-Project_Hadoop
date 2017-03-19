@extends('layouts.case_app')

@section('content')
<div class="container">
    <div class="row">
      
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Case '{{ $case_info->name }}' Datasets</div>
                <div class="panel-body">
                
                                
                  <a href="/cases/{{$case_info->id}}/datasets/createdataset" class="btn btn-default btn-lg center-block" role="button">Add Dataset</a>

                </div>
            </div>
        </div>
        
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Available Datasets</b></div>
      
                <table class="table task-table">
                 @if (count($datasets_list) > 0)
                  
                      <thead>
                        <th>File Name</th>
                        <th>File ID</th>
                        <th>&nbsp;</th>
                    </thead>

                          <!-- Table Body -->
                          <tbody>
                            
                              @foreach($datasets_list as $datasets)
                                <tr>
                                    <!-- File Name -->
                                    <td class="table-text">
                                        {{$datasets->name}}
                                    </td>
                                    
                                    <!-- File ID -->
                                    <td class="table-text">
                                        {{$datasets->server_file_id}}
                                    </td>
                                </tr>  
                              @endforeach
                             @else
                            <tr>
                                  <td class="table-text">
                                     No Datasets
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
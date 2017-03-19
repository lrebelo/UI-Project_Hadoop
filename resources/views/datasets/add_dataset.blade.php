@extends('layouts.case_app')

@section('content')
<div class="container">
    <div class="row">
      
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Case '{{ $case_info->name }}' Datasets</div>
            </div>
        </div>
        
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Datasets in {{ $case_info->name }} path</b></div>

                <table class="table task-table">
                                 
                  <thead>
                      <th>File Name</th>
                      <th>File ID</th>
                      
                      <th>&nbsp;</th>
                  </thead>

                          <!-- Table Body -->
                          <tbody>
                            @if (count($path_list) > 0)
                              @foreach($path_list as $list)
                         
                               
                                  
                                  <tr>
                                    <!-- File Name -->
                                    <td class="table-text">
                                        {{$list['pathSuffix']}}
                                    </td>
                                    
                                    <!-- File ID -->
                                    <td class="table-text">
                                        {{$list['fileId']}}
                                    </td>
                                    
                                    
                                    <td class="table-text">
                                       
                                      
                                      <form class="form-horizontal" role="form" method="POST" action="{{ url('/cases', [$case_info->id, 'datasets','createdataset']) }}">
                                            {!! csrf_field() !!}


                                        <input type="hidden" name="fileId" value="{{$list['fileId']}}">
                                        <input type="hidden" name="fileName" value="{{$list['pathSuffix']}}">
                                        <input type="hidden" name="filePath" value="{{$case_info->server_location}}">


                                        <div class="form-group">
                                            <div class="col-md-10 col-md-offset-1">

                                                <button type="submit" class="btn btn-success btn-lg btn-block">Add to Dataset</button>

                                            </div>
                                        </div>

                                      </form>
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                    </td>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    

                                  </tr>  
                                 
                         
                              @endforeach
                             @else
                            <tr>
                                  <td class="table-text">
                                     No Files in Directory
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
@extends('layouts.case_app')

@section('content')
<div class="container">
    <div class="row">
      
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Analytics</div>
                <div class="panel-body">

                  
                <a href="/analysisblocks/createblock" class="btn btn-default btn-lg center-block" role="button">Create Analytic Tool</a>
        
                </div>
            </div>
        </div>
        
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Analysis Tools</b></div>
      
                <table class="table task-table">
                 @if (count($aresults_list) > 0)
                  
                      <thead>
                        <th>Tool name</th>
                        <th>Tool ID</th>
                        <th>&nbsp;</th>
                    </thead>

                          <!-- Table Body -->
                          <tbody>
                            
                              @foreach($aresults_list as $list)
                                <tr>
                                    <!-- File Name -->
                                    <td class="table-text">
                                        {{$list->name}}
                                    </td>
                                    
                                    <!-- File ID -->
                                    <td class="table-text">
                                        {{$list->id}}
                                    </td>
                                </tr>  
                              @endforeach
                             @else
                            <tr>
                                  <td class="table-text">
                                     No Analysis Tools
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
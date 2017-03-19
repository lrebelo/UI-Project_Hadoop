@extends('layouts.case_app')

@section('content')
<div class="container">
    <div class="row">
      
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Workflow '{{ $workflow_info->name }}' for Case '{{ $case_info->name }}'</b></div>
                
            </div>
        </div>
        
      <!-- Dataset section -->
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Workflow</b></div> 
                <div class="panel-body">
                  <table class="table table-striped task-table">

                                  <!-- Table Headings -->
                                  <thead>
                                      <th>Step</th>
                                      <th>Tool Name</th>
                                      <th>Input data</th>
                                      <th>Parameters</th>
                                      <th>&nbsp;</th>
                                  </thead>
     

                                  <!-- Table Body -->
                                  <tbody>
                                          <tr>
                                              <!-- Step -->
                                              <td class="table-text">
                                                  <div>1</div>
                                              </td>
                                            
                                              <!-- Tool name -->
                                              <td class="table-text">
                                                  <div>ngs_filtering</div>
                                              </td>
                                              
                                              <!-- input files -->
                                              <td class="table-text">
                                                <div>
                                                
                                                <select class="" name="input_opt">
                                                  <option value="/CASE1/input.dat">input.dat</option>
                                                </select>
                                                
                                                </div>
                                              </td>
                                              
                                              <!-- parm -->
                                              <td class="table-text">
                                                <div>
                                                  <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#parameters1">Parameters</button>
                                                  
                                                  
                                                  <!-- Modal -->
                                                  <div class="modal fade" id="parameters1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                    <div class="modal-dialog" role="document">
                                                      <div class="modal-content">
                                                        <div class="modal-header">
                                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                          <h4 class="modal-title" id="myModalLabel">Tool Parameters</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                          T-cells or B-cell option 
                                                          <select class="" name="TCR_or_BCR">
                                                            <option value="TCR">T-cells</option>
                                                            <option value="BCR">B-cell</option>
                                                          </select></br>
                                                          Only Take Into Account Fuctional V-GENE?
                                                          <select class="" name="Vfun">
                                                            <option value="y">yes</option>
                                                            <option value="n">no</option>
                                                          </select></br>
                                                         Only Take Into Account CDR3 with no Special Characters (X,*,#)?
                                                          <select class="" name="spChar">
                                                            <option value="y">yes</option>
                                                            <option value="n">no</option>
                                                          </select></br>
                                                         Only Take Into Account Productive Sequences?
                                                          <select class="" name="prod">
                                                            <option value="y">yes</option>
                                                            <option value="n">no</option>
                                                          </select></br>
                                                          Only Take Into Account CDR3 with valid start/end landmarks? 
                                                          <select class="" name="delCF">
                                                            <option value="y">yes</option>
                                                            <option value="n">no</option>
                                                          </select></br>
                                                          V-REGION identity % 
                                                          <select class="" name="threshold">
                                                            <option value="y">yes</option>
                                                            <option value="n">no</option>
                                                          </select></br>
                                                         <!-- $Vg.Vgid 
                                                          $clen.cdr3len1 
                                                          $cdp.cdr3part 
                                                          $filtin 
                                                          $filtout 
                                                          $summ 
                                                          $Jg.Jgid 
                                                          $Dg.Dgid 
                                                          $clen.cdr3len2 
                                                          $process_id -->
                                                        </div>
                                                        <div class="modal-footer">
                                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  
                                                  
                                                </div>
                                              </td>
                                          </tr>
                                    
                                          <tr>
                                              <!-- Step -->
                                              <td class="table-text">
                                                  <div>2</div>
                                              </td>
                                            
                                              <!-- Tool name -->
                                              <td class="table-text">
                                                  <div>comp_clono_VCDR3</div>
                                              </td>
                                              
                                              <!--  -->
                                              <td class="table-text">
                                                <div>
                                                  <select class="" name="input_opt">
                                                    <option value=""></option>
                                                  </select>
                                                  
                                                </div>
                                              </td>
                                          </tr>
                                    
                                          <tr>
                                              <!-- Step -->
                                              <td class="table-text">
                                                  <div>3</div>
                                              </td>
                                            
                                              <!-- Tool name -->
                                              <td class="table-text">
                                                  <div>comp_clono_JCDR3</div>
                                              </td>
                                              
                                              <!--  -->
                                              <td class="table-text">
                                                <div>
                                                  
                                                  <select class="" name="input_opt">
                                                    <option value=""></option>
                                                  </select>
                                                  
                                                </div>
                                              </td>
                                          </tr>
                                          
                                          <tr>
                                              <!-- Step -->
                                              <td class="table-text">
                                                  <div>4</div>
                                              </td>
                                            
                                              <!-- Tool name -->
                                              <td class="table-text">
                                                  <div>ext_repertoire_V</div>
                                              </td>
                                              
                                              <!--  -->
                                              <td class="table-text">
                                                <div>
                                                
                                                  <select class="" name="input_opt">
                                                    <option value=""></option>
                                                  </select>
                                                  
                                                </div>
                                              </td>
                                          </tr>
                                    
                                          <tr>
                                              <!-- Step -->
                                              <td class="table-text">
                                                  <div>5</div>
                                              </td>
                                            
                                              <!-- Tool name -->
                                              <td class="table-text">
                                                  <div>ext_repertoire_J</div>
                                              </td>
                                              
                                              <!--  -->
                                              <td class="table-text">
                                                <div>
                                                <select class="" name="input_opt">
                                                    <option value=""></option>
                                                  </select>
                                                </div>
                                              </td>
                                          </tr>
                                          
                                    
                                  
                                  </tbody>
                              </table>
                  
                  
                  
                  
                </div>
            </div>
        </div> 
  

        <!-- analitics section -->
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Actions - Python File</b></div> 
                <div class="panel panel-default">
                  <div class="panel-body">
                    
                    <a href="/cases/{{$case_info->id}}/workflows/{{$workflow_info->id}}/execute" class="btn btn-danger btn-lg center-block" role="button">Execute</a>

                  </div>
                </div>
            </div>
        </div> 
      
        <!-- analitics section -->
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Actions - Direct Command</b></div> 
                <div class="panel panel-default">
                  <div class="panel-body">
                    
                    <a href="/cases/{{$case_info->id}}/workflows/{{$workflow_info->id}}/execute_old" class="btn btn-danger btn-lg center-block" role="button">Execute</a>

                  </div>
                </div>
            </div>
        </div> 
      
      
      
      
    </div>
</div>
@endsection
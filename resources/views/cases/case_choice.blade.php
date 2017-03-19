@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
              <div class="panel-heading"><b>Cases Available</b></div>
                <div class="panel-body">

                  <div class="row">
               
                    @foreach($cases_available as $cases)

                        <form class="form-horizontal" role="form" method="get" action="cases/{{ $cases->id }}">
                          {!! csrf_field() !!}

                      

                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <button type="submit" class="btn btn-success btn-lg btn-block">{{ $cases->name }}</button>

                            </div>
                        </div>

                      </form>
     
              
                   @endforeach
                   
                 </div>
             
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
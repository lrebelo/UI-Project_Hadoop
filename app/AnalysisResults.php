<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisResults extends Model
{
    //LR(20160521):: some changes to account for change in requirements
    protected $primaryKey = 'id';
  
    protected $table = 'analysisresults';
  
    
}

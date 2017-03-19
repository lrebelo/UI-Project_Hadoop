<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Datasets extends Model
{
    //
    protected $primaryKey = 'id';
  
    protected $table = 'datasets';
  
  
    public function workflow_datasets()
    {
        return $this->belongsToMany('App\Workflows','workflows_datasets','dataset_id','workflow_id');
    } 
  
}

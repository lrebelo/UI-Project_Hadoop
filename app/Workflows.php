<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workflows extends Model
{
    //
    protected $primaryKey = 'id';
  
    protected $table = 'workflows';
  
  
    public function workflow_datasets()
    {
        return $this->belongsToMany('App\Datasets','workflows_datasets','workflow_id', 'dataset_id');
    } 
  
}

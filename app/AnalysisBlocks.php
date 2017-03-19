<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnalysisBlocks extends Model
{
    //
    protected $primaryKey = 'id';
  
    protected $table = 'analysisblocks';
 
  
    /*
    public function user_type()
    {
        return $this->hasOne('App\User_Types','usertype_ID','usertype_ID');
    }
    */
  
}

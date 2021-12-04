<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    protected $table = 'cities';
    protected $guarded = ['id'];

    public function department()
      {
       return $this->belongsTo('App\department', 'department_id');
     }
}

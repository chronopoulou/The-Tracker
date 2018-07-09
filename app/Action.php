<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    //

    /**
     * Get the visitor that owns the action.
     */
    public function visitor()
    {
        return $this->belongsTo('App\Visitor');
    }
    
}

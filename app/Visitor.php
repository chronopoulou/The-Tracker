<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{

    /**
     * Get the website that owns the visitor.
     */
    public function website()
    {
        return $this->belongsTo('App\Website');
    }

    /**
     * Get the actions of the visitor.
     */
    public function actions()
    {
        return $this->hasMany('App\Action');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    protected $fillable = array('url', 'hash');
    //

    /**
     * Get the visitors of the website.
     */
    public function visitors()
    {
        return $this->hasMany('App\Visitor');
    }

    /**
     * Get all of the actions for the website.
     */
    public function actions()
    {
        return $this->hasManyThrough('App\Action', 'App\Visitor');
    }
}

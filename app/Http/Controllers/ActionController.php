<?php

namespace App\Http\Controllers;

use App\Action;
use App\Visitor;
use Illuminate\Http\Request;

class ActionController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $visitor = visitor::where('visitor_hash', '=', $request->visitor_hash)->get()->first();

      if (!$visitor) {
          // visitor with hash does not exists
          // cookie must be deleted and be tracked as new visitor
          return ['success' => false, 'delete_cookie' => true];
      }

      $action = new Action;
      $action->visitor_id = $visitor->id;
      $action->url = $request->url;
      $action->browser = $request->browser;
      $action->ip = $request->ip();
      $action->save();


      // all good
      return ['success' => true];
    }


}

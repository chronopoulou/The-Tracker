<?php

namespace App\Http\Controllers;

use App\Visitor;
use App\Website;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $website = Website::where('hash', '=', $request->website_hash)->get()->first();

      if (!$website) abort(403); // website hash doesn't exist

      if (!$website->allow_cross_tracking) {

          if (!isset($_SERVER['HTTP_ORIGIN']) || parse_url($_SERVER['HTTP_ORIGIN'], PHP_URL_HOST) != $website->url) {
            // if website does not like trafic from different origisns than $website->url, abort
            abort(403); // different host
          }
      }

      $visitor = new Visitor;
      $visitor->website_id = $website->id;
      $visitor->visitor_hash = md5($website->id . time());
      $visitor->save();

      return ['success' => true, 'visitor_hash' => $visitor->visitor_hash];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitor $visitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        //
    }
}

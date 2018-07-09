<?php

namespace App\Http\Controllers;

use Validator;
use Redirect;
use App\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $websites = Website::paginate(5);

        return view('websites.index', ['websites' => $websites]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('websites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // check if website exist and is unique
        $validator = Validator::make($request->all(), [
          'url' => 'required|unique:websites|max:255',
        ]);

        if ($validator->fails()) {
            return redirect(route('websites.create'))
                        ->withErrors($validator)
                        ->withInput();
        }

        // check if is a valid url
        if (filter_var($request->url, FILTER_VALIDATE_URL) === FALSE){
          $validator->errors()->add('url', 'Not a valid URL format');
          return Redirect::to(route('websites.create'))->withErrors($validator)->withInput();
        }

        // strip to get only the host
        $website_url = parse_url($request->url, PHP_URL_HOST);

        // check if website already exists
        if (Website::where('url', '=', $website_url)->exists()) {
          $validator->errors()->add('url', 'Website already exist');
          return Redirect::to(route('websites.create'))->withErrors($validator)->withInput();
        }

        $website = new Website;
        $website->url = $website_url;
        $website->hash = md5(rand() . $website_url);
        $website->save();

        return redirect()->route('websites.showPixel', ['website' => $website]);
    }

    /**
     * Display the pixel code.
     *
     * @param  \App\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function showPixel(Website $website)
    {
        return view('websites.showPixel', ['website' => $website]);
    }

    /**
     * Display the pixel code.
     *
     * @param  \App\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function pixelCode($hash)
    {
        $website = Website::where('hash', '=', $hash)->get()->first();

        if (!$website) abort(404); // if website with this hash does not exists

        return view('api.websites.pixelCode', ['website' => $website]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function show(Website $website)
    {
        $visits = $website->actions()->orderBy('created_at', 'DESC')->paginate(10);
        return view('websites.show', ['website' => $website, 'visits' => $visits]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function edit(Website $website)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Website $website)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Website  $website
     * @return \Illuminate\Http\Response
     */
    public function destroy(Website $website)
    {
        //
    }
}

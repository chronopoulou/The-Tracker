<?php

namespace App\Http\Controllers;

use App\Mailchimp;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

class MailchimpController extends Controller
{

    /**
     * Store a contact to mailchimp list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      if (substr_count($request->api_key, '-') == 0) {
        return response()->json([ 'error' => 'Wrong API format' ], 422);
      }

      $api_key_components = explode("-", $request->api_key);
      $api_key_datacenter = $api_key_components[count($api_key_components) - 1];

      $url = 'https://' . $api_key_datacenter . '.api.mailchimp.com/3.0/lists/' . $request->list_id . '/members';

      $data = [
        'auth' => [
          'anystring', $request->api_key
        ],

        'body' => json_encode([
          'email_address' => $request->email,
          'status' => 'subscribed'
        ])
      ];

      // get api-key to detect the datacenter form the last digits

      $client = new Client([
        'headers' => [ 'Content-Type' => 'application/json' ]
      ]);

      try {
        $response = $client->request('POST', $url, $data);
      }
      catch (\GuzzleHttp\Exception\BadResponseException $e) {
          // error response from the API return the error
          $response = $e->getResponse();
          $responseBodyAsString = json_decode( $response->getBody()->getContents() );
          return response()->json($responseBodyAsString, $response->getStatusCode());
      }

      // echo $res->getStatusCode();
      // // "200"
      // echo $res->getHeader('content-type');
      // // 'application/json; charset=utf8'

      $response_object =  json_decode( $response->getBody()->getContents() );

      if(! array_key_exists("id",$response_object)){
        return response()->json(['error' => 'Something went wrong, We couldn\'t find the id on the mailchimp api response'], 500);
      }

      return ["id" => $response_object->id];
    }

}

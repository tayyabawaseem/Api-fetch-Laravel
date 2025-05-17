<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RideController extends Controller
{
    public function showForm()
    {
        return view('ride.form');
    }

    public function lookup(Request $request)
    {
        $validated = $request->validate([
            'pickup_location' => 'required|string',
            'dropoff_location' => 'required|string',
            'stop' => 'nullable|string',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required',
            'return_trip' => 'nullable',
            'passenger_count' => 'required|integer|min:1',
        ]);

        
        // Step 1: Get OAuth2 token
        try {
            $tokenResponse = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->post('https://api.mylimobiz.com/v0/oauth2/token', [
                "grant_type" => "client_credentials",
                "client_id" => "ca_customer_mayfairbv",
                "client_secret" => "pmudJrHpv7zscw2vbdlJJFFWcIq4BLygs8gvwzW26ESWhJua67",
            ]);

         
            //  dd($tokenResponse->status()); 
//  dd($tokenResponse->status(), $tokenResponse->getBody()->getContents());
            if ($tokenResponse->failed()) {
                return back()->with('error', 'Failed to get access token.');
            }

            $accessToken = $tokenResponse->json('access_token');

            // dd($accessToken);
            if (!$accessToken) {
                return back()->with('error', 'Access token not found in response.');
            }

        } catch (\Exception $e) {
            return back()->with('error', 'OAuth token request failed: ' . $e->getMessage());
        }
        

        // Step 2: Call rate_lookup API with token
        // dd($validated['pickup_date'] . "T" . $validated['pickup_time']);
        // dd($validated['pickup_date'] . "T" . Date("H:i:s",strtotime($validated['pickup_time'])));
    $apiData = [
    'pickup' => [
        'instructions' => '',
        'address' => ['name' => $validated['pickup_location']],
    ],
    'dropoff' => [
        'address' => ['name' => $validated['dropoff_location']],
    ],
    'scheduled_pickup_at' => $validated['pickup_date'] . "T" . date("H:i:s", strtotime($validated['pickup_time'])),
    'stop' => $validated['stop'] ?? '',
    'return_trip' => $request->has('return_trip'),
    'passenger_count' => $validated['passenger_count'],
    'service_type' => 'point_to_point', // ✅ explicitly set
];



        try {
            $response = Http::withHeaders(headers: [
                'Authorization' => 'Bearer VA7e7xqg0TwJ1uacaXBKDB4Z4Z0Wd3TnQJuK9vleBkQuHJwjZR' /*. $accessToken*/,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
])->post('https://api.mylimobiz.com/v0/companies/mayfairbv/rate_lookup', $apiData);


            dd($response->json(), $response->status());

            if ($response->failed()) {
                return back()->with('error', 'Rate lookup API call failed.');
            }

            $vehicles = $response->json();

            if (empty($vehicles)) {
                return back()->with('error', 'No vehicle data found.');
            }

            return view('ride.results', compact('vehicles'));

        } catch (\Exception $e) {
            return back()->with('error', 'Rate lookup request error: ' . $e->getMessage());
        }
    }
}




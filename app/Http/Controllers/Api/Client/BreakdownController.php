<?php

namespace App\Http\Controllers\Api\Client;

use App\Models\User;
use App\Models\Client;
use App\Models\Feedback;
use App\Models\Provider;
use App\Models\Breakdown;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\Client\ArtisanBreakdownRequest;
use App\Http\Requests\Client\Towtruck_DriverBreakdownRequest;

class BreakdownController extends Controller
{
    public function detailsProvider ($id) {
        $provider = Provider::find($id);
        $feedbacks = Feedback::where('sp_id', $id)->get();
         $data = [];

        foreach($feedbacks as $feedback) {
            $data[] = [
                'review' => $feedback->review, 
            ];
        }
        
        if($provider->type == 'Artisan') {
           return response()->json([
            'profile picture' => $provider->profile_picture,
            'name' => $provider->first_name . ' ' . $provider->last_name,
            'rating' => floatval($feedback->avg('rating')),
            'data' => $data,        
         ]);  
        }
        else  {
            return response()->json([
            'profile picture' => $provider->profile_picture,
            'name' => $provider->first_name . ' ' . $provider->last_name,
            'rating' => floatval($feedback->avg('rating')),
            'plate number' => $provider->plate_number,
            'data' => $data,        
         ]);  
        }
    }

     public function artisan_breakdown(ArtisanBreakdownRequest $request){
        $validated_data = $request->all();
        
        $location = $validated_data['breakdown_location'];
        $url = $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($location)."&key=AIzaSyDornqgr9WTKn7NBam4u0H9-nDrZ2p7vdQ";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
        $response = curl_exec($ch);
        curl_close($ch);
        
      // Geocoding Api 
       $result = json_decode($response, true);   
        if ($result['status'] == 'OK') {
        $lat = $result['results'][0]['geometry']['location']['lat'];
        $lng = $result['results'][0]['geometry']['location']['lng'];
        


        $breakdown = new Breakdown;
        
        $breakdown->breakdown_location = $location;
        $breakdown->breakdown_latitude = $lat;
        $breakdown->breakdown_longitude = $lng;
        
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
       // dd($client);
        $breakdown->client_id = $client->client_id;
        //dd($breakdown->client_id);
        if($breakdown->save()) {
        //maximum distance
        $max_distance = 2;
            
        // Query the database for service providers within the maximum radius
        $provider = Provider::select('sp_id', 'first_name', 'latitude', 'longitude')
        ->selectRaw("6371 * acos(cos(radians($lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($lng)) + sin(radians($lat)) * sin(radians(latitude))) AS distance")
        ->having('distance', '<=', $max_distance)
        ->orderBy('distance')
        ->get();

          return response()->json([
                'status' => true,
                'data' => $provider
            ]);
        } 
          
        else {
               return response()->json([
                'status' => false,
                'message' => "Failed"
            ]);
        }

    }
}
     

      public function artisanRequest (Request $request) {
       $user = auth()->user();
       $client_user = Client::where('user_id', $user->id)->first();
       $provider_id = $request->input('id'); // Hidden
       //dd($provider_id);
       $client = Breakdown::where('client_id', $client_user->client_id)
                 ->latest()
                ->first();
       //dd($client);

       $client->service_provider = $provider_id;
       dd($client->service_provider);
       $client->save();
       dd($client);
       
      }

    public function towtruckDriverBreakdown(Towtruck_DriverBreakdownRequest $request){
        
        $validated_data = $request->all();
        $b_location = $validated_data['breakdown_location'];
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($b_location)."&key=AIzaSyDornqgr9WTKn7NBam4u0H9-nDrZ2p7vdQ";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);
       // dd($result);

        if ($result['status'] == 'OK') {
        $b_lat = $result['results'][0]['geometry']['location']['lat'];
        $b_lng = $result['results'][0]['geometry']['location']['lng'];
        
        $breakdown = new Breakdown;
        $breakdown->breakdown_location = $b_location;
        $breakdown->breakdown_latitude = $b_lat;
        $breakdown->breakdown_longitude = $b_lng;
        
       

      $d_location = $validated_data['destination_location'];
      $durl = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($d_location)."&key=AIzaSyDornqgr9WTKn7NBam4u0H9-nDrZ2p7vdQ";

        
       // Make the API request using cURL
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       curl_setopt($ch, CURLOPT_URL,$durl);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
       curl_setopt($ch, CURLOPT_HEADER, false);
       curl_setopt($ch, CURLOPT_REFERER, $durl);
       curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
       $response = curl_exec($ch);
       //info($response);
       curl_close($ch);
       $results = json_decode($response, true);
       $result = json_decode($response, true);
       
        if ($result['status'] == 'OK') {
        $d_lat = $result['results'][0]['geometry']['location']['lat'];
        $d_lng = $result['results'][0]['geometry']['location']['lng'];
  

        $breakdown->destination_location = $d_location;
        $breakdown->destination_latitude = $d_lat;
        $breakdown->destination_longitude = $d_lng;
        
        $user = Auth::user();
        $client = Client::where('user_id', $user->id)->first();
       // dd($client);
        $breakdown->client_id = $client->client_id;
        //dd($breakdown->client_id);
        if($breakdown->save()) {
        //maximum distance
        $max_distance = 10;
            
        // Query the database for service providers within the maximum radius
        $provider = Provider::select('sp_id', 'first_name', 'latitude', 'longitude')
        ->selectRaw("6371 * acos(cos(radians($b_lat)) * cos(radians(latitude)) * cos(radians(longitude) - radians($b_lng)) + sin(radians($b_lat)) * sin(radians(latitude))) AS distance")
        ->having('distance', '<=', $max_distance) // Displays the sp within the max_distance
        ->orderBy('distance') //get the distance between sp and client
        ->get();

       
          return response()->json([
                'status' => true,
                'data' => $provider
            ]);
        } 
    }
    }
        else {
               return response()->json([
                'status' => false,
                'message' => "Failed"
            ]);
        }
    }
}
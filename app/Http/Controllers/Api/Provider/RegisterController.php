<?php

namespace App\Http\Controllers\Api\Provider;

use CURLFile;
use App\Models\User;
use App\Models\Provider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Provider\RegisterRequest;

class RegisterController extends Controller
{
     public function register (RegisterRequest $request ) {
        // validate request data
            $request->validated($request->all());
           
            $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'push_notification_token' => $request->push_notification_token,
            'role' => 'provider',
            'status' => 'active'

        ]);

        // Get the address from the request

        $address = $request->input('business_address');
        $url = $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&key=AIzaSyDornqgr9WTKn7NBam4u0H9-nDrZ2p7vdQ";
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response);
        $result = $data->results[0]->address_components;
        //return $result;
            $lga_result = [];
            $len = count($result);
            $lga_result['administrative_area_level_2'] = $result[$len-4];
            $lga = $lga_result['administrative_area_level_2']->long_name;
            //return $lga;

            $state_result = [];
            $len = count($result);
            $state_result['administrative_area_level_1'] = $result[$len-3];
            $state = $state_result['administrative_area_level_1']->long_name;
            //return $state;
                $data = json_decode($response);
                
        $data_geo = json_decode($response, true);
        if ($data_geo['status'] == 'OK') {
        $lat = $data_geo['results'][0]['geometry']['location']['lat'];
        $lng = $data_geo['results'][0]['geometry']['location']['lng'];
       
        
        $provider = Provider::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'business_address' => $address,
            'latitude' => $lat,
            'longitude' => $lng,
            'type' => $request->type,
            'lga' => $lga,
            'state' => $state,
            'gender' => $request->gender,
            'profile_picture' => $request->profile_picture,
        ]);
              // set your Cloudinary credentials
        $cloudinary_url = 'https://api.cloudinary.com/v1_1/{your_cloud_name}/image/upload';
        $cloudinary_upload_preset = 'findyourserviceprovider';
        $cloudinary_api_key = '719546256243947';
        $cloudinary_api_secret = 'WeYbpCpVcYHKzciwSGPwz-SXeMI';
        
        
         // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // create a curl file object from the image file
            $image_path = $request->file('profile_picture')->path();
            $image_file = new CURLFile($image_path);
        
            // create the curl request
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $cloudinary_url,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => array(
                    'file' => $image_file,
                    'upload_preset' => $cloudinary_upload_preset,
                    'api_key' => $cloudinary_api_key,
                    'timestamp' => time(),
                )
            ));
        
            // execute the curl request
            $response = curl_exec($curl);
            $error = curl_error($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
        
            if ($error) {
                // handle the error
                echo "cURL Error: " . $error;
            } else {
                // extract the public URL from the response
                $data = json_decode($response);
            //dd($data);
                $public_url = $data->url;
        
                // update the client's profile picture URL in the database
                $provider->profile_picture = $public_url;
                $provider->save();
            }
        }
        
          return response()->json([
                'status' => true,
                'message' => 'Service Provider Created Successfully,Login to Generate Token',
                'Provider' =>  $provider->name,
                'ftoken' => $user->push_notification_token
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invaild Address'
            ]); 
        }



           
        
       
     }
}
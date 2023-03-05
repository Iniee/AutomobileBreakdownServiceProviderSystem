<?php

namespace App\Http\Controllers\Api\Client;

use CURLFile;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Client\RegisterRequest;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

          try {
            //Validated
            $validateUser = Validator::make($request->all(),
            [
                'name' => 'required|string|max:50',
                'home_address' => 'required|string',
                'phone_number' => 'required|max:11|min:11|string|unique:clients,phone_number',
                'gender' => 'required|in:male,female',
                'password' => 'required|string|confirmed|min:8',
                'profile_picture' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

           $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'client'
           ]);

           // Get the address from the request

        $address = $request->input('home_address');
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

        
            $state_result = [];
            $len = count($result);
            $state_result['administrative_area_level_1'] = $result[$len-3];
            $state = $state_result['administrative_area_level_1']->long_name;
            //return $state;
                $data = json_decode($response);
            
       

        $client = Client::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'home_address' => $request->home_address,
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
                $client->profile_picture = $public_url;
                $client->save();
            }
        }


                    return response()->json([
                        'status' => true,
                        'message' => 'Client Created Successfully, Login to Generate Token',
                        'user' =>  $client->name,
                    ], 200);

                } catch (\Throwable $th) {
                    return response()->json([
                        'status' => false,
                        'message' => $th->getMessage()
                    ], 500);
                }

            }

}
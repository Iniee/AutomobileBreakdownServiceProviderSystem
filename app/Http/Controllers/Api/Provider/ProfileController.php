<?php

namespace App\Http\Controllers\Api\Provider;

use CURLFile;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Provider\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function updateprofile(UpdateProfileRequest $request)
    {

        $user = auth()->user();
        $provider = Provider::where('user_id', $user->id)->first();
        //dd($provider);
        $user->fill($request->validated());
        $provider->fill($request->validated());

        $user->save();
        $provider->save();

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

                // update the provider's profile picture URL in the database
                $provider->profile_picture = $public_url;
                $provider->save();
            }
        }
        return response()->json([
            'message' => 'User profile updated successfully.',
            'data' => [
                'name' => $provider->name,
                'email' => $user->email,
                'phone_number' => $provider->phone_number,
                'profile picture' => $provider->profile_picture,
                'account number' => $provider->account_number,
                'bank' => $provider->bank_name
            ]
        ]);
    }


}
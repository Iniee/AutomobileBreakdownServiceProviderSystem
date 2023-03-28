<?php

namespace App\Http\Controllers\Api\Client;

use CURLFile;
use App\Models\Client;
use App\Models\Feedback;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Client\UpdateProfileRequest;

class ProfileController extends Controller
{
    public function updateprofile(UpdateProfileRequest $request)
    {

        $user = auth()->user();
        $client = Client::where('user_id', $user->id)->first();
        //dd($client);
        $user->fill($request->validated());
        $client->fill($request->validated());
        
        $password = $request->input('password');
        if (!empty($password)) {
        $user->password = Hash::make($password);
       }
        $user->save();
        $client->save();

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
            'message' => 'User profile updated successfully.',
            'data' => [
                'name' => $client->name,
                'email' => $user->email,
                'phone_number' => $client->phone_number,
                'profile picture' => $client->profile_picture
            ]
        ]);
    }

    public function providerdetails($id)
    {
        $provider  = Provider::find($id);
        $feedback = Feedback::where('sp_id', $provider->sp_id)
            ->select('client_id', 'review')
            ->join('clients', 'clients.client_id', '=', 'feedbacks.client_id')
            ->select('clients.name as client_name', 'review')
            ->get();
        $rating = Feedback::where('sp_id', $id)->get();
        $requestdata = DB::table('requests')
            ->join('breakdowns', 'requests.breakdown_id', '=', 'breakdowns.breakdown_id')
            ->where('requests.provider_id', $id)
            ->where('breakdowns.status', 'accepted')
            ->count();
            
        if ($provider->type == 'Artisan') {
            return response()->json([
                'profile_picture' => $provider->profile_picture,
                'name' => $provider->name,
                'type' => $provider->type,
                'service' => $requestdata,
                'rating' => floatval($rating->avg('rating')), 
                'review' => $feedback,
            ]);
        } else {
            return response()->json([
                'profile_picture' => $provider->profile_picture,
                'name' => $provider->name,
                'type' => $provider->type,
                'trips' => $requestdata,
                'plate_number' => $provider->plate_number,
                'rating' => floatval($rating->avg('rating')),
                'review' => $feedback,

            ]);
        }
    }
}
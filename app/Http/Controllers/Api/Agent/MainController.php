<?php

namespace App\Http\Controllers\Api\Agent;

use CURLFile;

use App\Models\User;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class MainController extends Controller
{
    use HttpResponses;
    public function update(Request $request)
    {
         $validateUser = Validator::make($request->all(),
            [
            'account_number' => 'required|string|max:10|min:10',
            'bank_name' => 'required|string',
            'profile_picture' => 'required',
            ]);

         if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

        $user = Auth::user();
        //dd($user);
        $agent_user = Agent::where('user_id', $user->id)->first();
        //dd($agent_user);
        $agent_user->account_number = $request->account_number;
        $agent_user->profile_picture = $request->profile_picture;
        $agent_user->bank_name = $request->bank_name;;
        
                // set Cloudinary credentials
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
                $agent_user->profile_picture = $public_url;
                $agent_user->save();
            }
        }

    

        return response()->json([
            "status" => true,
            "message" => "Update Successful"
      ]);
    }

    //List of Unapproved Service Provider in the Same Lga as the agent
    public function dashboard()
    {
          $data = DB::table('service_provider')
               ->where([
                ['status', 'pending'],
                ['lga', auth()->user()->lga]
            ])->get();
       
        return response()->json([
            'status' => true,
            'message' => 'List of Unapproved Service Provider in the Same Lga as the agent',
            'data' => $data
                // 'name' => $data['first_name']. ' '. $data['first_name'],
                // // 'type' => $data->type,
                // // 'status' => $data->status,              
            
        ]);
    }


    public function view($id)
    {
        $unapproved_id = DB::table('service_provider')->get($id);

        return $unapproved_id;
    }

    public function viewApproved()
    {
        $data = DB::table('service_provider')
               ->where([
                ['status', 'approved'],
                ['lga', auth()->user()->lga],
                ['verified_by_agent', auth()->user()->agent_id]
            ])->get();
           return response()->json([
            'status' => true,
            'message' => 'List of Approved Service Provider in the Same Lga as the agent',
            'data' => $data
                // 'name' => $data['first_name']. ' '. $data['first_name'],
                // // 'type' => $data->type,
                // // 'status' => $data->status,              
            
        ]);
    }

    public function changePassword(Request $request){

          $validator = Validator::make($request->all(),
            [
                'current_password' => 'required',
                'password' => 'required|string|confirmed|min:8',   
            ]);

              if($validator->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401);
            }

        $current_password = $request->current_password;
        $user = Auth::user();
        //dd($user);
        if(Hash::check($current_password, $user->password)) {
        $new_password = $request->password;
        $user->password = Hash::make($new_password); 
        $user->save();
        
        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ], 200);
    }
    else{
        return response()->json([
            'status' => false,
            'message' => 'Current password does not match'
        ], 401);
    }
}
    
    
}
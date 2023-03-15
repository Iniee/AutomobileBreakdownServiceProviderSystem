<?php

namespace App\Http\Controllers\Admin;

use CURLFile;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Agent\RegisterRequest;
use App\Http\Requests\Agent\UpdateProfileRequest;

class AgentController extends Controller
{
    public function agentAccount()
    {
            $agents = Agent::with('user')->latest('created_at')->paginate(20);
            return view('content.agent.view-account', compact('agents'));
    }
    public function deactiveAgent()
    {
            $users = User::where([
                ['status', 'pending'],
                ['role', 'agent']
            ])->with('agent')->latest('created_at')->paginate(20);          
            return view('content.agent.deactive-account', compact('users'));
    }
    public function activeAgent()
    {
             $users = User::where([
                ['status', 'active'],
                ['role', 'agent']
            ])->with('agent')->latest('created_at')->paginate(20);          
            return view('content.agent.active-account', compact('users'));
    }
   
    public function register()
    {
    return view('content.agent.register');
    }
    public function edit(Agent $agent)
    {
        return view("content.agent.edit", compact('agent'));
    }

    public function store(Request $request)
    {
         $validatedData = $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|max:11|min:11|string|unique:agents,phone_number',
            'home_address' => 'required|string',
            'gender' => 'required|in:male,female',
            'profile_picture' => 'required'
        ]);
          $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'agent',
            'active' => 'active'
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
       
        $agent = Agent::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'phone_number' => $validatedData['phone_number'],
            'home_address' => $validatedData['home_address'],
            'lga' => $lga,
            'state' => $state,
            'gender' => $validatedData['gender'],
            'account_number' => $request->account_number,
            'bank_name' => $request->bank_name,
            'profile_picture' => $validatedData['profile_picture'],
        ]);

        // set Cloudinary credentials
        $cloudinary_url = 'https://api.cloudinary.com/v1_1/dpceydtzp/image/upload';
        $cloudinary_upload_preset = 'findyourserviceprovider';
        $cloudinary_api_key = '719546256243947';
        $cloudinary_api_secret = 'WeYbpCpVcYHKzciwSGPwz-SXeMI';
   
        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            dd("Yes");
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
            dd($response);
            $error = curl_error($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);

            if ($error) {
                // handle the error
                echo "cURL Error: " . $error;
            } else
            {
                // extract the public URL from the response
                $data = json_decode($response);
                $public_url = $data->url;

                // update the client's profile picture URL in the database
                $agent->profile_picture = $public_url;
                $agent->save();
             }
        }
            return redirect()->route('dashboard');   
    }
   
        
            public function agentDeactivateAccount()
            {
                return view('content.agent.deactivate-account');
            }
}
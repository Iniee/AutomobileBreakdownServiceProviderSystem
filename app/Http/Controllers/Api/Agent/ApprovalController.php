<?php

namespace App\Http\Controllers\Api\Agent;

use CURLFile;
use App\Models\User;
use App\Models\Approval;
use App\Models\Agent;
use App\Models\Provider;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Agent\ApprovalRequest;

class ApprovalController extends Controller
{
    use HttpResponses;
 

    public function artisanstore(Request $request,$id)
    {
        
         $id = Provider::find($id);
         $user = auth()->user();
         //dd($user);
         $agent = Agent::where('user_id', $user->id)->first();
         if ($id->type == 'Artisan'){
            $artisandata = Validator::make($request->all(),
            [
                'document' => 'required',
                'address_confirmation'=> 'required|boolean',
            ]);

              if($artisandata->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $artisandata->errors()
                ], 401);
            }

            //Create the form
        $approvaldata = Approval::create([
            'document' => $request->document,
            'address_confirmation' => $request->address_confirmation,
            'provider_id' => $id->sp_id,
            'agent_id' => $agent->agent_id,
        ]);

              // set your Cloudinary credentials
        $cloudinary_url = 'https://api.cloudinary.com/v1_1/{your_cloud_name}/image/upload';
        $cloudinary_upload_preset = 'findyourserviceprovider';
        $cloudinary_api_key = '719546256243947';
        $cloudinary_api_secret = 'WeYbpCpVcYHKzciwSGPwz-SXeMI';


        // Handle profile picture upload
        if ($request->hasFile('document')) {
            // create a curl file object from the image file
            $image_path = $request->file('document')->path();
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
                $public_url = $data->url;

                // update the client's profile picture URL in the database
                $approvaldata->document = $public_url;
                $approvaldata->save();
            }
        }

        if ($approvaldata['address_confirmation'] == true && !empty($approvaldata['document'])) {
            
            $approvaldata->status = 'approved';
            $approvaldata->save();

            // Update the provider status column
            $id->status = "approved";
            $id->verified_by_agent = $agent->agent_id;
            $id->save();

            return response()->json([
                'status' => 'Status Updated Successfully',
                'message' => $id->status,
                'provider' => $id->name,
                'agent' => $agent->name
            ]);
        } else
            return response()->json([
                'status' => 'Status Updated Successfully',
                'message' =>  $id->status,
                'provider' => $id->name

            ]);

         }
        else {
           $driverdata = Validator::make($request->all(),
            [
                'document' => 'required',
                'plate_number' => 'required|boolean',
                'address_confirmation'=> 'required|boolean',
            ]);

              if($driverdata->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $driverdata->errors()
                ], 401);
            }

    
        //Create the form
        $cabapprovaldata = Approval::create([
            'document' => $request->document,
            'plate_number' => $request->plate_number,
            'address_confirmation' => $request->address_confirmation,
            'provider_id' => $id->sp_id,
            'agent_id' => $agent->agent_id,
        ]);
        
         // set your Cloudinary credentials
        $cloudinary_url = 'https://api.cloudinary.com/v1_1/{your_cloud_name}/image/upload';
        $cloudinary_upload_preset = 'findyourserviceprovider';
        $cloudinary_api_key = '719546256243947';
        $cloudinary_api_secret = 'WeYbpCpVcYHKzciwSGPwz-SXeMI';


        // Handle profile picture upload
        if ($request->hasFile('document')) {
            // create a curl file object from the image file
            $image_path = $request->file('document')->path();
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
                $public_url = $data->url;

                // update the client's profile picture URL in the database
                $cabapprovaldata->document = $public_url;
                $cabapprovaldata->save();
            }
        }

        if ($cabapprovaldata['plate_number'] == true && $cabapprovaldata['address_confirmation'] == true && !empty($cabapprovaldata['document'])) {
            $cabapprovaldata->status = 'Approved';
            $cabapprovaldata->save();

            // Update the provider status column
            $id->status = "Approved";
            $id->verified_by_agent = $agent->agent_id;
            $id->save();

            return response()->json([
                'status' => 'Status Updated Successfully',
                'message' =>   $id->status,
                'provider' => $id->name,
                'agent' =>$agent->name
            ]);
        } else
            return response()->json([
                'status' => 'Status Updated Successfully',
                'message' =>  $id->status,
                'provider' => $id->name,
                'agent' =>$agent->name


            ]);       
        } 

         
    }


}
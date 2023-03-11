<?php

namespace App\Http\Controllers;

use App\Models\Breakdown;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ClientRequestController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function clientsendNotification(Request $request, $b_id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'message' => 'required',
        ]);
        $b_id = Breakdown::find($id);
        $client = auth()->user()->client;
        return $client;
        // Save the client request to the database
        $savedRequest = DB::table('client_requests')->insert([
            'client_id' => $client->id,
            'message' => $validatedData['message'],
        ]);
        
        // Send a push notification to the provider using Firebase Cloud Messaging
         $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . env('FCM_SERVER_KEY'),
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'to' => $pushNotificationToken,
                'notification' => [
                    'title' => 'New Notification',
                    'body' => 'You have a new notification!'
                ]
            ]));
        
        // Check if the push notification was sent successfully
        if ($response->status() === 200) {
            return response()->json([
                'status' => 'success',
                'message' => 'Client request saved and push notification sent successfully.',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send push notification to provider.',
            ]);
        }
    }


  public function providersendNotification(Request $request)
   {
    $user = $request->user();    
    $pushNotificationToken = $user->push_notification_token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . env('FCM_SERVER_KEY'),
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'to' => $pushNotificationToken,
        'notification' => [
            'title' => 'New Notification',
            'body' => 'You have a new notification!'
        ]
    ]));
    $response = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $res = json_decode($response);
    return $httpStatus;
    if ($res->status() === 200) {
        return response()->json(['status' => 'success']);
    } else {
        return response()->json(['status' => 'error'], 500);
    }
  }


  public function agentsendNotification(Request $request)
   {
    $user = $request->user();    
    $pushNotificationToken = $user->push_notification_token;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . env('FCM_SERVER_KEY'),
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'to' => $pushNotificationToken,
        'notification' => [
            'title' => 'New Notification',
            'body' => 'You have a new notification!'
        ]
    ]));
    $response = curl_exec($ch);
    $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $res = json_decode($response);
    return $res;
    if ($res->status() === 200) {
        return response()->json(['status' => 'success']);
    } else {
        return response()->json(['status' => 'error'], 500);
    }
  }

}
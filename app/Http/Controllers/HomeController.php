<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use Notification;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function notification($title, $message)
    {

        $url = 'https://fcm.googleapis.com/fcm/send';
        $fcmToken = User::whereNotNull('device_key')->pluck('device_key')->all();

        $serverKey = env('FIREBASE_SERVER_KEY');

        $data = [
            "registration_ids" => $fcmToken,
            "notification" => [
                "title" => $title,
                "body" => $message,
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        return $result;
    }

    public function updateToken(Request $request)
    {
        try {
            auth()->user()->update(['device_key' => $request->token]);
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false
            ], 500);
        }
    }
}

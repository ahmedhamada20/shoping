<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OneSignal;
use Illuminate\Support\Facades\Http;
use App\Services\OneSignalService;

class NotificationController extends Controller
{
    public function index()
    {
        return view('Notifications.create');
    }

    public function sendToUserApp(Request $request)
    {
        $contents = $request->send_message;
        $OneSignalService = new OneSignalService;
        if($OneSignalService->sendNotificationToAll(env('ONESIGNAL_SECOND_APP_ID'), env('ONESIGNAL_SECOND_APP_REST_API_KEY'), $contents)){
            return back()->with('success', 'Notification sent successfully');
        }else{
            return back()->with('error', 'An error occured. Please try again');
        }
        
        // $contents = $request->send_message;
        // OneSignal::sendNotificationToAll(
        //     $contents,
        //     $url = null,
        //     $data = null,
        //     $buttons = null,
        //     $schedule = null
        // );
        // return redirect::back()->with('message', 'Updated ');
        // return back()->with('message', 'Notification sent successfully');
        // $headers = [
        //     'Content-Type' => 'application/json',
        //     'AccessToken' => 'key',
        //     'Authorization' => 'Bearer token',
        // ];
        // $params = array(
        //     'app_id' => env('ONESIGNAL_SECOND_APP_ID'),
        //     'api_key' => env('ONESIGNAL_SECOND_APP_REST_API_KEY'),
        // );

        // $message = "request->send_message";
        // $segment = "Subscribed Users";
        // OneSignal::sendNotificationToSegment(
        //     "Some Message",
        //     $segment,
        //     $url = null,
        //     $data = null,
        //     $buttons = null,
        //     $schedule = null
        // );
        
    }
}

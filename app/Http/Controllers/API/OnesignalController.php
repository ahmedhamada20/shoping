<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OneSignal;
use Illuminate\Support\Facades\Http;

class OnesignalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $driverUniqueId =  $request->driver_unique_id;

        // OneSignal::sendNotificationToAll(
        //     "Test message to send",
        //     $driverUniqueId,
        //     $url = null,
        //     $data = null,
        //     $buttons = null,
        //     $schedule = null
        // );

        return  OneSignal::sendNotificationToAll(
            "Da njn ippo hit cheyyuany by nived",
            $url = null,
            $data = null,
            $buttons = null,
            $schedule = null
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

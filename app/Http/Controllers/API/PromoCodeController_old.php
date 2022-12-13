<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\PromoCode;
use Illuminate\Support\Facades\Http;

class PromoCodeController extends Controller
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
    public function show($code)
    {
       $data = PromoCode::where('code', $code)->select('code')->first();
	   if(empty($data)){
			return $this->error("Promo code does not exist.", 200);
	   }
	     return $this->success('Promo code matches successfully.', $data);
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

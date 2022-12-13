<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\DriverActivity;
use App\Vehicle;
use App\Orderstatus;
use App\Order;
use App\Package;
use App\PackageMedia;
use App\Address;
use App\CompanyOffres;
use App\Http\Resources\OfferDeliverResource;
use App\OffersDivere;
use App\User;
use App\Services\GeoMapper;
use Log;
use Image;

class DriverController extends Controller
{
    /**
     * driver list for user app -- api -Drivers-
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data = [];
            $distance = '';
            $driverActivities = DriverActivity::where('status', 'active')->get();
            foreach ($driverActivities as $driverActivity) {
                $driverDetails = Driver::where('status', 1)->find($driverActivity->driver_id);
                if (isset($driverDetails)) {
                    $driverVehicle = Vehicle::where('driver_id', $driverDetails->id)->first();
                    $latitudeFrom = $request->user_lat;
                    $longitudeFrom = $request->user_lng;

                    $latitudeTo = $driverActivity->lat;
                    $longitudeTo = $driverActivity->lng;

                    $geoMapper = new GeoMapper;
                    $distance = $geoMapper->calculateDistance($latitudeTo, $longitudeTo, $latitudeFrom, $longitudeFrom);
                    // if ($distance <= $driverDetails->distance) {
                    $data[] = array(
                        "id" => $driverActivity->driver_id ? $driverActivity->driver_id : " ",
                        "fullname" => $driverDetails->fullname ? $driverDetails->fullname : " ",

                        "DriverOffers" =>  $driverDetails->offer->offers ?? "",

                        "email" => $driverDetails->email ? $driverDetails->email : " ",
                        "latitude" => $driverActivity->lat ? $driverActivity->lat : " ",
                        "longitude" => $driverActivity->lng ? $driverActivity->lng : " ",
                        "distance" => $distance ? round($distance, 3) : "",
                        "vehicle_type" => $driverVehicle->type ? $driverVehicle->type : ' ',
                        "vehicle_model" => $driverVehicle->model ? $driverVehicle->model : ' ',
                        "vehicle_number" => $driverVehicle->vehicle_number ? $driverVehicle->vehicle_number : '',
                    );
                }
                //  else {
                //     return $this->success('Currently no driver avalable', 200);
                // }
            }
            return $this->success('active driver list', $data);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }
    /**
     * driver login
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first(), 200);
        }
        $driver = Driver::where('email', $request->email)->where('status', 1)->first();
        if ($driver) {
            $firstname = '';
            $lastname = '';
            if ($driver->fullname) {
                $fullname = explode(' ', $driver->fullname);
                $firstname = $fullname[0];
                $lastname =  $fullname[1];
            }

            $vehicle = Vehicle::where('driver_id', $driver->id)->first();
            if (Hash::check($request->password, $driver->password)) {
                $token = $driver->createToken('Laravel Password Grant Client')->accessToken;
                $response = [
                    'id' => $driver->id ?  $driver->id : '',
                    'firstname' => $driver->fullname ?  $firstname : '',
                    'lastname' => $driver->fullname ?  $lastname : '',
                    'email' => $driver->email ?  $driver->email : '',
                    'phone' => $driver->phone ?  (string)$driver->phone : '',
                    // 'emirates_id' => $driver->emirates_id ?  $driver->emirates_id : '',
                    'status' => $driver->status ?  true : false,
                    'vehicle_type' => $vehicle->type ? $vehicle->type : "",
                    'vehicle_number' => $vehicle->vehicle_number ? $vehicle->vehicle_number : "",
                    'driver_unique_id' => $driver->unique_id ? $driver->unique_id : "",
                    'token' => $token
                ];

                // return response($response, 200);
                return $this->success('logged in successfully', $response);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password mismatch'
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not exist'
            ], 200);
        }
    }

    // driver log out from
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        // dd(Auth::user()->token());
        $token->revoke();
        return $this->success('You have been successfully logged out!', 200);
    }



    /**
     * Driver activity checkin check out
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activity(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'activity_type' => 'required',
                'lat' => 'required',
                'lng' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 200);
            }
            // driver check
            $existingDriver = Driver::find($request->id);
            if ($existingDriver) {
                $response = [];
                $checkActivity = DriverActivity::where('driver_id', $existingDriver->id)->first();
                if ($checkActivity) {
                    // echo "we are here111";
                    // check id driver already checked in or not
                    if ($request->activity_type != $checkActivity->activity_type) {
                        // update by activity type
                        if ($request->activity_type == 'check_in') {
                            // echo "we are here111";
                            $data = [
                                'in_time' => now(),
                                'status' => 'active',
                                'activity_type' => "check_in",
                                'lat' => $request->lat,
                                'lng' => $request->lng
                            ];
                            $driverActivity = DriverActivity::where('driver_id', $existingDriver->id)->first();
                            if ($driverActivity->update($data)) {
                                $response = [
                                    "check_in_time" => $driverActivity->in_time,
                                    "activity_type" => $driverActivity->activity_type,
                                    "status" => $driverActivity->status,
                                    "lat" => $driverActivity->lat ? $driverActivity->lat : "",
                                    "lng" => $driverActivity->lng ? $driverActivity->lng : ""
                                    // "lat" => $driverActivity->lat ? number_format($driverActivity->lat, 8, '.', '') : "",
                                    // "lng" => $driverActivity->lng ? number_format($driverActivity->lng, 8, '.', '') : "",

                                ];
                                return $this->success('checked in successfully', $response);
                            } else {
                                return $this->error("Not updated please try again later", 200);
                            }
                        } else if ($request->activity_type == 'check_out') {
                            $data = [
                                'out_time' => now(),
                                'status' => 'deactive',
                                'activity_type' => $request->activity_type,
                                'lat' => $request->lat,
                                'lng' => $request->lng
                            ];
                            if ($checkActivity->update($data)) {
                                // echo $checkActivity->activity_type;
                                $response = [
                                    "check_out_time" => $checkActivity->out_time,
                                    "check_in_time" => $checkActivity->in_time,
                                    "activity_type" => $checkActivity->activity_type,
                                    "status" => $checkActivity->status,
                                    "lat" => $checkActivity->lat ? $checkActivity->lat : "",
                                    "lng" => $checkActivity->lng ? $checkActivity->lng : ""
                                    // "lat" => $checkActivity->lat ? number_format($checkActivity->lat, 8, '.', '') : "",
                                    // "lng" => $checkActivity->lng ? number_format($checkActivity->lng, 8, '.', '') : ""
                                ];
                                return $this->success('checked out successfully', $response);
                            } else {
                                return $this->error("Not updated please try again later", 200);
                            }
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Activity type doesnot match'
                            ], 200);
                        }
                    } else {
                        if ($request->activity_type == 'check_out') {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Already checked out'
                            ], 200);
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Already checked in'
                            ], 200);
                        }
                    }
                } else {
                    // echo "we are here";
                    if ($request->activity_type == 'check_in') {

                        $driverActivity = new DriverActivity;
                        $driverActivity->driver_id = $existingDriver->id;
                        $driverActivity->in_time = now();
                        $driverActivity->status = "active";
                        $driverActivity->activity_type = $request->activity_type;
                        $driverActivity->lat = $request->lat;
                        $driverActivity->lng = $request->lng;

                        if ($driverActivity->save()) {
                            $response[] = [
                                "driver_id" => $driverActivity->driver_id,
                                "check_in_time" => $driverActivity->in_time,
                                "activity_type" => $driverActivity->activity_type,
                                "status" => $driverActivity->status,
                                "lat" => $driverActivity->lat ? $driverActivity->lat : "",
                                "lng" => $driverActivity->lng ? $driverActivity->lng : ""
                                // "lat" => $driverActivity->lat ? number_format($driverActivity->lat, 8, '.', '') : "",
                                // "lng" => $driverActivity->lng  ? number_format($driverActivity->lng, 8, '.', '') : ""
                            ];
                            return $this->success('logged in successfully', $response);
                        }
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Activity type doesnot match'
                        ], 200);
                    }
                }
                // return $this->success('logged in successfully', $response);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Driver does not exist'
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function locationUpdate(Request $request)
    {
        try {
            // $response = '';
            $driverActivity = DriverActivity::where('driver_id', Auth::user()->id)->first();
            // if ($driverActivity->status == "active") {
            $driverDetails = Driver::where('status', 1)->find($driverActivity->driver_id);
            $driverActivity->lat = $request->driver_lat;
            $driverActivity->lng = $request->driver_long;
            if ($driverActivity->save()) {
                $response = array(
                    "id" => $driverActivity->id,
                    "driver_id" => $driverDetails->id,
                    "fullname" => $driverDetails->fullname,
                    "email" => $driverDetails->email,
                    "phone" => $driverDetails->phone,
                    "status" => $driverActivity->status,
                    "latitude" => $driverActivity->lat ? $driverActivity->lat : "",
                    "longitude" => $driverActivity->lng ? $driverActivity->lng : ""
                    // "latitude" => $driverActivity->lat ? number_format($driverActivity->lat, 8, '.', '') : "",
                    // "longitude" => $driverActivity->lng ? number_format($driverActivity->lng, 8, '.', '') : ""
                );
                return $this->success('location updated succesfully', $response);
            }
            // } else {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Driver is not active'
            //     ], 200);
            // }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }

    public function orderList(Request $request)
    {
        try {
            // $validator = Validator::make($request->all(), [
            //     'order_id' => 'required|string|max:255'
            // ]);
            // if ($validator->fails()) {
            //     return $this->error($validator->errors()->first());
            // }
            $response = [];
            $orderStatus = OrderStatus::where('initial_status', "pending")->with('order')->get();
            if (isset($orderStatus)) {
                $driver = Driver::where('id', Auth::user()->id)->where('status', 1)->first();
                foreach ($orderStatus as $row) {
                    $ordersList = Order::where('id', $row->order_id)->with('package')->first();
                    // if ($ordersList->company_id == $driver->company_id) {
                    Log::info('senderAddress ' . $ordersList->package->sender_address_id);
                    Log::info('recieverAddress ' . $ordersList->package->delivery_address_id);
                    $senderAddress  = Address::where('id', $ordersList->package->sender_address_id)->first();
                    $recieverAddress  = Address::where('id', $ordersList->package->delivery_address_id)->first();
                    // dd($row->order->id);
                    $response[] = array(
                        'id' => $ordersList->id ?  $ordersList->id : '',
                        'order_id' => $ordersList->order_id ?  $ordersList->order_id : '',
                        'chat_id' => $ordersList->chat_id ?  $ordersList->chat_id : '',
                        // 'user_id' => $ordersList->user_id ?  $ordersList->user_id : '',
                        // 'weight' => $ordersList->package->weight ?  $ordersList->package->weight : '',
                        // 'fragile' => $ordersList->package->is_fragile ?  $ordersList->package->is_fragile : 0,
                        // 'air_cool' => $ordersList->package->need_aircool ?  $ordersList->package->need_aircool : 0,
                        // 'vehicle_type' => $ordersList->package->vehicle_type ?  $ordersList->package->vehicle_type : '',
                        // 'address_type' => $address ?  $address->address_type : '',
                        'order_type' => $ordersList->package->order_type ?  $ordersList->package->order_type : '',
                        'date' => $ordersList->package->order_date ?  $ordersList->package->order_date : '',
                        'time' => $ordersList->package->order_time ?  $ordersList->package->order_time : '',
                        'amount' => $ordersList->total_amount ? $ordersList->total_amount : 0,
                        'status' => $ordersList->package->status ?  $ordersList->package->status : '',

                        // sender address details
                        // 'sender_address_id' => $senderAddress->id ?  $senderAddress->id : '',
                        // 'sender_user_id' => $senderAddress->user_id ?  $senderAddress->user_id : '',
                        'sender_address_type' => isset($senderAddress->address_type) ?  $senderAddress->address_type : '',
                        'sender_address' => isset($senderAddress->address) ?  $senderAddress->address : '',
                        // 'sender_name' => $senderAddress->recipient_name ?  $senderAddress->recipient_name : '',
                        // 'sender_phone' => $senderAddress->recipient_phone ?  (string)$senderAddress->recipient_phone : '',
                        // 'sender_is_primary' => $senderAddress->is_primary ?  $senderAddress->is_primary : 0,
                        'sender_city' => isset($senderAddress->city) ? $senderAddress->city : '',
                        'sender_street' => isset($senderAddress->street) ? $senderAddress->street : '',
                        'sender_building' => isset($senderAddress->building) ? $senderAddress->building : '',
                        'sender_apartment' => isset($senderAddress->apartment) ? $senderAddress->apartment : '',
                        // 'sender_longitude' => $senderAddress->longitude ? $senderAddress->longitude : '',
                        // 'sender_latitude' => $senderAddress->latitude ? $senderAddress->latitude : '',
                        // 'sender_type' => $senderAddress->type ? $senderAddress->type : '',

                        // reciever address details
                        // 'reciever_address_id' => $recieverAddress->id ?  $recieverAddress->id : '',
                        // 'reciever_user_id' => $recieverAddress->user_id ?  $recieverAddress->user_id : '',
                        'reciever_address_type' => isset($recieverAddress->address_type) ?  $recieverAddress->address_type : '',
                        'reciever_address' => isset($recieverAddress->address) ?  $recieverAddress->address : '',
                        // 'reciever_name' => $recieverAddress->recipient_name ?  $recieverAddress->recipient_name : '',
                        // 'reciever_phone' => $recieverAddress->recipient_phone ?  (string)$recieverAddress->recipient_phone : '',
                        // 'reciever_is_primary' => $recieverAddress->is_primary ?  $recieverAddress->is_primary : 0,
                        'reciever_city' => isset($recieverAddress->city) ? $recieverAddress->city : '',
                        'reciever_street' => isset($recieverAddress->street) ? $recieverAddress->street : '',
                        'reciever_building' => isset($recieverAddress->building) ? $recieverAddress->building : '',
                        'reciever_apartment' => isset($recieverAddress->apartment) ? $recieverAddress->apartment : '',
                        // 'reciever_longitude' => $recieverAddress->longitude ? $recieverAddress->longitude : '',
                        // 'reciever_latitude' => $recieverAddress->latitude ? $recieverAddress->latitude : '',
                        // 'reciever_type' => $recieverAddress->type ? $recieverAddress->type : '',
                    );
                    // }
                }
                return $this->success('Fetched succesfully', $response);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No orders available!!'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }

    public function orderDetails(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|max:255'
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }

            $orderDetails = OrderStatus::where('order_id', $request->order_id)->with('order')->first();
            if (isset($orderDetails)) {
                $package = Package::where('id', $orderDetails->order->package_id)->first();
                Log::info('order id is ' . $orderDetails->order->id);
                if (isset($package)) {
                    $user = User::where('id', $orderDetails->order->user_id)->first();
                    Log::info('package id is ' . $package->id);

                    $packageMedia = PackageMedia::where('package_id', $package->id)->first();
                    if (isset($packageMedia)) {
                        Log::info('package image is coming empty');
                        $packageImages = $packageMedia->image_url;
                    } else {
                        Log::info('package image is coming good');
                        $packageImages = array();
                    }
                    // exit();
                    if (isset($user)) {
                        $senderAddress  = Address::where('id', $package->sender_address_id)->first();
                        $recieverAddress  = Address::where('id', $package->delivery_address_id)->first();
                        $image_url = [];
                        if (isset($senderAddress) && isset($recieverAddress)) {
                            $response = array(


                                // order details
                                'id' => $orderDetails->order->id ?  $orderDetails->order->id : '',
                                'image' => asset('public/Image/'.$orderDetails->image)?? null,
                                'order_id' => $orderDetails->order->order_id ?  $orderDetails->order->order_id : '',
                                'chat_id' => $orderDetails->order->chat_id ?  $orderDetails->order->chat_id : '',
                                'user_id' => $orderDetails->order->user_id ?  $orderDetails->order->user_id : '',
                                'payment_method' => $orderDetails->order->payment_type ?  $orderDetails->order->payment_type : '',
                                'merchant_id' => $orderDetails->order->merchant_id ?  $orderDetails->order->merchant_id : '',

                                // parcel details
                                'weight' => $package->weight ?  $package->weight : '',
                                'fragile' => $package->is_fragile ?  $package->is_fragile : 0,
                                'air_cool' => $package->need_aircool ?  $package->need_aircool : 0,
                                // 'vehicle_type' => $package->vehicle_type ?  $package->vehicle_type : '',
                                'parcel_description' => $package->parcel_description ?  $package->parcel_description : '',
                                'order_type' => $package->order_type ?  $package->order_type : '',
                                'date' => $package->order_date ?  $package->order_date : '',
                                'time' => $package->order_time ?  $package->order_time : '',
                                'amount' => $orderDetails->order->total_amount ? $orderDetails->order->total_amount : 0,
                                // 'status' => $package->status ?  $package->status : '',
                                // 'vehicle_type' => $package->vehicle_type ?  $package->vehicle_type : '',
                                // 'order_type' => $package->order_type ?  $package->order_type : '',
                                // 'date' => $package->order_date ?  $package->order_date : '',
                                // 'time' => $package->order_time ?  $package->order_time : '',

                                // sender address details
                                // 'sender_address_id' => $senderAddress->id ?  $senderAddress->id : '',
                                // 'sender_user_id' => $senderAddress->user_id ?  $senderAddress->user_id : '',
                                'sender_address_type' => $senderAddress->address_type ?  $senderAddress->address_type : '',
                                'sender_address' => $senderAddress->address ?  $senderAddress->address : '',
                                'sender_name' => $senderAddress->recipient_name ?  $senderAddress->recipient_name : '',
                                'sender_phone' => $senderAddress->recipient_phone ?  (string)$senderAddress->recipient_phone : '',
                                // 'sender_is_primary' => $senderAddress->is_primary ?  $senderAddress->is_primary : 0,
                                'sender_city' => $senderAddress->city ? $senderAddress->city : '',
                                'sender_street' => $senderAddress->street ? $senderAddress->street : '',
                                'sender_building' => $senderAddress->building ? $senderAddress->building : '',
                                'sender_apartment' => $senderAddress->apartment ? $senderAddress->apartment : '',
                                'sender_longitude' => $senderAddress->longitude ? $senderAddress->longitude : '',
                                'sender_latitude' => $senderAddress->latitude ? $senderAddress->latitude : '',
                                // 'sender_type' => $senderAddress->type ? $senderAddress->type : '',

                                // reciever address details
                                // 'reciever_address_id' => $recieverAddress->id ?  $recieverAddress->id : '',
                                // 'reciever_user_id' => $recieverAddress->user_id ?  $recieverAddress->user_id : '',
                                'reciever_address_type' => $recieverAddress->address_type ?  $recieverAddress->address_type : '',
                                'reciever_address' => $recieverAddress->address ?  $recieverAddress->address : '',
                                'reciever_name' => $recieverAddress->recipient_name ?  $recieverAddress->recipient_name : '',
                                'reciever_phone' => $recieverAddress->recipient_phone ?  (string)$recieverAddress->recipient_phone : '',
                                // 'reciever_is_primary' => $recieverAddress->is_primary ?  $recieverAddress->is_primary : 0,
                                'reciever_city' => $recieverAddress->city ? $recieverAddress->city : '',
                                'reciever_street' => $recieverAddress->street ? $recieverAddress->street : '',
                                'reciever_building' => $recieverAddress->building ? $recieverAddress->building : '',
                                'reciever_apartment' => $recieverAddress->apartment ? $recieverAddress->apartment : '',
                                'reciever_longitude' => $recieverAddress->longitude ? $recieverAddress->longitude : '',
                                'reciever_latitude' => $recieverAddress->latitude ? $recieverAddress->latitude : '',
                                'images' => $packageImages
                                // 'reciever_type' => $recieverAddress->type ? $recieverAddress->type : '',

                                // user details
                                // 'user_id' => $user->id ?  $user->id : '',
                                // 'firstname' => $user->firstname ?  $user->firstname : '',
                                // 'lastname' => $user->lastname ?  $user->lastname : '',
                                // 'email' => $user->email ?  $user->email : '',
                                // 'phone' => $user->phone ?  (string)$user->phone : '',


                            );
                            return $this->success('Fetched succesfully', $response);
                        } else {
                            return response()->json([
                                'status' => 'error',
                                'message' => 'Address doesnot exist'
                            ], 200);
                        }
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'User doesnot exist'
                        ], 200);
                    }
                    // address

                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Package doesnot exist'
                    ], 200);
                }
                // user

            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'order doesnot exist'
                ], 200);
            }
            // package

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }


    public function acceptOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'driver_id' => 'required|max:255',
                'order_id' => 'required|max:255'
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }

            $checkDriver = Driver::find($request->driver_id);
            if (isset($checkDriver)) {
                Log::info("api --acceptOrder -- existing driver " . $checkDriver->id);
                $acceptOrder = OrderStatus::where('order_id', $request->order_id)->first();
                if (isset($acceptOrder)) {
                    Log::info("api --acceptOrder -- orderstatus id " . $acceptOrder->id);
                    $acceptOrder->initial_status = 'done';
                    $acceptOrder->approved_status = 'approve';
                    $acceptOrder->driver_status = 'approve';
                    $acceptOrder->driver_collected_status = 'pending';
                    $acceptOrder->delivery_status = 'pending';
                    $acceptOrder->driver_id = $checkDriver->id;
                    $acceptOrder->save();
                    $orderStatus = Order::where('id', $request->order_id)->first();
                    $orderStatus->update([
                        'status' => "Driver assigned",
                    ]);
                    Log::info("api --acceptOrder -- updated successfully " . $acceptOrder->id);
                    $response = array(
                        "order_id" => $acceptOrder->order_id,
                        "driver_id" => $acceptOrder->driver_id

                    );

                    return $this->success('accepted succesfully', $response);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Order not exist!!'
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Driver not exist!!'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }

    public function activeOrders(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'driver_id' => 'required|max:255'
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }
            $checkdriver = Driver::find($request->driver_id);
            if (isset($checkdriver)) {
                $activeOrders = OrderStatus::where('driver_id', $checkdriver->id)->where('approved_status', 'approve')->get();
                if (isset($activeOrders)) {
                    $data = [];
                    foreach ($activeOrders as $activeOrder) {
                        $ordersList = Order::where('id', $activeOrder->order_id)->with('package')->first();
                        $senderAddress  = Address::where('id', $ordersList->package->sender_address_id)->first();
                        $recieverAddress  = Address::where('id', $ordersList->package->delivery_address_id)->first();
                        $data[] = array(
                            "id" => $ordersList->id,
                            "order_id" => $ordersList->order_id,
                            "date" => $ordersList->package->order_date,
                            "time" => $ordersList->package->order_time ? $ordersList->package->order_time : '',
                            "order_type" => $ordersList->package->order_type ?  $ordersList->package->order_type : '',

                            'sender_city' => $senderAddress->city ? $senderAddress->city : '',
                            'sender_street' => $senderAddress->street ? $senderAddress->street : '',
                            'sender_building' => $senderAddress->building ? $senderAddress->building : '',
                            'sender_apartment' => $senderAddress->apartment ? $senderAddress->apartment : '',

                            'reciever_city' => $recieverAddress->city ? $recieverAddress->city : '',
                            'reciever_street' => $recieverAddress->street ? $recieverAddress->street : '',
                            'reciever_building' => $recieverAddress->building ? $recieverAddress->building : '',
                            'reciever_apartment' => $recieverAddress->apartment ? $recieverAddress->apartment : '',
                        );
                    }
                    return $this->success('accepted succesfully', $data);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'no actiove orders available'
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Driver not exist!!'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }

    public function deliverHistory(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'driver_id' => 'required|max:255'
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }
            $checkdriver = Driver::find($request->driver_id);
            if (isset($checkdriver)) {
                $activeOrders = OrderStatus::where('driver_id', $checkdriver->id)->where('delivery_status', 'delivered')->get();
                if (isset($activeOrders)) {
                    $data = [];
                    foreach ($activeOrders as $activeOrder) {
                        $ordersList = Order::where('id', $activeOrder->order_id)->with('package')->first();
                        $senderAddress  = Address::where('id', $ordersList->package->sender_address_id)->first();
                        $recieverAddress  = Address::where('id', $ordersList->package->delivery_address_id)->first();
                        $data[] = array(
                            "id" => $ordersList->id,
                            "order_id" => $ordersList->order_id,
                            "date" => $ordersList->package->order_date,
                            "time" => $ordersList->package->order_time ? $ordersList->package->order_time : '',
                            "order_type" => $ordersList->package->order_type ?  $ordersList->package->order_type : '',

                            'sender_city' => $senderAddress->city ? $senderAddress->city : '',
                            'sender_street' => $senderAddress->street ? $senderAddress->street : '',
                            'sender_building' => $senderAddress->building ? $senderAddress->building : '',
                            'sender_apartment' => $senderAddress->apartment ? $senderAddress->apartment : '',

                            'reciever_city' => $recieverAddress->city ? $recieverAddress->city : '',
                            'reciever_street' => $recieverAddress->street ? $recieverAddress->street : '',
                            'reciever_building' => $recieverAddress->building ? $recieverAddress->building : '',
                            'reciever_apartment' => $recieverAddress->apartment ? $recieverAddress->apartment : '',
                        );
                    }
                    if (empty($data)) {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'No deliver history available'
                        ], 200);
                    }
                    return $this->success('deliver history', $data);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No deliver history available'
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Driver not exist!!'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }

    public function deliverOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'driver_id' => 'required|max:255',
                'order_id' => 'required|max:255'
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }
            $checkDriver = Driver::find($request->driver_id);
            if (isset($checkDriver)) {
                Log::info("api --acceptOrder -- existing driver " . $checkDriver->id);
                $acceptOrder = OrderStatus::where('order_id', $request->order_id)->first();
                if (isset($acceptOrder)) {

                    if($request->file('image')){
                        $file= $request->file('image');
                        $filename= date('YmdHi').$file->getClientOriginalName();
                        $file-> move(public_path('public/Image'), $filename);
                        $acceptOrder['image']= $filename;
                    }

                    Log::info("api --acceptOrder -- orderstatus id " . $acceptOrder->id);
                    $acceptOrder->initial_status = 'done';
                    $acceptOrder->approved_status = 'done';
                    $acceptOrder->driver_status = 'done';
                    $acceptOrder->driver_collected_status = 'done';
                    $acceptOrder->delivery_status = 'delivered';
                    $acceptOrder->driver_id = $checkDriver->id;
                    $acceptOrder->save();
                    $orderStatus = Order::where('id', $request->order_id)->first();
                    $orderStatus->update([
                        'status' => "Delivered",
                    ]);



                    Log::info("api --acceptOrder -- updated successfully " . $acceptOrder->id);
                    $response = array(
                        "order_id" => $acceptOrder->order_id,
                        "driver_id" => $acceptOrder->driver_id,
                        'image' => 

                    );

                    return $this->success('delivered succesfully', $response);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Order not exist!!'
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Driver not exist!!'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }
    public function reviewDriver(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required|max:255',
                'customer_rating' => 'required|integer',
                'customer_comment' => 'required|string',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }
            $acceptOrder = OrderStatus::where('order_id', $request->order_id)->first();
            if (isset($acceptOrder)) {
                if ($acceptOrder->driver_id != null) {
                    if ($acceptOrder->delivery_status == 'delivered') {
                        $acceptOrder->update([
                            'customer_rating' => $request->customer_rating,
                            'customer_comment' => $request->customer_comment
                        ]);
                        Log::info("api --reviewDriver -- reviewed successfully " . $acceptOrder->id);
                        $response = array(
                            "order_id" => $acceptOrder->order_id,
                            "driver_id" => $acceptOrder->driver_id

                        );
                        return $this->success('Reviewed succesfully', $response);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Order not delivered yet!!'
                        ], 200);
                    }
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Driver not assign!!'
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not exist!!'
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }

    public function profileImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
                'driver_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }
            if (isset($request->driver_id)) {
                $existingDriver = Driver::find($request->driver_id);
                if (isset($existingDriver)) {

                    // profile image upload
                    $profileImage = $request->file('image');
                    $filenamewithextension = $profileImage->getClientOriginalName();
                    $profilename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $extension = $profileImage->getClientOriginalExtension();

                    $profilenametostore = uniqid() . '.' . $extension;

                    Storage::put('public/driver/profile/' . $profilenametostore, fopen($profileImage, 'r+'));
                    Storage::put('public/driver/profile/thumbnail/' . $profilenametostore, fopen($profileImage, 'r+'));

                    $profileThumbnailpath = public_path('storage/driver/profile/thumbnail/' . $profilenametostore);
                    $img = Image::make($profileThumbnailpath);
                    $img->resize(500, 500, function ($const) {
                        $const->aspectRatio();
                    })->save($profileThumbnailpath);

                    // $filePath = public_path('uploads/user_profile/images');
                    // $image->move($filePath, $input['imagename']);

                    $driver = Driver::where('id', $existingDriver->id)->where('status', 1)
                        ->update([
                            'profile' => $profilenametostore,
                        ]);

                    $driverData = Driver::find($existingDriver->id);
                    // dd($driverData->image_url);
                    if ($driverData->fullname) {
                        $fullname = explode(' ', $driverData->fullname);
                        $firstname = $fullname[0];
                        $lastname =  $fullname[1];
                    }
                    // $path = 'uploads/user_profile/thumb';
                    // $profileImage = config('app.url') . '/' . $path . '/' . $driverData->profile;
                    $data = array(
                        'id' => $driverData->id ?  $driverData->id : '',
                        'email' => $driverData->email ?  $driverData->email : '',
                        'phone' => $driverData->phone ?  (string)$driverData->phone : '',
                        'firstname' => $fullname ?  $firstname : '',
                        'lastname' => $fullname ?  $lastname : '',
                        'emirates_id' => $driverData->emirates_id ?  $driverData->emirates_id : '',
                        'address' => $driverData->address ?  $driverData->address : '',
                        'city' => $driverData->city ?  $driverData->city : '',
                        'profile_image' => $driverData->image_url ?  $driverData->image_url : ''
                    );
                    return $this->success('Driver profile updated Successfully', $data);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "user does not exist."
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "user id is a required field"
                ], 200);
            }
        } catch (Exception $e) {
            // return $this->error('Something went wrong, Please try again later.', 200);
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, Please try again later."
            ], 200);
        }
    }

    public function vehicleAvailability(Request $request)
    {
        try {
            $driverActivities = DriverActivity::where('status', 'active')->get()->toArray();
            if (empty($driverActivities)) {
                return response()->json([
                    'status' => 'success',
                    'message' => "Currently no driver available."
                ], 200);
            }
            $driverIds = array_column($driverActivities, 'driver_id');
            $vehicles = Vehicle::whereIn('driver_id', $driverIds)->get()->toArray();
            $vehicleTypes = array_column($vehicles, 'type');

            if (in_array('bike', $vehicleTypes)) {
                $bikeAvailable = true;
            } else {
                $bikeAvailable = false;
            }

            if (in_array('car', $vehicleTypes)) {
                $carAvailable = true;
            } else {
                $carAvailable = false;
            }

            if (in_array('van', $vehicleTypes)) {
                $vanAvailable = true;
            } else {
                $vanAvailable = false;
            }
            $response = array(
                "bike_availability" => $bikeAvailable,
                "car_availability" => $carAvailable,
                "van_availability" => $vanAvailable
            );
            return $this->success('success', $response);
        } catch (Exception $e) {
            // return $this->error('Something went wrong, Please try again later.', 200);
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, Please try again later."
            ], 200);
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


     public function company_offres()
     {
        try {
            $data = [];

            $CompanyOffres =  CompanyOffres::all();

            if (isset($CompanyOffres)) {
                foreach ($CompanyOffres as $offers) {
                    $data[] = array(
                        'id' => $offers->id,
                        'Company' => $offers->name,
                        'offres' => $offers->offres,
                    );
                }
            }

            return $this->success('return Company Offres Success ', $data);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
     }

    public function getOfferDeliver()
    {

        try {
            $data = [];

            $OffersDivere =  OffersDivere::all();

            if (isset($OffersDivere)) {
                foreach ($OffersDivere as $offers) {
                    $data[] = array(
                        'id' => $offers->id,
                        'driver_id' => $offers->driver->id,
                        'driver_name' => $offers->driver->fullname,
                        'offers' => $offers->offers,

                    );
                }
            }

            return $this->success('return Offers driver Success ', $data);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }


    public function createOfferDeliver(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'offers' => 'required|string|min:2'
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }

            $checkDriver = Driver::where('id', auth()->id())->where('status', true)->first();
            $data = [];

            if (isset($checkDriver)) {
                $data[] = OffersDivere::updateOrcreate([
                    'driver_id' => auth()->id()
                ], [
                    'driver_id' => auth()->id(),
                    'offers' => $request->offers,
                    'type' => OffersDivere::CREATENEWOFFER,
                ]);

                return $this->success('Created Offers driver Success ', $data);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Somethingwent wrong, please try again later!!'
                ], 200);
            }



        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }


    public function acceptOfferDriver(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'offers' => 'required|string|min:2',
                'driver_id' =>'required',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }

            $checkDriver = Driver::where('id', $request->driver_id)->where('status', true)->first();
            $data = [];

            if (isset($checkDriver)) {
                $data[] = OffersDivere::updateOrcreate([
                    'driver_id' => $request->driver_id
                ], [
                    'driver_id' => $request->driver_id,
                    'user_id' => auth()->id(),
                    'offers' => $request->offers,
                    'type' => OffersDivere::AGREEMENTOFFER,
                ]);

                return $this->success('Offer successfully acceptedt', $data);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Somethingwent wrong, please try again later!!'
                ], 200);
            }


        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Somethingwent wrong, please try again later!!'
            ], 200);
        }
    }
}

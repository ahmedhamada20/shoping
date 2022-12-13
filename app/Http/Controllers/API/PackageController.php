<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Package;
use App\User;
use App\Address;
use DB;
use Image;
use App\PackageMedia;
use App\Services\GeoMapper;
use App\Order;
use App\Company;
use App\Rate;
use Log;
use App\SpecialCity;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        try {
            if (isset($request->package_id)) {
                $existingPackage = Package::find($request->package_id);
                if ($existingPackage) {
                    $package = Package::where('id', $existingPackage->id)->first();
                    $response = [];
                    // foreach ($packages as $package) {
                    $address = Address::where('id', $package->delivery_address_id)->first();
                    $UserDetails = User::find($package->user_id);
                    // $packageMedia = PackageMedia::where('package_id', $package->id)->first();
                    // $path = public_path() . '/uploads/packages/thumb';
                    // $orderImage = $path . '/' . $packageMedia->image;
                    // dd($orderImage);
                    $response = array(
                        'id' => $package->id ?  $package->id : '',
                        'parcel_id' => $package->parcel_id ?  $package->parcel_id : '',
                        'user_id' => $package->user_id ?  $package->user_id : '',
                        'status' => $package->status ?  $package->status : '',
                        'parcel_description' => $package->parcel_description ?  $package->parcel_description : '',
                        'weight' => $package->weight ?  $package->weight : '',
                        'fragile' => $package->is_fragile ?  $package->is_fragile : 0,
                        'air_cool' => $package->need_aircool ?  $package->need_aircool : 0,
                        'vehicle_type' => $package->vehicle_type ?  $package->vehicle_type : '',

                        'additional_notes' => $package->additional_notes ?  $package->additional_notes : '',
                        'amount' => $package->amount ? $package->amount : '',
                        'address_type' => $address->address_type ?  $address->address_type : '',
                        'order_type' => $package->order_type ?  $package->order_type : '',
                        'date' => $package->order_date ?  $package->order_date : '',
                        'time' => $package->order_time ?  $package->order_time : '',
                        // 'payment_method' => $package->payment_method ?  $package->payment_method : '',

                        'recipient_name' => $package->recipient_name ?  $package->recipient_name : '',
                        'recipient_phone' => $package->recipient_phone ?  (string)$package->recipient_phone : '',
                        'recipient_location' => $address->address ?  $address->address : '',
                        'city' => $address->city ? $address->city : '',
                        'street' => $address->street ? $address->street : '',
                        'building' => $address->building ? $address->building : '',
                        'apartment' => $address->apartment ? $address->apartment : '',
                        'longitude' => $address->longitude ? $address->longitude : '',
                        'latitude' => $address->latitude ? $address->latitude : '',

                        'senderphone' => $UserDetails ?  (string)$UserDetails->phone : '',
                        'sendername' => $UserDetails ?  $UserDetails->firstname . ' ' . $UserDetails->lastname : '',
                        'senderlocation' => $package->user_location ?  $package->user_location : '',
                    );
                    // }
                    $data = $response;
                    return $this->success('Fetched address Successfully', $data);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Package doest not exist."
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "Package id is a required field"
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

    /**
     * function to create unique key
     *
     * @return response()
     */
    public function generateUniqueCode()
    {
        do {
            $parcel_id = random_int(100000, 999999);
        } while (Package::where("parcel_id", "=", $parcel_id)->first());

        return $parcel_id;
    }

    public function build_sorter($key)
    {
        return function ($a, $b) use ($key) {
            return strnatcmp($a[$key], $b[$key]);
        };
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'parcel_description' => 'required|max:300',
                'weight' => 'required|string',
                'vehicle_type' => 'required',
                'delivery_address_id' => 'required|integer',
                'sender_address_id' => 'required|integer',
                'is_fragile' => 'required',
                'need_aircool' => 'required',
                'image' => 'required',
                'additional_notes' => 'max:300',
                'date' => 'required',
                'time' => 'required',
                // "amount" => 'required',
            ]);
            if ($validator->fails()) {
                // return $this->error($validator->errors()->first(), 200);
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 200);
            }
            // $bytes = random_bytes(20);echo unique_code(9);
            // dd($this->generateUniqueCode());
            $userId = $request->user_id;
            $existingUser = User::find($userId);

            if ($existingUser) {
                DB::transaction(function () use ($request, $existingUser, &$data, &$package) {
                    if (empty($request->delivery_address_id)) {
                        $address = new Address;
                        $address->user_id = $existingUser->id;
                        $address->address = $request->delivery_address;
                        $address->address_type = $request->address_type;
                        $address->recipient_name = $request->recipient_name;
                        $address->recipient_phone = $request->recipient_phone;
                        $address->city = $request->city;
                        $address->street = $request->street;
                        $address->building = $request->building;
                        $address->apartment = $request->apartment;
                        $address->longitude = $request->longitude;
                        $address->latitude = $request->latitude;
                        $address->status = 1;
                        if ($request->type == "reciever") {
                            $address->type = $request->type;
                        } else {
                            $address->type = $request->type;
                        }
                        $address->save();
                    }

                    $package = new Package;
                    $package->user_id = $request->user_id;
                    $package->parcel_id = $this->generateUniqueCode();
                    // $package->parcel_id = '#' . uniqid();
                    $package->parcel_description = $request->parcel_description;
                    $package->weight = $request->weight;
                    $package->vehicle_type = $request->vehicle_type;
                    $package->user_location = $request->user_location;
                    $package->is_fragile = $request->is_fragile;
                    $package->need_aircool = $request->need_aircool;
                    $package->recipient_name = $request->recipient_name;
                    $package->recipient_phone = $request->recipient_phone;
                    $package->additional_notes = $request->additional_notes;
                    // $package->image = $request->image;
                    $package->order_date = $request->date;
                    $package->order_time = $request->time;
                    $package->order_type = $request->order_type;
                    $package->status = "pending";
                    // $package->amount = $request->amount;
                    // $package->payment_method = $request->payment_method;


                    // check address id values
                    if ($request->delivery_address_id == $request->sender_address_id) {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Delivery address and sender address should be different"
                        ], 200);
                    }

                    if ($request->delivery_address_id) {
                        $package->delivery_address_id = $request->delivery_address_id;

                        $address = Address::where('id', $package->delivery_address_id)->first();
                        $recieverAddresslat = $address->latitude;
                        $recieverAddresslong = $address->longitude;
                    } else {
                        $package->delivery_address_id = $address->id;

                        $recieverAddresslat = $address->latitude;
                        $recieverAddresslong = $address->longitude;
                    }
                    $distance = 0;
                    if (isset($request->sender_address_id)) {
                        $senderAddress = Address::where('id', $request->sender_address_id)->first();
                        if ($senderAddress) {
                            $package->sender_address_id = $senderAddress->id;

                            $senderAddressId = $senderAddress->id;
                            $senderAddresslat = $senderAddress->latitude;
                            $senderAddresslong = $senderAddress->longitude;

                            $geoMapper = new GeoMapper;
                            $distance = $geoMapper->calculateDistance($senderAddresslat, $senderAddresslong, $recieverAddresslat, $recieverAddresslong);
                        }
                    }



                    /**
                     * total amount calculation portion
                     * bike = 5 AED
                     * car = 10 AED
                     * van = 15 AED
                     * per kilometer = 10 AED
                     * per KG = 5 AED
                     * aircondition = 5 AED
                     * 
                     */
                    // $companies = Company::where('status', 1)->with('rate')->get();
                    // if (empty($companies)) {
                    //     return response()->json([
                    //         'status' => 'error',
                    //         'message' => "Companies not available."
                    //     ], 200);
                    // }
                    // total product weight price (weight * price).
                    // foreach ($companies as $company) {
                    //     $totalKiloPrice = (int)$company->rate->per_kilogram_rate  * $request->weight;
                    //     Log::info("Company name " . $company->name);
                    //     Log::info("total kilogram price " . $totalKiloPrice);

                    //     if ($request->need_aircool == true) {
                    //         Log::info("aircool needed");
                    //         if ($request->vehicle_type == "van") {
                    //             Log::info("vehicle is van");
                    //             if ($distance > 0 && $distance < 50) {
                    //                 Log::info("distance inside city " . $distance);
                    //                 $totalDistance = (int)$company->rate->inside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->inside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else if ($distance > 50 && $distance < 150) {
                    //                 $totalDistance = (int)$company->rate->outside_city * $distance;
                    // echo nl2br (" \n ");
                    // print_r('vanrate'.$company->rate->van_rate);
                    // echo nl2br (" \n ");
                    // print_r('outside_city'.$company->rate->outside_city);
                    // echo nl2br (" \n ");
                    // print_r('kilo'.$totalKiloPrice);
                    // echo nl2br (" \n ");
                    // print_r('air cool'.$company->rate->air_cool_rate);
                    // echo nl2br (" \n ");
                    // echo nl2br ("--------------------- ");
                    // echo nl2br (" \n ");
                    //                 Log::info("distance outside city " . $distance);
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->outside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else if ($distance > 150 && $distance < 250) {
                    //                 Log::info("distance between emirates " . $distance);
                    //                 $totalDistance = (int)$company->rate->between_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->between_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else if ($distance > 250 && $distance < 500) {
                    //                 Log::info("distance north emirates " . $distance);
                    //                 $totalDistance = (int)$company->rate->north_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else {
                    //                 Log::info("distance outside north emirates " . $distance);
                    //                 $totalDistance = (int)$company->rate->north_emirates * 500;
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             }
                    //             // $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                    //         } else if ($request->vehicle_type == "car") {
                    //             Log::info("vehicle is car");
                    //             if ($distance > 0 && $distance < 50) {
                    //                 Log::info("distance inside city " . $distance);
                    //                 $totalDistance = (int)$company->rate->inside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->inside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else if ($distance > 50 && $distance < 150) {
                    //                 Log::info("distance outside city " . $distance);
                    //                 $totalDistance = (int)$company->rate->outside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->outside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else if ($distance > 150 && $distance < 250) {
                    //                 Log::info("distance between emirates " . $distance);
                    //                 $totalDistance = (int)$company->rate->between_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->between_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else if ($distance > 250 && $distance < 500) {
                    //                 Log::info("distance north emirates " . $distance);
                    //                 $totalDistance = (int)$company->rate->north_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else {
                    //                 Log::info("distance outside north emirates " . $distance);
                    //                 $totalDistance = (int)$company->rate->north_emirates * 500;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             }
                    //             // $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                    //         } else {
                    //             Log::info("vehicle is bike");
                    //             if ($distance > 0 && $distance < 50) {
                    //                 Log::info("distance inside city " . $distance);
                    //                 $totalDistance = (int)$company->rate->inside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->inside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else if ($distance > 50 && $distance < 150) {
                    //                 Log::info("distance outside city " . $distance);
                    //                 $totalDistance = (int)$company->rate->outside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->outside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else if ($distance > 150 && $distance < 250) {
                    //                 Log::info("distance between emirates " . $distance);
                    //                 $totalDistance = (int)$company->rate->between_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->between_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else if ($distance > 250 && $distance < 500) {
                    //                 Log::info("distance north emirates " . $distance);
                    //                 $totalDistance = (int)$company->rate->north_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             } else {
                    //                 Log::info("distance outside north emirates " . $distance);
                    //                 $totalDistance = (int)$company->rate->north_emirates * 500;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             }
                    //             // $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                    //             $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                    //         }
                    //     } else {
                    //         Log::info("aircool not needed NOTE : Else Condition");
                    //         // airecool is not needed
                    //         if ($request->vehicle_type == "van") {
                    //             Log::info("vehicle is car");
                    //             if ($distance > 0 && $distance < 50) {
                    //                 Log::info("distance inside city " . $distance);
                    //                 // $totalDistance = (int)$company->rate->inside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->inside_city + $totalKiloPrice;
                    //             } else if ($distance > 50 && $distance < 150) {
                    //                 Log::info("distance outside city " . $distance);
                    //                 // $totalDistance = (int)$company->rate->outside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->outside_city + $totalKiloPrice;
                    //             } else if ($distance > 150 && $distance < 250) {
                    //                 Log::info("distance between emirates " . $distance);
                    //                 // $totalDistance = (int)$company->rate->between_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->between_emirates + $totalKiloPrice;
                    //             } else if ($distance > 250 && $distance < 500) {
                    //                 Log::info("distance north emirates " . $distance);
                    //                 // $totalDistance = (int)$company->rate->north_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                    //             } else {
                    //                 Log::info("distance outside north emirates " . $distance);
                    //                 // $totalDistance = (int)$company->rate->north_emirates * 500;
                    //                 $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                    //             }
                    //             // $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice;
                    //             $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                    //         } else if ($request->vehicle_type == "car") {
                    //             Log::info("distance inside city " . $distance);
                    //             if ($distance > 0 && $distance < 50) {
                    //                 // $totalDistance = (int)$company->rate->inside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->inside_city + $totalKiloPrice;
                    //             } else if ($distance > 50 && $distance < 150) {
                    //                 Log::info("distance outside city " . $distance);
                    //                 // $totalDistance = (int)$company->rate->outside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->outside_city + $totalKiloPrice;
                    //             } else if ($distance > 150 && $distance < 250) {
                    //                 Log::info("distance between emirates " . $distance);
                    //                 // $totalDistance = (int)$company->rate->between_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->between_emirates + $totalKiloPrice;
                    //             } else if ($distance > 250 && $distance < 500) {
                    //                 Log::info("distance north emirates " . $distance);
                    //                 // $totalDistance = (int)$company->rate->north_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                    //             } else {
                    //                 Log::info("distance outside north emirates " . $distance);
                    //                 // $totalDistance = (int)$company->rate->north_emirates * 500;
                    //                 $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                    //             }
                    //             // $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice;
                    //             $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                    //         } else {
                    //             if ($distance > 0 && $distance < 50) {
                    //                 Log::info("distance inside city " . $distance);
                    //                 // $totalDistance = (int)$company->rate->inside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->inside_city + $totalKiloPrice;
                    //             } else if ($distance > 50 && $distance < 150) {
                    //                 Log::info("distance outside city " . $distance);
                    //                 // $totalDistance = (int)$company->rate->outside_city * $distance;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->outside_city + $totalKiloPrice;
                    //             } else if ($distance > 150 && $distance < 250) {
                    //                 Log::info("distance between emirates " . $distance);
                    //                 // $totalDistance = (int)$company->rate->between_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->between_emirates + $totalKiloPrice;
                    //             } else if ($distance > 250 && $distance < 500) {
                    //                 Log::info("distance north emirates " . $distance);
                    //                 // $totalDistance = (int)$company->rate->north_emirates * $distance;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                    //             } else {
                    //                 Log::info("distance outside north emirates " . $distance);
                    //                 // $totalDistance = (int)$company->rate->north_emirates * 500;
                    //                 $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                    //             }
                    //             $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                    //         }
                    //     }
                    // }
                    // usort($response, $this->build_sorter('total_amount'));
                    // $companies = array_slice($response, 0, 3);
                    // return response()->json([
                    //     'status' => 'success',
                    //     'message' => "Companies list retrieved.",
                    //     'data' => $companies
                    // ], 200);

                    // usort($response, $this->build_sorter('total_amount'));

                    // print_r($response);
                    // exit();

                    // $vehiclePrice = 0;
                    // if ($request->vehicle_type == "van") {
                    //     $vehiclePrice = 15;
                    // } else if ($request->vehicle_type == "car") {
                    //     $vehiclePrice = 10;
                    // } else {
                    //     $vehiclePrice = 5;
                    // }
                    // $airconditonPrice = $request->need_aircool ? 5 : 0;
                    // $perKgWeight = 5;
                    // $perKilometerPrice = 10;
                    // $totalWeightPrice = $perKgWeight * $request->weight;
                    // if (is_numeric($distance)) {
                    //     $totalDistancePrice = $distance ? ($distance * $perKilometerPrice) : 0;
                    // } else {
                    //     $totalDistancePrice =  0;
                    // }


                    // $totalAmount = $vehiclePrice + $totalWeightPrice + $totalDistancePrice + $airconditonPrice;
                    // echo $distance;
                    // echo "==";
                    // echo $vehiclePrice;
                    // echo "+";
                    // echo $totalWeightPrice;
                    // echo "+";
                    // echo $totalDistancePrice;
                    // echo "+";
                    // echo $airconditonPrice;
                    // echo "=";
                    // print_r($totalAmount);
                    // exit();

                    // $package->amount = number_format($response[0]['total_amount'],  2, '.', '');
                    // $package->amount = "";
                    $package->save();

                    // package image upload

                    if ($request->hasFile('image')) {
                        Log::info("image file is exist");
                        Log::info("count of images : " . count($request->file('image')));

                        $imageName = '';
                        $i = 0;
                        foreach ($request->file('image') as $file) {
                            Log::info("image file details : " . ++$i . " : " . $file);


                            //get filename with extension
                            $filenamewithextension = $file->getClientOriginalName();
                            Log::info("image original name : " . ++$i . " : " . $file->getClientOriginalName());

                            //get filename without extension
                            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                            Log::info("image original name : " . ++$i . " : " . $filename);

                            //get file extension
                            $extension = $file->getClientOriginalExtension();
                            Log::info("image extention name : " . ++$i . " : " . $extension);

                            //filename to store
                            $filenametostore = uniqid() . '.' . $extension;
                            Log::info("filename : " . ++$i . " : " . $filenametostore);

                            $imageName =  $imageName . $filenametostore . ",";
                            // Storage::put('public/packages/' . $filenametostore, fopen($file, 'r+'));
                            Storage::put('public/packages/thumbnail/' . $filenametostore, fopen($file, 'r+'));

                            //Resize image here
                            $thumbnailpath = public_path('storage/packages/thumbnail/' . $filenametostore);
                            $img = Image::make($thumbnailpath)->resize(1000, 900, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                            $img->save($thumbnailpath);
                        }
                        $allfilename = $imageName;
                        Log::info("package image is stored : Loop count " . ++$i . " Name: " . $imageName);
                        $packageMedia = new PackageMedia;
                        $packageMedia->image = rtrim($allfilename, ',');
                        $packageMedia->package_id = $package->id;
                        $packageMedia->save();
                    }

                    if ($package) {
                        $UserDetails = User::find($package->user_id);
                        $data = array(
                            'id' => $package->id  ?  $package->id : '',
                            'user_id' => $package->user_id ?  $package->user_id : '',
                            'parcel_id' => $package->parcel_id ?  $package->parcel_id : '',
                            'status' => $package->status ?  $package->status : '',
                            'vehicle_type' => $package->vehicle_type ?  $package->vehicle_type : '',
                            // 'sender location' => $package->user_location ?  $package->user_location : '',
                            'amount' => $package->amount ? $package->amount  : 0,
                            'parcel_weight' => $package->weight ?  $package->weight . "kg" : '',
                            'date' => $package->order_date ?  $package->order_date : '',
                            'time' => $package->order_time ?  $package->order_time : '',
                            'order_type' => $package->order_type ?  $package->order_type : '',
                            'parcel_description' => $package->parcel_description ?  $package->parcel_description : '',
                            'address_type' => $address->address_type ?  $address->address_type : '',
                            // 'userlocation' => $address->address ?  $address->address : '',
                            // 'payment_method' => $package->payment_method ?  $package->payment_method : '',

                            'recipient_name' => $package->recipient_name ?  $package->recipient_name : '',
                            'recipient_phone' => $package->recipient_phone ?  (string)$package->recipient_phone : '',
                            'recipient_location' => $address->address ?  $address->address : '',

                            'senderphone' => $UserDetails ?  (string)$UserDetails->phone : '',
                            'sendername' => $UserDetails ?  $UserDetails->firstname . ' ' . $UserDetails->lastname : '',
                            'senderlocation' => $package->user_location ?  $package->user_location : '',
                            'companies' => [],
                        );
                    }
                });

                return $this->success('Package placed Successfully', $data);
            } else {
                // return $this->error(, 200);
                return response()->json([
                    'status' => 'error',
                    'message' => 'user does not exist'
                ], 200);
            }
        } catch (Exception $e) {
            return $this->error('Something went wrong, Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        try {
            if (isset($request->user_id)) {
                $existingUser = User::find($request->user_id);
                if ($existingUser) {
                    $orders = Order::where("user_id", $existingUser->id)->get();
                    $response = [];
                    foreach ($orders as $order) {
                        $package = Package::where('id', $order->package_id)->orderBy('created_at', 'desc')->first();

                        $address = Address::where('id', $package->delivery_address_id)->first();
                        $UserDetails = User::find($package->user_id);
                        $response[] = array(
                            'id' => $order->id ?  $order->id : '',
                            'parcel_id' => $order->order_id ?  $order->order_id : '',
                            'user_id' => $package->user_id ?  $package->user_id : '',
                            'weight' => $package->weight ?  $package->weight : '',
                            'fragile' => $package->is_fragile ?  $package->is_fragile : 0,
                            'air_cool' => $package->need_aircool ?  $package->need_aircool : 0,
                            'vehicle_type' => $package->vehicle_type ?  $package->vehicle_type : '',
                            'address_type' => $address ?  $address->address_type : '',
                            // 'order_type' => $package->order_type ?  $package->order_type : '',
                            'order_type' => $package->order_type ?  "send" : 'send',
                            'date' => $package->order_date ?  $package->order_date : '',
                            'time' => $package->order_time ?  $package->order_time : '',
                            'amount' => $package->amount ? $package->amount : 0,
                            'status' => $order->status ?  $order->status : '',
                            // 'payment_method' => $package->payment_method ?  $package->payment_method : '',
                            // 'userlocation' => $package->user_location ?  $package->user_location : '',
                            'recipient_phone' => $package->recipient_phone ?  (string)$package->recipient_phone : '',
                            'recipient_name' => $package->recipient_name ?  $package->recipient_name : '',
                            'recipient_location' => $address ?  $address->address : '',

                            'senderphone' => $UserDetails ?  (string)$UserDetails->phone : '',
                            'sendername' => $UserDetails ?  $UserDetails->firstname . ' ' . $UserDetails->lastname : '',
                            'senderlocation' => $package->user_location ?  $package->user_location : '',
                        );
                    }

                    // dd($packages);

                    // foreach ($packages as $package) {

                    // }
                    $data = $response;
                    return $this->success('Fetched address Successfully', $data);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "User does not exist"
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "user id field is required."
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function shippingType(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'weight' => 'required',
                'vehicle_type' => 'required',
                'delivery_address_id' => 'required|integer',
                'sender_address_id' => 'required|integer',
                'need_aircool' => 'required',
            ]);
            if ($validator->fails()) {
                // return $this->error($validator->errors()->first(), 200);
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 200);
            }
            $userId = $request->user_id;
            $existingUser = User::find($userId);
            // dd($existingUser);
            if ($existingUser) {
                // if (empty($request->delivery_address_id)) {
                //     $address = new Address;
                //     $address->user_id = $existingUser->id;
                //     $address->address = $request->delivery_address;
                //     $address->address_type = $request->address_type;
                //     $address->recipient_name = $request->recipient_name;
                //     $address->recipient_phone = $request->recipient_phone;
                //     $address->city = $request->city;
                //     $address->street = $request->street;
                //     $address->building = $request->building;
                //     $address->apartment = $request->apartment;
                //     $address->longitude = $request->longitude;
                //     $address->latitude = $request->latitude;
                //     $address->status = 1;
                //     if ($request->type == "reciever") {
                //         $address->type = $request->type;
                //     } else {
                //         $address->type = $request->type;
                //     }
                //     $address->save();
                // }

                if ($request->delivery_address_id == $request->sender_address_id) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Delivery address and sender address should be different"
                    ], 200);
                }
                if ($request->delivery_address_id) {
                    // $package->delivery_address_id = $request->delivery_address_id;

                    $recieverAddress = Address::where('id', $request->delivery_address_id)->first();
                    if ($recieverAddress) {
                        $recieverAddresslat = $recieverAddress->latitude;
                        $recieverAddresslong = $recieverAddress->longitude;
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Delivery address does not exist"
                        ], 200);
                    }
                }

                if (isset($request->sender_address_id)) {
                    $senderAddress = Address::where('id', $request->sender_address_id)->first();
                    if ($senderAddress) {
                        // $package->sender_address_id = $senderAddress->id;

                        $senderAddressId = $senderAddress->id;
                        $senderAddresslat = $senderAddress->latitude;
                        $senderAddresslong = $senderAddress->longitude;
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Sender address does not exist"
                        ], 200);
                    }
                }
                $distance = 0;
                $geoMapper = new GeoMapper;
                $distance = $geoMapper->calculateDistance($senderAddresslat, $senderAddresslong, $recieverAddresslat, $recieverAddresslong);
                // print_r($distance);
                $companies = Company::where('status', 1)->with('rate')->get();

                $response = [];

                if ($companies) {
                    // total product weight price (weight * price).
                    foreach ($companies as $company) {
                        $totalKiloPrice = (int)$company->rate->per_kilogram_rate  * $request->weight;
                        Log::info("Company name " . $company->name);
                        Log::info("total kilogram price " . $totalKiloPrice);

                        if ($request->need_aircool == true) {
                            Log::info("aircool needed");
                            if ($request->vehicle_type == "van") {
                                Log::info("vehicle is van");
                                if ($distance > 0 && $distance < 50) {
                                    Log::info("distance inside city " . $distance);
                                    $totalDistance = (int)$company->rate->inside_city * $distance;
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->inside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else if ($distance > 50 && $distance < 150) {
                                    $totalDistance = (int)$company->rate->outside_city * $distance;
                                    // echo nl2br (" \n ");
                                    // print_r('vanrate'.$company->rate->van_rate);
                                    // echo nl2br (" \n ");
                                    // print_r('outside_city'.$company->rate->outside_city);
                                    // echo nl2br (" \n ");
                                    // print_r('kilo'.$totalKiloPrice);
                                    // echo nl2br (" \n ");
                                    // print_r('air cool'.$company->rate->air_cool_rate);
                                    // echo nl2br (" \n ");
                                    // echo nl2br ("--------------------- ");
                                    // echo nl2br (" \n ");
                                    Log::info("distance outside city " . $distance);
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->outside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else if ($distance > 150 && $distance < 250) {
                                    Log::info("distance between emirates " . $distance);
                                    $totalDistance = (int)$company->rate->between_emirates * $distance;
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->between_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else if ($distance > 250 && $distance < 500) {
                                    Log::info("distance north emirates " . $distance);
                                    $totalDistance = (int)$company->rate->north_emirates * $distance;
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else {
                                    Log::info("distance outside north emirates " . $distance);
                                    $totalDistance = (int)$company->rate->north_emirates * 500;
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                }
                                // $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                            } else if ($request->vehicle_type == "car") {
                                Log::info("vehicle is car");
                                if ($distance > 0 && $distance < 50) {
                                    Log::info("distance inside city " . $distance);
                                    $totalDistance = (int)$company->rate->inside_city * $distance;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->inside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else if ($distance > 50 && $distance < 150) {
                                    Log::info("distance outside city " . $distance);
                                    $totalDistance = (int)$company->rate->outside_city * $distance;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->outside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else if ($distance > 150 && $distance < 250) {
                                    Log::info("distance between emirates " . $distance);
                                    $totalDistance = (int)$company->rate->between_emirates * $distance;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->between_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else if ($distance > 250 && $distance < 500) {
                                    Log::info("distance north emirates " . $distance);
                                    $totalDistance = (int)$company->rate->north_emirates * $distance;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else {
                                    Log::info("distance outside north emirates " . $distance);
                                    $totalDistance = (int)$company->rate->north_emirates * 500;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                }
                                // $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                            } else {
                                Log::info("vehicle is bike");
                                if ($distance > 0 && $distance < 50) {
                                    Log::info("distance inside city " . $distance);
                                    $totalDistance = (int)$company->rate->inside_city * $distance;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->inside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else if ($distance > 50 && $distance < 150) {
                                    Log::info("distance outside city " . $distance);
                                    $totalDistance = (int)$company->rate->outside_city * $distance;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->outside_city + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else if ($distance > 150 && $distance < 250) {
                                    Log::info("distance between emirates " . $distance);
                                    $totalDistance = (int)$company->rate->between_emirates * $distance;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->between_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else if ($distance > 250 && $distance < 500) {
                                    Log::info("distance north emirates " . $distance);
                                    $totalDistance = (int)$company->rate->north_emirates * $distance;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                } else {
                                    Log::info("distance outside north emirates " . $distance);
                                    $totalDistance = (int)$company->rate->north_emirates * 500;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->north_emirates + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                }
                                // $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice + (int)$company->rate->air_cool_rate;
                                $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                            }
                        } else {
                            Log::info("aircool not needed NOTE : Else Condition");
                            // airecool is not needed
                            if ($request->vehicle_type == "van") {
                                Log::info("vehicle is car");
                                if ($distance > 0 && $distance < 50) {
                                    Log::info("distance inside city " . $distance);
                                    // $totalDistance = (int)$company->rate->inside_city * $distance;
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->inside_city + $totalKiloPrice;
                                } else if ($distance > 50 && $distance < 150) {
                                    Log::info("distance outside city " . $distance);
                                    // $totalDistance = (int)$company->rate->outside_city * $distance;
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->outside_city + $totalKiloPrice;
                                } else if ($distance > 150 && $distance < 250) {
                                    Log::info("distance between emirates " . $distance);
                                    // $totalDistance = (int)$company->rate->between_emirates * $distance;
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->between_emirates + $totalKiloPrice;
                                } else if ($distance > 250 && $distance < 500) {
                                    Log::info("distance north emirates " . $distance);
                                    // $totalDistance = (int)$company->rate->north_emirates * $distance;
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                                } else {
                                    Log::info("distance outside north emirates " . $distance);
                                    // $totalDistance = (int)$company->rate->north_emirates * 500;
                                    $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                                }
                                // $totalPrice = (int)$company->rate->van_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice;
                                $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                            } else if ($request->vehicle_type == "car") {
                                Log::info("distance inside city " . $distance);
                                if ($distance > 0 && $distance < 50) {
                                    // $totalDistance = (int)$company->rate->inside_city * $distance;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->inside_city + $totalKiloPrice;
                                } else if ($distance > 50 && $distance < 150) {
                                    Log::info("distance outside city " . $distance);
                                    // $totalDistance = (int)$company->rate->outside_city * $distance;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->outside_city + $totalKiloPrice;
                                } else if ($distance > 150 && $distance < 250) {
                                    Log::info("distance between emirates " . $distance);
                                    // $totalDistance = (int)$company->rate->between_emirates * $distance;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->between_emirates + $totalKiloPrice;
                                } else if ($distance > 250 && $distance < 500) {
                                    Log::info("distance north emirates " . $distance);
                                    // $totalDistance = (int)$company->rate->north_emirates * $distance;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                                } else {
                                    Log::info("distance outside north emirates " . $distance);
                                    // $totalDistance = (int)$company->rate->north_emirates * 500;
                                    $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                                }
                                // $totalPrice = (int)$company->rate->car_rate + (int)$company->rate->kilometer_rate + $totalKiloPrice;
                                $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                            } else {
                                if ($distance > 0 && $distance < 50) {
                                    Log::info("distance inside city " . $distance);
                                    // $totalDistance = (int)$company->rate->inside_city * $distance;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->inside_city + $totalKiloPrice;
                                } else if ($distance > 50 && $distance < 150) {
                                    Log::info("distance outside city " . $distance);
                                    // $totalDistance = (int)$company->rate->outside_city * $distance;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->outside_city + $totalKiloPrice;
                                } else if ($distance > 150 && $distance < 250) {
                                    Log::info("distance between emirates " . $distance);
                                    // $totalDistance = (int)$company->rate->between_emirates * $distance;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->between_emirates + $totalKiloPrice;
                                } else if ($distance > 250 && $distance < 500) {
                                    Log::info("distance north emirates " . $distance);
                                    // $totalDistance = (int)$company->rate->north_emirates * $distance;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                                } else {
                                    Log::info("distance outside north emirates " . $distance);
                                    // $totalDistance = (int)$company->rate->north_emirates * 500;
                                    $totalPrice = (int)$company->rate->bike_rate + (int)$company->rate->north_emirates + $totalKiloPrice;
                                }
                                $response[] = array("company_id" => $company->id, "company_name" => $company->name, "total_amount" => number_format($totalPrice,  2, '.', ''));
                            }
                        }
                    }
                    usort($response, $this->build_sorter('total_amount'));
                    $companies = array_slice($response, 0, 3);
                    return response()->json([
                        'status' => 'success',
                        'message' => "Companies list retrieved.",
                        'data' => $companies
                    ], 200);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Companies not available."
                    ], 200);
                }



                // 'companies' => array_slice($response, 0, 3),
            }
        } catch (Exception $e) {
            return $this->error('Something went wrong, Please try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function companyList(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'weight' => 'required',
                'vehicle_type' => 'required',
                'delivery_address_id' => 'required|integer',
                'sender_address_id' => 'required|integer',
                'need_aircool' => 'required',
                'delivery_type' => 'required',

            ]);
            if ($validator->fails()) {
                // return $this->error($validator->errors()->first(), 200);
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 200);
            }
            $userId = $request->user_id;
            $existingUser = User::find($userId);
            // dd($existingUser);
            if ($existingUser) {
                if ($request->delivery_address_id == $request->sender_address_id) {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Delivery address and sender address should be different"
                    ], 200);
                }
                if ($request->delivery_address_id) {
                    // $package->delivery_address_id = $request->delivery_address_id;

                    $recieverAddress = Address::where('id', $request->delivery_address_id)->first();
                    if ($recieverAddress) {
                        $recieverAddresslat = $recieverAddress->latitude;
                        $recieverAddresslong = $recieverAddress->longitude;
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Delivery address does not exist"
                        ], 200);
                    }
                }

                if (isset($request->sender_address_id)) {
                    $senderAddress = Address::where('id', $request->sender_address_id)->first();
                    if ($senderAddress) {
                        // $package->sender_address_id = $senderAddress->id;

                        $senderAddressId = $senderAddress->id;
                        $senderAddresslat = $senderAddress->latitude;
                        $senderAddresslong = $senderAddress->longitude;
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => "Sender address does not exist"
                        ], 200);
                    }
                }
                // 

                $companies = Company::where('status', 1)->with('rate')->get();

                $response = [];

                if ($companies) {
                    $unionAddress = array($senderAddress->city, $recieverAddress->city);
                    $uniqueCity = array_unique($unionAddress);
                    // dd($uniqueCity);
                    $Cities = SpecialCity::where('status', 1)->get()->toArray();
                    $englishCities = array_column($Cities, 'english');
                    $arabicCities = array_column($Cities, 'arabic');

                    $specialCities = array_merge($englishCities, $arabicCities);
                    // dd($specialCities);
                    $specialCities = array_unique($specialCities);
                    // dd($specialCities);
                    // print_r($specialCities);
                    // exit();
                    // echo nl2br(" \n ");
                    // print_r( $uniqueCity);
                    // echo nl2br(" \n ");
                    // exit();
                    $intersectArray = array_intersect($uniqueCity, $specialCities);
                    $specialCityArray = array_values($intersectArray);
                    // dd($specialCityArray);
                    if (!empty($specialCityArray)) {
                        $spclCity = true;
                    } else {
                        $spclCity = false;
                    }

                    // dd($spclCity);
                    foreach ($companies as $company) {
                        if (isset($company->rate)) {
                            // print_r($company->discount);
                            // echo nl2br(" \n ");
                            $totalKiloPrice = (int)$company->rate->per_kilogram_rate  * $request->weight;

                            if ($request->delivery_type == "deliver_now") {
                                if ($request->need_aircool == true) {
                                    if ($request->vehicle_type == "van") {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_van + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_van + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        }
                                    } elseif ($request->vehicle_type == "car") {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_car + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_car + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        }
                                    } else {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_bike + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_bike + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        }
                                    }
                                } else {
                                    if ($request->vehicle_type == "van") {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_van + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_van + $totalKiloPrice;
                                        }
                                    } elseif ($request->vehicle_type == "car") {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_car + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_car + $totalKiloPrice;
                                        }
                                    } else {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_bike + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_bike + $totalKiloPrice;
                                        }
                                    }
                                }
                                if (isset($company->discount)) {
                                    $discountPercentage = $company->discount;
                                    $totalDiscount = $totalPrice - ($totalPrice * ($company->discount / 100));
                                    $totalDiscount = number_format($totalDiscount,  2, '.', '');
                                }else{
                                    $totalDiscount = number_format($totalPrice,  2, '.', '');
                                    $discountPercentage = "0";
                                }
                                $response[] = array(
                                    "company_id" => $company->id, 
                                    "company_name" => $company->name,
                                    "total_amount" => number_format($totalPrice,  2, '.', ''), 
                                    "discount_percentage" => !empty($discountPercentage) ? (string)$discountPercentage : "0",
                                    "discount_price" => !empty($totalDiscount) ? $totalDiscount : $totalPrice,
                                    "specialCity" => $spclCity == true ? $specialCityArray : null

                                    );
                            } elseif ($request->delivery_type == "deliver_later") {
                                if ($request->need_aircool == true) {
                                    if ($request->vehicle_type == "van") {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_van + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_van + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        }
                                    } elseif ($request->vehicle_type == "car") {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_car + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_car + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        }
                                    } else {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_bike + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_bike + (int)$company->rate->air_condition_rate  + $totalKiloPrice;
                                        }
                                    }
                                } else {
                                    if ($request->vehicle_type == "van") {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_van + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_van + $totalKiloPrice;
                                        }
                                    } elseif ($request->vehicle_type == "car") {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_car + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_car + $totalKiloPrice;
                                        }
                                    } else {
                                        if ($spclCity == true) {
                                            $totalPrice = (int)$company->rate->special_city_rate_bike + $totalKiloPrice;
                                        } else {
                                            $totalPrice = (int)$company->rate->all_emirates_rate_bike + $totalKiloPrice;
                                        }
                                    }
                                }
                                // $totalDiscount = '';
                                // $discountPercentage = '';
                                if (isset($company->discount)) {
                                    $discountPercentage = $company->discount;
                                    $totalDiscount = $totalPrice - ($totalPrice * ($company->discount / 100));
                                    $totalDiscount = number_format($totalDiscount,  2, '.', '');
                                }else{
                                    $totalDiscount = number_format($totalPrice,  2, '.', '');
                                    $discountPercentage = "0";    
                                }
                                $response[] = array(
                                    "company_id" => $company->id,
                                    "company_name" => $company->name,
                                    "total_amount" => number_format($totalPrice,  2, '.', ''),
                                    "discount_percentage" => !empty($discountPercentage) ? (string)$discountPercentage : "0",
                                    "discount_price" => !empty($totalDiscount) ? $totalDiscount : $totalPrice,
                                    "specialCity" => $spclCity == true ? $specialCityArray : null
                                );
                            } else {
                                return response()->json([
                                    'status' => 'error',
                                    'message' => "deliver type not specified."
                                ], 200);
                            }
                        }
                    }
                    usort($response, $this->build_sorter('total_amount'));
                    $companies = array_slice($response, 0, 3);
                    return response()->json([
                        'status' => 'success',
                        'message' => "Companies list retrieved.",
                        'data' => $companies
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "user does not exist"
                ], 200);
            }
        } catch (Exception $e) {
            return $this->error('Something went wrong, Please try again later.');
        }
    }
}

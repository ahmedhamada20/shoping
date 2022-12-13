<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Address;
use Illuminate\Support\Facades\Validator;
use Log;

class AddressController extends Controller
{

    public function updateAddress(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'integer|required|max:255',
                'address_id' => 'integer|required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 200);
            }
            $getAllAddress = Address::where('user_id', $request->user_id)->where('is_primary', 1)->get();
            foreach ($getAllAddress as $value) {
                $value->is_primary = 0;
                $value->save();
            }
            $updateAddress = Address::where('id', $request->address_id)->where('user_id', $request->user_id)->first();
            if (isset($updateAddress)) {
                $updateAddress->is_primary = 1;

                if ($updateAddress->save()) {
                    $response = array(
                        'id' => $updateAddress->id ?  $updateAddress->id : '',
                        'is_primary' => $updateAddress->is_primary ?  $updateAddress->is_primary : $updateAddress->is_primary,
                        'type' => $updateAddress->type ? $updateAddress->type : '',
                        'user_id' => $updateAddress->user_id ?  $updateAddress->user_id : '',
                        'address_type' => $updateAddress->address_type ?  $updateAddress->address_type : '',
                        'recipient_locaion' => $updateAddress->address ?  $updateAddress->address : '',
                        'recipient_name' => $updateAddress->recipient_name ?  $updateAddress->recipient_name : '',
                        'recipient_phone' => $updateAddress->recipient_phone ?  (string)$updateAddress->recipient_phone : '',
                        'city' => $updateAddress->city ? $updateAddress->city : '',
                        'street' => $updateAddress->street ? $updateAddress->street : '',
                        'building' => $updateAddress->building ? $updateAddress->building : '',
                        'apartment' => $updateAddress->apartment ? $updateAddress->apartment : '',
                        'longitude' => $updateAddress->longitude ? $updateAddress->longitude : '',
                        'latitude' => $updateAddress->latitude ? $updateAddress->latitude : ''
                    );
                    return $this->success('updated Successfully', $response);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "Address does not exist."
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, Please try again later."
            ], 200);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if (isset($request->user_id)) {
                $existingUser = User::find($request->user_id);
                if ($existingUser) {
                    if ($request->type == "sender") {
                        $address = Address::where('user_id', $existingUser->id)->orderByRaw('is_primary * 1 desc')->where('type', $request->type)->where('status', 1)->orderBy('created_at', 'desc')->limit(5)->get();
                        $response = [];
                        if (isset($address)) {
                            foreach ($address as $key => $value) {
                                $response[] = array(
                                    'id' => $value->id ?  $value->id : '',
                                    'type' => $value->type ? $value->type : '',
                                    'user_id' => $value->user_id ?  $value->user_id : '',
                                    'address_type' => $value->address_type ?  $value->address_type : '',
                                    'recipient_locaion' => $value->address ?  $value->address : '',
                                    'recipient_name' => $value->recipient_name ?  $value->recipient_name : '',
                                    'recipient_phone' => $value->recipient_phone ?  (string)$value->recipient_phone : '',
                                    'is_primary' => $value->is_primary ?  $value->is_primary : $value->is_primary,
                                    'city' => $value->city ? $value->city : '',
                                    'street' => $value->street ? $value->street : '',
                                    'building' => $value->building ? $value->building : '',
                                    'apartment' => $value->apartment ? $value->apartment : '',
                                    'longitude' => $value->longitude ? $value->longitude : '',
                                    'latitude' => $value->latitude ? $value->latitude : ''
                                );
                            }
                            return $this->success('Fetched address Successfully', $response);
                        } else {
                            return $this->error('No Address is available', 200);
                        }
                    } else if ($request->type == "reciever") {
                        $address = Address::where('user_id', $existingUser->id)->orderByRaw('is_primary * 1 desc')->where('type', $request->type)->where('status', 1)->orderBy('created_at', 'desc')->limit(5)->get();
                        $response = [];
                        if (isset($address)) {
                            foreach ($address as $key => $value) {
                                $response[] = array(
                                    'id' => $value->id ?  $value->id : '',
                                    'type' => $value->type ? $value->type : '',
                                    'user_id' => $value->user_id ?  $value->user_id : '',
                                    'address_type' => $value->address_type ?  $value->address_type : '',
                                    'recipient_locaion' => $value->address ?  $value->address : '',
                                    'recipient_name' => $value->recipient_name ?  $value->recipient_name : '',
                                    'recipient_phone' => $value->recipient_phone ?  (string)$value->recipient_phone : '',
                                    'is_primary' => $value->is_primary ?  $value->is_primary : $value->is_primary,
                                    'city' => $value->city ? $value->city : '',
                                    'street' => $value->street ? $value->street : '',
                                    'building' => $value->building ? $value->building : '',
                                    'apartment' => $value->apartment ? $value->apartment : '',
                                    'longitude' => $value->longitude ? $value->longitude : '',
                                    'latitude' => $value->latitude ? $value->latitude : ''
                                );
                            }
                            return $this->success('Fetched address Successfully', $response);
                        } else {
                            return $this->error('No Address is available', 200);
                        }
                    } else {
                        return $this->error('Address type does not exist', 200);
                    }
                } else {
                    // return $this->error('User id is a required field', 200);
                    return response()->json([
                        'status' => 'error',
                        'message' => "User does not exist."
                    ], 200);
                }
            } else {
                // return $this->error('User id is a required field', 200);
                return response()->json([
                    'status' => 'error',
                    'message' => "User id is a required field"
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'integer|required|max:255',
                // 'address_type' => 'required|string|max:255',
                // 'recipient_phone' => 'required|integer|min:10',
                'address' => 'string|max:300',
                'type' => 'required|string',
            ]);

            if ($validator->fails()) {
                // return $this->error($validator->errors()->first(), 200);
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 200);
            }
            if (isset($request->user_id)) {
                $existingUser = User::find($request->user_id);
                if ($existingUser) {
                    Log::info("is existing user");

                    if (isset($request->address_id)) {
                        $existingAddress = Address::where('id', $request->address_id)->first();
                        if ($existingAddress) {
                            Log::info(" if case is existing address");


                            if (isset($request->is_primary)) {
                                Log::info("primary key is available");

                                if ($request->is_primary == 1) {
                                    Log::info("primary key is 1");

                                    $getAllAddress = Address::where('user_id', $request->user_id)->where('is_primary', 1)->get();
                                    foreach ($getAllAddress as $value) {
                                        $value->is_primary = 0;
                                        $value->save();
                                    }
                                    $address = Address::where('id', $request->address_id)
                                        ->where('user_id', $request->user_id)
                                        ->update([
                                            'address' => $request->address,
                                            "address_type" => $request->address_type ? "HOME" : '',
                                            "recipient_name" => $request->recipient_name,
                                            "recipient_phone" => $request->recipient_phone,
                                            'is_primary' => $request->is_primary ? 1 : 1,
                                            'city' => $request->city,
                                            'street' => $request->street,
                                            'building' => $request->building,
                                            'apartment' => $request->apartment,
                                            'longitude' => $request->longitude,
                                            'latitude' => $request->latitude,
                                            'type' => $request->type,
                                            'status' => 1
                                        ]);
                                } else {
                                    Log::info("primary key is 0 ");

                                    $address = Address::where('id', $request->address_id)
                                        ->where('user_id', $request->user_id)
                                        ->update([
                                            'address' => $request->address,
                                            "address_type" => $request->address_type ? "HOME" : '',
                                            "recipient_name" => $request->recipient_name,
                                            "recipient_phone" => $request->recipient_phone,
                                            'is_primary' => 0,
                                            'city' => $request->city,
                                            'street' => $request->street,
                                            'building' => $request->building,
                                            'apartment' => $request->apartment,
                                            'longitude' => $request->longitude,
                                            'latitude' => $request->latitude,
                                            'type' => $request->type,
                                            'status' => 1
                                        ]);
                                }
                            } else {
                                Log::info("primary key is not available ");

                                $address = Address::where('id', $request->address_id)
                                    ->where('user_id', $request->user_id)
                                    ->update([
                                        'address' => $request->address,
                                        "address_type" => $request->address_type ? "HOME" : '',
                                        "recipient_name" => $request->recipient_name,
                                        "recipient_phone" => $request->recipient_phone,
                                        'is_primary' => 0,
                                        'city' => $request->city,
                                        'street' => $request->street,
                                        'building' => $request->building,
                                        'apartment' => $request->apartment,
                                        'longitude' => $request->longitude,
                                        'latitude' => $request->latitude,
                                        'type' => $request->type,
                                        'status' => 1
                                    ]);
                            }


                            $existingAddress = Address::where('id', $request->address_id)->first();
                            $data = array(
                                'id' => $existingAddress->id ? $existingAddress->id : '',
                                'user_id' => $existingAddress->user_id ? $existingAddress->user_id : '',
                                'address_type' => $existingAddress->address_type ? $existingAddress->address_type : '',
                                'recipient_name' => $existingAddress->recipient_name ? $existingAddress->recipient_name : '',
                                'recipient_phone' => $existingAddress->recipient_phone ? (string)$existingAddress->recipient_phone : '',
                                'address' => $existingAddress->address ? $existingAddress->address : '',
                                'is_primary' => $existingAddress->is_primary ? $existingAddress->is_primary : $existingAddress->is_primary,
                                'city' => $existingAddress->city ? $existingAddress->city : '',
                                'street' => $existingAddress->street ? $existingAddress->street : '',
                                'building' => $existingAddress->building ? $existingAddress->building : '',
                                'apartment' => $existingAddress->apartment ? $existingAddress->apartment : '',
                                'longitude' => $existingAddress->longitude ? $existingAddress->longitude : '',
                                'latitude' => $existingAddress->latitude ? $existingAddress->latitude : '',
                                'type' => $existingAddress->type ? $existingAddress->type : ''
                            );
                            Log::info("Address saved ");
                            return $this->success('Address saved Successfully', $data);
                        } else {
                            // return $this->error('Address id doesnot exist', 200);
                            return response()->json([
                                'status' => 'error',
                                'message' => "Address id doesnot exist"
                            ], 200);
                        }
                    } else {
                        Log::info("else case no address _id ");
                        $getAllAddress = Address::where('user_id', $request->user_id)->where('is_primary', 1)->get();
                        foreach ($getAllAddress as $value) {
                            $value->is_primary = 0;
                            $value->save();
                        }
                        if (isset($request->is_primary)) {
                            Log::info("else case primary key is available ");

                            if ($request->is_primary == 1) {
                                Log::info("else case primary key is 1 ");

                                $getAllAddress = Address::where('user_id', $request->user_id)->where('is_primary', 1)->get();
                                foreach ($getAllAddress as $value) {
                                    $value->is_primary = 0;
                                    $value->save();
                                }
                                $address = new Address;
                                $address->user_id = $existingUser->id;
                                $address->address = $request->address;
                                $address->address_type = $request->address_type ? "HOME" : '';
                                $address->recipient_name = $request->recipient_name;
                                $address->recipient_phone = $request->recipient_phone;
                                $address->is_primary = 1;
                                $address->city = $request->city;
                                $address->street = $request->street;
                                $address->building = $request->building;
                                $address->apartment = $request->apartment;
                                $address->longitude = $request->longitude;
                                $address->latitude = $request->latitude;
                                $address->status = 1;
                                $address->type = $request->type;
                                $address->save();

                                $data = array(
                                    'id' => $address->id ?  $address->id : '',
                                    'user_id' => $address->user_id ?  $address->user_id : '',
                                    'address_type' => $address->address_type ?  $address->address_type : '',
                                    'recipient_name' => $address->recipient_name ?  $address->recipient_name : '',
                                    'recipient_phone' => $address->recipient_phone ?  (string)$address->recipient_phone : '',
                                    'address' => $address->address ?  $address->address : '',
                                    'is_primary' => $address->is_primary ?  $address->is_primary : 0,
                                    'city' => $address->city ? $address->city : '',
                                    'street' => $address->street ? $address->street : '',
                                    'building' => $address->building ? $address->building : '',
                                    'apartment' => $address->apartment ? $address->apartment : '',
                                    'longitude' => $address->longitude ? $address->longitude : '',
                                    'latitude' => $address->latitude ? $address->latitude : '',
                                    'type' => $address->type ? $address->type : ''
                                );
                                Log::info("Address saved ");
                                return $this->success('Address saved Successfully', $data);
                            } else {
                                Log::info("else case primary key is 0 ");

                                $address = new Address;
                                $address->user_id = $existingUser->id;
                                $address->address = $request->address;
                                $address->address_type = $request->address_type ? "HOME" : '';
                                $address->recipient_name = $request->recipient_name;
                                $address->recipient_phone = $request->recipient_phone;
                                $address->is_primary = 1;
                                $address->city = $request->city;
                                $address->street = $request->street;
                                $address->building = $request->building;
                                $address->apartment = $request->apartment;
                                $address->longitude = $request->longitude;
                                $address->latitude = $request->latitude;
                                $address->status = 1;
                                $address->type = $request->type;
                                $address->save();

                                $data = array(
                                    'id' => $address->id ?  $address->id : '',
                                    'user_id' => $address->user_id ?  $address->user_id : '',
                                    'address_type' => $address->address_type ?  $address->address_type : '',
                                    'recipient_name' => $address->recipient_name ?  $address->recipient_name : '',
                                    'recipient_phone' => $address->recipient_phone ?  (string)$address->recipient_phone : '',
                                    'address' => $address->address ?  $address->address : '',
                                    'is_primary' => $address->is_primary ?  $address->is_primary : 0,
                                    'city' => $address->city ? $address->city : '',
                                    'street' => $address->street ? $address->street : '',
                                    'building' => $address->building ? $address->building : '',
                                    'apartment' => $address->apartment ? $address->apartment : '',
                                    'longitude' => $address->longitude ? $address->longitude : '',
                                    'latitude' => $address->latitude ? $address->latitude : '',
                                    'type' => $address->type ? $address->type : ''
                                );
                                Log::info("Address saved ");
                                return $this->success('Address saved Successfully', $data);
                            }
                        } else {
                            Log::info("else case primary key is not available ");

                            $address = new Address;
                            $address->user_id = $existingUser->id;
                            $address->address = $request->address;
                            $address->address_type = $request->address_type ? "HOME" : '';
                            $address->recipient_name = $request->recipient_name;
                            $address->recipient_phone = $request->recipient_phone;
                            $address->is_primary = 1;
                            $address->city = $request->city;
                            $address->street = $request->street;
                            $address->building = $request->building;
                            $address->apartment = $request->apartment;
                            $address->longitude = $request->longitude;
                            $address->latitude = $request->latitude;
                            $address->status = 1;
                            $address->type = $request->type;
                            $address->save();

                            $data = array(
                                'id' => $address->id ?  $address->id : '',
                                'user_id' => $address->user_id ?  $address->user_id : '',
                                'address_type' => $address->address_type ?  $address->address_type : '',
                                'recipient_name' => $address->recipient_name ?  $address->recipient_name : '',
                                'recipient_phone' => $address->recipient_phone ?  (string)$address->recipient_phone : '',
                                'address' => $address->address ?  $address->address : '',
                                'is_primary' => $address->is_primary ?  $address->is_primary : 0,
                                'city' => $address->city ? $address->city : '',
                                'street' => $address->street ? $address->street : '',
                                'building' => $address->building ? $address->building : '',
                                'apartment' => $address->apartment ? $address->apartment : '',
                                'longitude' => $address->longitude ? $address->longitude : '',
                                'latitude' => $address->latitude ? $address->latitude : '',
                                'type' => $address->type ? $address->type : ''
                            );
                            Log::info("Address saved ");
                            return $this->success('Address saved Successfully', $data);
                        }
                    }
                } else {
                    return response()->json(['status' => 'error', 'message' => "User does not exist."], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "User id is a required field"
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => "Something went wrong, Please try again later."
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request)
    {
        try {
            if (isset($request->address_id)) {
                $existingAddress = Address::where('id', $request->address_id)->where('status', 1)->first();
                if ($existingAddress) {
                    $address = Address::where('id', $existingAddress->id)->first();
                    $response = array(
                        'id' => $address->id ?  $address->id : '',
                        'user_id' => $address->user_id ?  $address->user_id : '',
                        'address_type' => $address->address_type ?  $address->address_type : '',
                        'address' => $address->address ?  $address->address : '',
                        'recipient_name' => $address->recipient_name ?  $address->recipient_name : '',
                        'recipient_phone' => $address->recipient_phone ?  (string)$address->recipient_phone : '',
                        'is_primary' => $address->is_primary ?  $address->is_primary : 0,
                        'city' => $address->city ? $address->city : '',
                        'street' => $address->street ? $address->street : '',
                        'building' => $address->building ? $address->building : '',
                        'apartment' => $address->apartment ? $address->apartment : '',
                        'longitude' => $address->longitude ? $address->longitude : '',
                        'latitude' => $address->latitude ? $address->latitude : '',
                        'type' => $address->type ? $address->type : ''
                    );
                    return $this->success('Fetched address Successfully', $response);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => "Address doest not exist."
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "Address id is a required field"
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
    public function destroy(Request $request)
    {
        $getAddress = Address::where('id', $request->id)->where('status', 1)->first();
        if (isset($getAddress)) {
            if ($getAddress->is_primary == 1) {
                Address::where('id', $request->id)->update([
                    "status" => 0
                ]);
                $updateAddress = Address::orderByDesc('created_at')->where('status', 1)->first();
                if (isset($updateAddress)) {
                    $updateAddress->is_primary = 1;
                    $updateAddress->save();
                }
                // else {
                //     return response()->json(['status' => 'error','message' => "Address doest not exist"], 200);
                // }
                Log::info("Address is deleted, id : ". $updateAddress->id);
                return response()->json(['status' => 'success', 'message' => "Address deleted Successfully."], 200);
            } else {
                Address::where('id', $request->id)->update([
                    "status" => 0
                ]);
                return response()->json(['status' => 'success', 'message' => "Address deleted Successfully."], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => "Address doest not exist"], 200);
        }
    }
}

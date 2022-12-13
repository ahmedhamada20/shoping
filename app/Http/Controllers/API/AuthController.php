<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Device;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Address;
use DB;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'bail|required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'bail|required|string|email|max:255',
                // 'password' => 'required|string|min:6|confirmed',
                'type' => 'integer',
                'phone' => 'required|min:10',
            ],
            [
                'firstname.required' => 'أدخل الإسم الأول',
                'lastname.required' => 'أدخل الإسم الأخير',
                'email.required' => 'أدخل البريد الإلكتروني',
                'email.email' => 'أدخل بريد إلكتروني صحيح',
                'phone.min' => 'رقم الهاتف غير صحيح'
            ]);

            if ($validator->fails()) {
                // return $this->error($validator->errors()->first(), 200);
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 200);
            }
            DB::transaction(function () use ($request, &$data) {
                $request['remember_token'] = Str::random(10);
                $request['type'] = $request['type'] ? $request['type']  : 0;
                $request['language'] = $request['language'] ? $request['language']  : 'en';

                $phone = User::where('phone', $request->phone)->first();
                $email = User::where('email', $request->email)->first();
                if( $phone ){
                    $phone->firstname = $request->firstname ? $request->firstname : $phone->firstname;
                    $phone->lastname = $request->lastname ? $request->lastname : $phone->lastname;
                    $phone->email = $request->email ? $request->email : $phone->email;
                    $phone->phone = $request->phone ? $request->phone : $phone->phone;
                    $phone->address = $request->address ? $request->address : $phone->address;
                    $phone->address_type = $request->address_type ? $request->address_type : $phone->address_type;
                    $phone->city = $request->city ? $request->city : $phone->city;
                    $phone->language = "en";
                    if( $phone->save() ){
                        $user = User::where('id', $phone->id)->first();
                    }
                }else if( $email ) {
                    $email->firstname = $request->firstname ? $request->firstname : $email->firstname;
                    $email->lastname = $request->lastname ? $request->lastname : $email->lastname;
                    $email->email = $request->email ? $request->email : $email->email;
                    $email->phone = $request->phone ? $request->phone : $email->phone;
                    $email->address = $request->address ? $request->address : $email->address;
                    $email->address_type = $request->address_type ? $request->address_type : $email->address_type;
                    $email->city = $request->city ? $request->city : $email->city;
                    $email->language = "en";

                    if( $email->save() ){
                        $user = User::where('id', $email->id)->first();
                    }
                } else {
                    // $user = new User;
                    // $user->firstname = $request->firstname ? $request->firstname : $request->firstname;
                    // $user->lastname = $request->lastname ? $request->lastname : $request->lastname;
                    // $user->email = $request->email ? $request->email : $request->email;
                    // $user->phone = $request->phone ? $request->phone : $request->phone;
                    // $user->address = $request->address ? $request->address : $request->address;
                    // $user->address_type = $request->address_type ? $request->address_type : $request->address_type;
                    // $user->city = $request->city ? $request->city : $request->city;
                    // $user->language = "en";
                    // $user->save();

                    $user = User::create($request->toArray());
                }
                

                // $address = new Address;
                // $address->user_id = $user->id;
                // $address->address = $request->address;
                // $address->address_type = $user->address_type;
                // $address->recipient_name = $user->name;
                // $address->recipient_phone = $user->phone;
                // $address->status = 1;
                // $address->save();

                $data = array(
                    'id' => $user->id ?  $user->id : '',
                    'firstname' => $user->firstname ?  $user->firstname : '',
                    'lastname' => $user->lastname ?  $user->lastname : '',
                    'email' => $user->email ?  $user->email : '',
                    'phone' => $user->phone ?  (string)$user->phone : '',
                    'language' => $user->language ?  $user->language : '',
                    'address_type' => $user->address_type ?  $user->address_type : '',
                    'address' => $user->address ?  $user->address : '',
                    'city' => $user->city ?  $user->city : '',
                );
            });

            // return $this->success('Registered Successfully', $data);
            return $this->success('تسجيل الدخول بنجاح', $data);
        } catch (Exception $e) {
            // return $this->error('Something went wrong, Please try again later.', 200);
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Something went wrong, Please try again later.'
            // ], 200);
            return response()->json([
                'status' => 'error',
                'message' => 'عذراً حدث خطأ'
            ], 200);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:10',
        ],
        [
            'phone.min' => 'رقم الهاتف غير صحيح',
            'phone.required' => 'أدخل رقم الهاتف'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }
        $user = User::where('phone', $request->phone)->first();
        if ($user) {
            $userAddress = address::where('user_id', $user->id)->where('is_primary', 1)->first();
            if (isset($userAddress)) {
                $userAddress = array($userAddress);
            } else {
                $userAddress = [];
            }

            $path = 'uploads/user_profile/thumb';
            $profileImage = config('app.url') . '/' . $path . '/' . $user->profile;
            $response = array(
                'id' => $user->id ?  $user->id : '',
                'firstname' => $user->firstname ?  $user->firstname : '',
                'lastname' => $user->lastname ?  $user->lastname : '',
                'email' => $user->email ?  $user->email : '',
                'phone' => $user->phone ?  (string)$user->phone : '',
                'language' => $user->language ?  $user->language : '',
                'address_type' => $user->address_type ?  $user->address_type : '',
                'address' => $user->address ?  $user->address : '',
                'city' => $user->city ?  $user->city : '',
                'profile_image' => $user->profile ?  $profileImage : '',
                'user_address' => $userAddress
            );
            // return $this->success('Login successfull', $response);
            return $this->success('تسجيل الدخول بنجاح', $response);
        } else {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'User does not exist! Please signup'
            // ], 200);
            return response()->json([
                'status' => 'error',
                'message' => 'إسم المستخدم غير موجود! من فضلك قم بإنشاء حساب جديد'
            ], 200);
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        // $response = ['message' => 'You have been successfully logged out!'];
        // return response($response, 200);
        return $this->success('You have been successfully logged out!', 200);
        // return response()->json([
        //     'status' => 'success',
        //     'message' => "You have been successfully logged out!"
        // ],);
    }

    public function deviceRegister(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'device_type' => 'required',
                'device_id' => 'required',
            ]);
            if ($validator->fails()) {
                // return $this->error($validator->errors()->first(), 200);
                return response()->json([
                    'status' => 'error',
                    'message' => $validator->errors()->first()
                ], 200);
            }
            // securitykey
            $securityKey = '2a04x0ys2YNEjfxyvbvUvgbCuVxCiusEXtekiIRNvn7wagvkuic8hCK';

            $existingdevice = Device::where('device_id', $request->device_id)->first();
            $key = strcmp($request->security_key, $securityKey);
            if ($key == 0) {
                if ($existingdevice) {
                    $token = $existingdevice->createToken('device client permission')->accessToken;
                    // dd($token);
                } else {
                    $device = new Device;
                    $device->device_id = $request->device_id;
                    $device->device_type = $request->device_type;
                    // $device->security_key = $securityKey;
                    $device->save();
                    $token = $device->createToken('device client permission')->accessToken;
                }
                // return $this->success('Device registered', $token);
                return $this->success('تسجيل الدخول بنجاح', $token);
            } else {
                // return response()->json([
                //     'status' => 'error',
                //     'message' => 'Security key does not match'
                // ], 200);
                return response()->json([
                    'status' => 'error',
                    'message' => 'عذراً حدث خطأ'
                ], 200);
            }
        } catch (Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => 'Something went wrong, Please try again later.'
            // ], 200);
            return response()->json([
                'status' => 'error',
                'message' => 'عذراً حدث خطأ'
            ], 200);
        }
    }
}

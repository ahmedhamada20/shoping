<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function profileDetails(Request $request)
    {
        try {
            if (isset($request->user_id)) {
                $existingUser = User::find($request->user_id);
                $path = 'uploads/user_profile/thumb';
                if (isset($existingUser->profile)) {
                    $profileImage = config('app.url') . '/' . $path . '/' . $existingUser->profile;
                }
                // dd($profileImage);
                if ($existingUser) {
                    $response = array(
                        'id' => $existingUser->id ?  $existingUser->id : '',
                        'firstname' => $existingUser->firstname ?  $existingUser->firstname : '',
                        'lastname' => $existingUser->lastname ?  $existingUser->lastname : '',
                        'email' => $existingUser->email ?  $existingUser->email : '',
                        'phone' => $existingUser->phone ?  (string)$existingUser->phone : '',
                        'profile_image' => $existingUser->profile  ?  $profileImage : '',
                        'city' => $existingUser->city ?  $existingUser->city : '',
                        'address' => $existingUser->address ?  $existingUser->address : '',
                        'address_type' => $existingUser->address_type ?  $existingUser->address_type : '',

                    );
                    return $this->success('Retrieved Successfully', $response);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileImage(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
                'user_id' => 'required|integer',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }
            if (isset($request->user_id)) {
                $existingUser = User::find($request->user_id);
                if ($existingUser) {

                    // profile image upload
                    $image = $request->file('image');
                    $input['imagename'] = $existingUser->id . '.' . $image->extension();
                    $filePath = public_path('uploads/user_profile/thumb');

                    $img = Image::make($image->path());
                    $img->resize(500, 500, function ($const) {
                        $const->aspectRatio();
                    })->save($filePath . '/' . $input['imagename']);

                    // $filePath = public_path('uploads/user_profile/images');
                    // $image->move($filePath, $input['imagename']);

                    $user = User::where('id', $existingUser->id)
                        ->update([
                            'profile' => $input['imagename'],
                        ]);
                    $Userdata = User::find($request->user_id);
                    $path = 'uploads/user_profile/thumb';
                    $profileImage = config('app.url') . '/' . $path . '/' . $Userdata->profile;
                    $data = array(
                        'id' => $Userdata->id ?  $Userdata->id : '',
                        'email' => $Userdata->email ?  $Userdata->email : '',
                        'phone' => $Userdata->phone ?  (string)$Userdata->phone : '',
                        'firstname' => $Userdata->firstname ?  $Userdata->firstname : '',
                        'lastname' => $Userdata->lastname ?  $Userdata->lastname : '',
                        'address_type' => $Userdata->address_type ?  $Userdata->address_type : '',
                        'address' => $Userdata->address ?  $Userdata->address : '',
                        'city' => $Userdata->city ?  $Userdata->city : '',
                        'profile_image' => $Userdata->profile ?  $profileImage : ''
                    );
                    return $this->success('User profile updated Successfully', $data);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // validation pending
        try {
            $validator = Validator::make($request->all(), [
                'firstname' => 'bail|required|string|max:255',
                'lastname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|min:10|integer|unique:users',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }
            if (isset($request->user_id)) {
                $existingUser = User::find($request->user_id);
                if ($existingUser) {
                    $user = User::where('id', $request->user_id)
                        ->update([
                            'email' => $request->email,
                            'phone' => $request->phone,
                            'firstname' => $request->firstname,
                            'lastname' => $request->lastname,
                            'city' => $request->city,
                        ]);
                    $Userdata = User::find($request->user_id);
                    $data = array(
                        'id' => $Userdata->id ?  $Userdata->id : '',
                        'email' => $Userdata->email ?  $Userdata->email : '',
                        'phone' => $Userdata->phone ?  (string)$Userdata->phone : '',
                        'firstname' => $Userdata->firstname ?  $Userdata->firstname : '',
                        'lastname' => $Userdata->lastname ?  $Userdata->lastname : '',
                        'address_type' => $Userdata->address_type ?  $Userdata->address_type : '',
                        'address' => $Userdata->address ?  $Userdata->address : '',
                        'city' => $Userdata->city ?  $Userdata->city : '',
                    );
                    return $this->success('User updated Successfully', $data);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function language(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'language' => 'required'
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first());
            }
            $checkUser = User::find($request->user_id);
            if (isset($checkUser)) {
                if ($request->language == 'en') {
                    $checkUser->update(['language' => $request->language]);
                    return $this->success('User language updated Successfully', ["user_id" => $checkUser->id]);
                } else if ($request->language == 'ar') {
                    $checkUser->update(['language' => $request->language]);
                    return $this->success('User language updated Successfully', ["user_id" => $checkUser->id]);
                } else {
                    return $this->error("language does not match");
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => "user does not exist"
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
    public function deactivate(Request $request)
    {
        $request->validate([
            "user_id" => "required",
        ]);

        $checkUser = User::find($request->user_id);
        if (isset($checkUser)) {
            $checkUser->delete();
            return response()->json([
                'status' => 'success',
                'message' => "user account has deactivated"
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => "user does not exist"
            ], 200);
        }
    }
}

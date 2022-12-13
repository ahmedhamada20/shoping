<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use App\User;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = User::find($request->user_id);
        if ($user) {
            $banners = Banner::orderBy('created_at', 'desc')->get();
            // dd($storagePath  = Storage::disk('local')->get('screenshots/1.jpg'));
            $response = [];
            $response['banner'] = [];
            if (!empty($banners)) {
                // dd($banners);
                foreach ($banners as $banner) {
                    $response['banner'][] = array('id' => $banner->id, 'url' => $banner->url, 'image_url' => $banner->image_url);
                }
            }
            // $$response[user_profile] = ,'wallet' => $user->wallet ? $user->wallet : 0 ;
            $response['user_profile'] = [
                'id' => $user->id ?  $user->id : '',
                'email' => $user->email ?  $user->email : '',
                'phone' => $user->phone ?  (string)$user->phone : '',
                'firstname' => $user->firstname ?  $user->firstname : '',
                'lastname' => $user->lastname ?  $user->lastname : '',
                'address_type' => $user->address_type ?  $user->address_type : '',
                'address' => $user->address ?  $user->address : '',
                'city' => $user->city ?  $user->city : '',
                'wallet' => $user->wallet ? number_format($user->wallet,  2, '.', '') : "0.00",
            ];
            return $this->success('Banner images retrieved', $response);
        } else {
            // return $this->error("Request not submitted. Please try later.", 200);
            return $this->error("User doesnot exist", 200);
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

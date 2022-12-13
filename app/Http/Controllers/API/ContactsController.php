<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Contact;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $messages = [
                'required' => 'The :attribute field is required.',
            ];

            $validator = Validator::make(
                $request->all(),
                [
                    'user_id' => 'integer|required',
                    'email' => 'email',
                    'description' => 'required|max:300',
                ],
                $messages
            );

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 200);
            }
            $existingUser = User::find($request->user_id);
            if ($existingUser) {
                $contacts = new Contact;
                $contacts->user_id = $existingUser->id;
                $contacts->email = $request->email;
                $contacts->subject = $request->subject ? $request->subject : "";
                $contacts->description = $request->description;
                if ($contacts->save()) {
                    // $data = array(
                    //     'id' => $contacts->id ?  $contacts->id : '',

                    // );
                    // return response()->json([
                    //     'status' => 'success',
                    //     'message' => "Request has been submitted successfully."
                    // ], 200);
                    return response()->json([
                        'status' => 'success',
                        'message' => "عذراً حدث خطأ"
                    ], 200);
                } else {
                    // return $this->error("Request not submitted. Please try later.", 200);
                    return $this->error("حدث خطأ", 200);
                }
            } else {
                // return $this->error("User does not exist.", 200);
                return $this->error("إسم المستخدم غير موجود!", 200);
            }
        } catch (Exception $e) {
            // return response()->json([
            //     'status' => 'error',
            //     'message' => "Something went wrong, Please try again later."
            // ], 200);
            return response()->json([
                'status' => 'error',
                'message' => "عذراً حدث خطأ"
            ], 200);
        }
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

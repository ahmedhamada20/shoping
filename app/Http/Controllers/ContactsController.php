<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Image;
use DB;
use App\User;

class ContactsController extends Controller
{

    public function index()
    {
        return view('Contacts.index');
    }

    // searchbox
    public function searchBox(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = Contact::Where('subject', 'LIKE', $query . '%')
                    ->orWhere('email', 'LIKE', $query . '%')
                    ->limit(15)
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $data = Contact::orderBy('created_at', 'desc')
                    ->limit(15)->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {

                $i = 0;
                foreach ($data as $row) {
                    $user = User::where('id', $row->user_id)->first();
                    if (isset($user->firstname)) {
                        $firstname = $user->firstname;
                    } else {
                        $firstname = "";
                    }

                    if (isset($user->lastname)) {
                        $lastname = $user->lastname;
                    } else {
                        $lastname = "";
                    }
                    if (empty($user->firstname) && empty($user->lastname)) {
                        $firstname = "User fullname not available.";
                        $lastname = "";
                    }

                    $output .=
                        '<tr>
                            <td>' . ++$i . '</td>
                            <td>' . $firstname . ' ' . $lastname . '</td>
                            <td>' . $row->email . '</td>
                            <td>
                                <button class="btn btn-secondary detail-btn" data-toggle="modal" data-target="#contacts-Modal" data-id="' . $row->id . '" onclick="contactDetails(' . $row->id . ')">View Details</button>
                            </td>
                        </tr>';
                }
                // <a href="' . route('user.delete', ['id' => $row->id]) . '" class="btn-danger"><i class="fa fa-trash" aria-hidden="true"></i>Delete</a>
                // <a href="user-edit/' . $row->id . '" class="btn dark btn-xs"><i class="fa fa-trash" aria-hidden="true"></i>Edit</a>
            } else {
                $output .= '<tr>
                <td align="center" colspan="5"> No Data Found </td>
                 </tr>';
            }

            $data = array(
                'table_data' => $output,
                'totaluser' => $total_row
            );

            // dd($data);
            // echo json_encode($data);
            return response()->json($data);
        }
    }

    // view contact edtails

    public function contactDetail(Request $request)
    {
        $contact = Contact::find($request->id);
        $user = User::find($contact->user_id);
        if (isset($user->firstname)) {
            $firstname = $user->firstname;
        } else {
            $firstname = "";
        }

        if (isset($user->lastname)) {
            $lastname = $user->lastname;
        } else {
            $lastname = "";
        }
        $data = array(
            // 'subject' => $contact->subject,
            'description' => $contact->description,
            'name' => $firstname . " " . $lastname,
            "email" => $contact->email,
        );
        return response()->json($data);
    }
}

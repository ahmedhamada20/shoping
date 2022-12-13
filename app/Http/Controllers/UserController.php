<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\User;
use App\Package;
use App\Order;
use App\OrderStatus;
use App\Address;

class UserController extends Controller
{
    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)
    {
        $data = User::where('type', 0)->where('status', 1)->orderByDesc('created_at')->simplePaginate(15);

        return view('Users.list_users', compact('data'));
    }

    public function create(Request $request)
    {
        return view('Users.create_user');
    }

    // searchbox
    public function searchBox(Request $request)
    {

        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = User::orWhere('type', 0)->where('status', 1)
                    ->where('firstname', 'LIKE', "%{$query}%")
                    ->orWhere('lastname', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->limit(15)
                    ->get();
            } else {
                $data = User::where('type', 0)->where('status', 1)
                    ->orderByDesc('created_at')
                    ->limit(15)->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {

                $i = 0;
                foreach ($data as $row) {
                    if ($row->status == 1) {
                        $userStatus = '<a href="' . route('user.status', ['id' => $row->id]) . '" class="btn btn-danger" style="padding: 5px !important;"> <i class="ft-x-circle"></i> Disable</a>';
                    } else {
                        $userStatus = '<a href="' . route('user.status', ['id' => $row->id]) . '" class="btn btn-success" style="padding: 5px !important;"><i class="ft-check-circle"></i> Enable</a>';
                    }

                    $output .=
                        '<tr>
                            <td>' . ++$i . '</td>
                            <td>' . $row->firstname . ' ' . $row->lastname . '</td>
                            <td>' . $row->email . '</td>
                            <td>' . $row->phone . '</td>
                            <td>
                                <a href="view/' . $row->id . '" class="btn btn-warning" style="padding: 5px !important;"><i class="ft-eye"></i> View</a>
                                ' . $userStatus . '
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
                'table_data' => $output
            );

            // dd($data);
            // echo json_encode($data);
            return response()->json($data);
        }
    }

    public function statusUpdate($id)
    {

        $obj = User::find($id);
        // print_r($obj->status);
        // exit();
        $obj->toggleStatus()->save();

        if ($obj->status == 0) {
            // return redirect::back()->with('message', 'User has Deactivated');
            return back()->with('message', 'User has Deactivated');
        } else {
            // return redirect::back()->with('message', 'User has Activated');
            return back()->with('message', 'User has Activated');
        }
    }
    public function destroy($id)
    {

        User::where('id', $id)->delete();

        return back()->with('message', 'User Deleted');
    }

    public function viewUserdetails($id)
    {
        $users = User::find($id);
        $orders = Order::where('user_id', $id)->with('package')->orderByDesc('created_at')->get();
        $packages = Package::where('user_id', $id)->get();
        $address = Address::where('user_id', $id)->orderByDesc('created_at')->get();
        return view('Users/show', ['user' => $users, 'address' => $address, 'orders' => $orders]);
    }

    public function wallet(Request $request) {
        // $data = $request->wallet;

        $existingUser = User::find($request->user_id);
        if($existingUser){
            $updateWallet = User::where('id', $request->user_id)->update(['wallet'=>$request->wallet]);
            return response()->json(['status' => 'success', 'message' => "Wallet amount updated successfully"]);
        }else{
            return response()->json(['status' => 'error', 'message' => "user doesnot exist."]);
        }


        

    }
}

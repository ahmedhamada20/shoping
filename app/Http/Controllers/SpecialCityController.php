<?php

namespace App\Http\Controllers;

use App\SpecialCity;
use Illuminate\Http\Request;

class SpecialCityController extends Controller
{
    /**
     * index
     * load index view
     * @return void
     */
    public function index()
    {
        $data = SpecialCity::orderByDesc('created_at')->simplePaginate(15);
        return view('SpecialCity.index', compact('data'));
    }

    /**
     * searchPlusloadTableData
     * function used to load and search table data
     * @param  mixed $request
     * @return void
     */
    public function searchPlusloadTableData(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = SpecialCity::where('arabic', 'LIKE', "%{$query}%")
                    ->orWhere('english', 'LIKE', "%{$query}%")
                    ->limit(15)
                    ->get();
            } else {
                $data = SpecialCity::orderByDesc('created_at')
                    ->limit(15)->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {

                $i = 0;
                foreach ($data as $row) {
                    if ($row->status == 1) {
                        $cityStatus = "<a data-id='$row->id' data-value='0' class='btn btn-danger disable-city' style='padding: 5px !important;' onclick='updateStatus($row->id, 0)'> <i class='ft-x-circle'></i> Disable</a>";
                    } else {
                        $cityStatus = "<a data-id='$row->id' data-value='1' class='btn btn-success disable-city' style='padding: 5px !important;' onclick='updateStatus($row->id, 1)'> <i class='ft-x-circle'></i> Enable</a>";
                    }

                    $output .=
                    '<tr>
                               <td>' . ++$i . '</td>
                               <td>' . $row->arabic . '</td>
                               <td>' . $row->english . '</td>
                               <td>
                                   ' . $cityStatus . '
                               </td>
                               <td> <a data-id="' . $row->id . '" class="btn btn-danger delete-city" style="padding: 5px !important;" onclick="deleteCity(' . $row->id . ')"><i class="ft-delete"></i> Delete</a></td>
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
            );

            // dd($data);
            // echo json_encode($data);
            return response()->json($data);
        }
    }    
    /**
     * storeSpecialCity
     * function store city
     * @param  mixed $request
     * @return void
     */
    public function storeSpecialCity(Request $request)
    {
        if ($request->ajax()) {
            $validator = \Validator::make($request->all(), [
                'arabic' => 'required',
                'english' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'errors' => $validator->errors()->messages()], 422);
            }
            $city = new SpecialCity();
            $city->status = 1;
            $city->arabic = $request->arabic;
            $city->english = $request->english;
            $city->save();
            return response()->json(['status' => 'success', 'message' => 'Special city created successfully.']);
        }
    }    
    /**
     * updateSpecialCity
     * function update city -> "enable/disable" feature
     * @param  mixed $request
     * @return void
     */
    public function updateSpecialCity(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->id)) {
                $city = SpecialCity::find($request->id);
                $city->status = $request->status;
                $city->save();
                return response()->json(['status' => 'success', 'message' => 'Special city updated successfully.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'An error occured please try again.']);
            }
        }
    }    
    /**
     * deleteSpecialCity
     * function permanently delete city
     * @param  mixed $request
     * @return void
     */
    public function deleteSpecialCity(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->id)) {
                if (SpecialCity::find($request->id)->delete()) {
                    return response()->json(['status' => 'success', 'message' => 'Special city deleted successfully.']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'An error occured please try again.']);
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'An error occured please try again.']);
            }
        }
    }

}

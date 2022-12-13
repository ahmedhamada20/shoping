<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Driver;
use DB;
use App\Vehicle;

class VehiclesController extends Controller
{
    public function index(Request $request)
    {
        return view('Vehicles.index');
    }
    public function searchBox(Request $request)
    {

        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = Vehicle::Where('model', 'LIKE', '%' . $query . '%')
                    ->orWhere('vehicle_number', 'LIKE', '%' . $query . '%')
                    ->orWhere('type', 'LIKE', '%' . $query . '%')
                    ->get();
            } else {
                $data = Vehicle::get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {


                foreach ($data as $row) {
                    if ($row->status == 1) {
                        $driverStatus = '<a href="' . route('vehicle.status', ['id' => $row->id]) . '" title="Block - ' . $row->firstname . '" class="btn red btn-xs"><i class="fa fa-close" aria-hidden="true"></i>Disable</a>';
                    } else {
                        $driverStatus = '<a href="' . route('vehicle.status', ['id' => $row->id]) . '" title="Block - ' . $row->firstname . '" class="btn green btn-xs"<i class="fa fa-check" aria-hidden="true"></i>Enable</a>';
                    }
                    $driverName = Driver::find($row->driver_id);
                    $output .=
                        '<tr>
                    <td>' . $row->model . '</td>
                    <td>' . $row->type . '</td>
                    <td>' . $row->vehicle_number . '</td>
                    <td>' . $driverName->fullname . '</td>
                   </tr>';
                }
            } else {
                $output .= '<tr>
                <td align="center" colspan="5"> No Data Found </td>
                 </tr>';
            }

            $data = array(
                'table_data' => $output,
                'totaldriver' => $total_row
            );

            // dd($data);
            // echo json_encode($data);
            return response()->json($data);
        }
    }
}

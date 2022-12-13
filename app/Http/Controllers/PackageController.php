<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\Package;
use App\Order;
use App\Orderstatus;
use App\Driver;
use App\Address;
use App\DriverActivity;
use App\PackageMedia;
use App\Vehicle;
use App\Company;
use Log;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $data = Order::with('package')->orderByDesc('created_at')->simplePaginate(15);

        return view('Packages.index', compact('data'));
    }
    public function searchBox(Request $request)
    {

        if ($request->ajax()) {
            $output = '';
            $data = [];
            $query = $request->get('query');
            if ($query != '') {
                // $orders = Order::get();
                // foreach ($orders as $order) {
                //     $data = Package::where('id', $order->package_id)->where('recipient_name', 'LIKE', '%' . $query . '%')
                //         ->where('recipient_phone', 'LIKE', '%' . $query . '%')
                //         ->where('order_id', 'LIKE', '%' . $query . '%')
                //         ->limit(15)
                //         ->orderByDesc('created_at')
                //         ->get();
                $orders = Order::where('order_id', 'LIKE', "%{$query}%")
                    // ->whereHas('package', function($q) use ($query) {
                    // $q->orwhere('recipient_name', 'LIKE', "%{$query}%")
                    //     ->orWhere('recipient_phone', 'LIKE', "%{$query}%");
                    // })
                    ->get();
                // $data = Package::where('id', $order->package_id)
                // ->where('recipient_name', 'LIKE', "%{$query}%")
                // ->orWhere('recipient_phone', 'LIKE', "%{$query}%")
                // ->orWhere('order_id', 'LIKE', "%{$query}%")
                // ->limit(15)
                // ->get();
                // }
            } else {
                $orders = Order::with('package')->orderByDesc('created_at')->get();

                // foreach ($orders as $order) {
                //     $data[] = Package::where('id', $order->package_id)->limit(15)->orderBy('created_at', 'desc')->get();
                // }
                // dd($data);
                // exit();
            }
            $total_row = count($orders);
            if ($total_row > 0) {

                $i = 0;
                // foreach ($data as $value) {
                foreach ($orders as $row) {
                    if ($row->status == 1) {
                        $packageStatus = '<a href="' . route('vehicle.status', ['id' => $row->id]) . '" title="Block - ' . $row->firstname . '" class="btn red btn-xs"><i class="fa fa-close" aria-hidden="true"></i>Disable</a>';
                    } else {
                        $packageStatus = '<a href="' . route('vehicle.status', ['id' => $row->id]) . '" title="Block - ' . $row->firstname . '" class="btn green btn-xs"<i class="fa fa-check" aria-hidden="true"></i>Enable</a>';
                    }
                    $userName = User::find($row->user_id);
                    if (isset($userName->firstname)) {
                        $firstname = $userName->firstname;
                    } else {
                        $firstname = " ";
                    }
                    $output .=
                        '<tr>
                                <td>' . ++$i . '</td>
                                <td>' . $row->order_id . '</td>
                                <td>' . $row->package->recipient_name . '</td>
                                <td>' . $row->package->recipient_phone . '</td>
                                <td>' . $row->status . '</td>
                                <td>
                                <a href="' . route('package.details', ['id' => $row->package->id]) . '" class="btn btn-success" style="padding: 5px !important;"><i class="ft-eye"></i> View</a>
                                </td>
                            </tr>';
                }
                // }
                // exit();
            } else {
                $output .= '<tr>
                <td align="center" colspan="6"> No Data Found </td>
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

    public function packageDetails($id)
    {
        try {
            $order = Order::where('package_id', $id)->first();
            $package = Package::where('id', $order->package_id)->first();
            $orderStatus = Orderstatus::where('order_id', $order->id)->first();
            $senderAddress = Address::where('id', $package->sender_address_id)->first();
            $deliverAddress = Address::where('id', $package->delivery_address_id)->first();
            $packageMedia = PackageMedia::where('package_id', $package->id)->first();
            $company = Company::where('id', $order->company_id)->first();
            if (isset($packageMedia)) {
                $images = explode(',', $packageMedia->image);
                // dd($images);
            } else {
                $images = [];
            }
            // dd($orderStatus);
            $driverDetails = "";
            if (isset($orderStatus->driver_id)) {
                $driverDetails = Driver::where('id', $orderStatus->driver_id)->first();
                $vehicleDetails = Vehicle::where('driver_id', $driverDetails->id)->first();
            } else {
                $vehicleDetails = '';
            }

            $users = User::find($package->user_id);

            $activedrivers = DriverActivity::where('status', 'active')->get();
            Log::info('active drivers');
            Log::info(print_r($activedrivers, true));
            $drivers = [];
            if (isset($activedrivers)) {
                foreach ($activedrivers as $activedriver) {
                    // print_r($activedriver->driver_id);
                    $driver  = Driver::where('id', $activedriver->driver_id)->first();
                    // if ($order->company_id == $driver->company_id) {
                        $drivers[] = array(
                            'id' => $driver->id,
                            'name' => $driver->fullname
                        );
                    // }
                }
            }

            // dd($drivers);
            return view('Packages/details', ["company" => $company, "vehicle" => $vehicleDetails, "images" => $images, 'package' => $package, 'order_status' => $orderStatus, 'orders' => $order, 'user' => $users, 'drivers' => $drivers, 'driver_details' => $driverDetails, "senderAddress" => $senderAddress, "deliverAddress" => $deliverAddress]);
        } catch (Exception $e) {
        }
    }
    public function getDrivers(Request $request)
    {
        // try {
        $activedrivers = DriverActivity::where('status', 'active')->get();
        $drivers = [];
        foreach ($activedrivers as $activedriver) {
            $driver  = Driver::where('id', $activedriver->id)->first();
            $drivers[] = array(
                'id' => $driver->id,
                'name' => $driver->fullname
            );
        }

        return response()->json($drivers);
        // }catch (Exception $e){

        // }
    }

    public function assignDriver(Request $request)
    {
        // dd($request->all());
        $driver  = Driver::where('id', $request->driverId)->first();
        if (isset($request->driverId)) {
            $assignDriver = OrderStatus::where('order_id', $request->orderId)->first();
            if ($assignDriver) {
                $assignDriver->update([
                    'driver_id' => $request->driverId,
                    'initial_status' => 'done',
                    'approved_status' => 'approve',
                    'driver_status' => 'approve',
                    'driver_collected_status' => 'approve',
                    'delivery_status' => 'approve'
                ]);
                $orderStatus = Order::where('id', $request->orderId)->first();
                $orderStatus->update([
                    'status' => "Driver assigned",
                ]);
                return response()->json(['status' => 'success', 'message' => "Driver assigned Successfully"]);
            } else {
                return response()->json(['status' => 'error', 'message' => "something went wrong! please try again later"]);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => "Please select a driver."]);
        }
    }
}

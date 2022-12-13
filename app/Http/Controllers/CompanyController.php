<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\Rate;

class CompanyController extends Controller
{
    public function index()
    {
        $data = Company::orderByDesc('created_at')->simplePaginate(15);

        return view('Company.index', compact('data'));
    }

    public function create()
    {
        return view('Company.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'company_name' => "required|max:155",
        ]);

        $company = new Company;
        $company->name = $request->company_name;
        $company->save();

        return redirect()->route('companies.view', ['id' => $company->id])->with('success', 'Company created successfully.');
    }

    public function statusUpdate($id)
    {

        $obj = Company::find($id);
        $obj->toggleStatus()->save();

        if ($obj->status == 0) {
            // return redirect::back()->with('message', 'User has Deactivated');
            return back()->with('message', 'Company has Deactivated');
        } else {
            // return redirect::back()->with('message', 'User has Activated');
            return back()->with('message', 'Company has Activated');
        }
    }

    // searchbox
    public function searchBox(Request $request)
    {

        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = Company::where('name', 'LIKE', "%{$query}%")
                    ->limit(15)
                    ->get();
            } else {
                $data = Company::orderByDesc('created_at')
                    ->limit(15)->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {

                $i = 0;
                foreach ($data as $row) {
                    if ($row->status == 1) {
                        $companyStatus = '<a href="' . route('companies.status', ['id' => $row->id]) . '" class="btn btn-danger" style="padding: 5px !important;"> <i class="ft-x-circle"></i> Disable</a>';
                    } else {
                        $companyStatus = '<a href="' . route('companies.status', ['id' => $row->id]) . '" class="btn btn-success" style="padding: 5px !important;"><i class="ft-check-circle"></i> Enable</a>';
                    }

                    $output .=
                        '<tr>
                            <td>' . ++$i . '</td>
                            <td>' . $row->name . '</td>
                            <td>
                                <a href="view/' . $row->id . '" class="btn btn-secondary" style="padding: 5px !important;"><i class="ft-eye"></i> View Details</a>
                                ' . $companyStatus . '
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

    public function profile($id)
    {
        $company = Company::find($id);
        $ratesNow = Rate::where('company_id', $id)->where('deliver_type', 'deliver_now')->first();
        $ratesLater = Rate::where('company_id', $id)->where('deliver_type', 'deliver_later')->first();
        // $Rates = Rate::where('company_id', $id)->first();
        // $bikeRate = Rate::where('company_id', $id)->where('vehicle', "bike")->first();
        // $packages = Package::where('user_id', $id)->get();
        // $address = Address::where('user_id', $id)->orderByDesc('created_at')->get();
        return view('Company.profile', ['company' => $company, "ratesNow" => $ratesNow, "ratesLater" => $ratesLater]);
    }

    public function storeRate(Request $request)
    {

        $request->validateWithBag($request->deliver_type, [
            "all_emirates_rate_bike" => "required|between:0,99.99",
            "all_emirates_rate_car" => "required|between:0,99.99",
            "all_emirates_rate_van" => "required|between:0,99.99",
            "special_city_rate_bike" => "required|between:0,99.99",
            "special_city_rate_car" => "required|between:0,99.99",
            "special_city_rate_van" => "required|between:0,99.99",
            "per_kilogram_rate" => "required|between:0,99.99",
        ]);
        if (isset($request->rate_id)) {
            $rate = Rate::where('id', $request->rate_id)->first();
            if ($rate) {
                $rate->all_emirates_rate_bike = $request->all_emirates_rate_bike;
                $rate->all_emirates_rate_car = $request->all_emirates_rate_car;
                $rate->all_emirates_rate_van = $request->all_emirates_rate_van;
                $rate->special_city_rate_bike = $request->special_city_rate_bike;
                $rate->special_city_rate_car = $request->special_city_rate_car;
                $rate->special_city_rate_van = $request->special_city_rate_van;
                $rate->per_kilogram_rate = $request->per_kilogram_rate;
                $rate->air_condition_rate = $request->air_condition_rate;
                $rate->save();
            }
        } else {
            $rate = new Rate;
            $rate->company_id = $request->company_id;
            $rate->all_emirates_rate_bike = $request->all_emirates_rate_bike;
            $rate->all_emirates_rate_car = $request->all_emirates_rate_car;
            $rate->all_emirates_rate_van = $request->all_emirates_rate_van;
            $rate->special_city_rate_bike = $request->special_city_rate_bike;
            $rate->special_city_rate_car = $request->special_city_rate_car;
            $rate->special_city_rate_van = $request->special_city_rate_van;
            $rate->per_kilogram_rate = $request->per_kilogram_rate;
            $rate->air_condition_rate = $request->air_condition_rate;
            $rate->deliver_type = $request->deliver_type;
            $rate->save();
        }
        return redirect()->back()->with($request->deliver_type, 'Rates saved successfully.');
    }

    public function carStore(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "car_kilometer" => "required|integer",
            "car_kilogram" => "required|integer",
        ]);
        if (isset($request->car_rate_id)) {
            $carRate = Rate::where('id', $request->car_rate_id)->where('vehicle', "car")->first();
            if ($carRate) {
                if ($request->car_air_cool == 0) {
                    $airCool = '';
                } else {
                    $airCool = $request->car_air_cool;
                }
                $carRate->kilometer_rate  = $request->car_kilometer;
                $carRate->kilogram_rate  = $request->car_kilogram;
                $carRate->air_cool_rate  = $airCool;
                $carRate->save();
            }
        } else {
            if ($request->car_air_cool == 0) {
                $airCool = '';
            } else {
                $airCool = $request->car_air_cool;
            }
            $rate = new Rate;
            $rate->company_id = $request->company_id;
            $rate->vehicle = "car";
            $rate->kilometer_rate  = $request->car_kilometer;
            $rate->kilogram_rate  = $request->car_kilogram;
            $rate->air_cool_rate  = $airCool;
            $rate->save();
        }
        return redirect()->back()->with('success', 'Car rate saved successfully.');
    }

    public function bikeStore(Request $request)
    {
        $request->validate([
            "bike_kilometer" => "required|integer",
            "bike_kilogram" => "required|integer",
        ]);
        if (isset($request->bike_rate_id)) {
            $bikeRate = Rate::where('id', $request->bike_rate_id)->where('vehicle', "bike")->first();
            if ($bikeRate) {
                if ($request->bike_air_cool == 0) {
                    $airCool = '';
                } else {
                    $airCool = $request->bike_air_cool;
                }
                $bikeRate->kilometer_rate  = $request->bike_kilometer;
                $bikeRate->kilogram_rate  = $request->bike_kilogram;
                $bikeRate->air_cool_rate  = $airCool;
                $bikeRate->save();
            }
        } else {
            if ($request->bike_air_cool == 0) {
                $airCool = '';
            } else {
                $airCool = $request->bike_air_cool;
            }
            $rate = new Rate;
            $rate->company_id = $request->company_id;
            $rate->vehicle = "bike";
            $rate->kilometer_rate  = $request->bike_kilometer;
            $rate->kilogram_rate  = $request->bike_kilogram;
            $rate->air_cool_rate  = $airCool;
            $rate->save();
        }
        return redirect()->back()->with('success', 'bike rate saved successfully.');
    }

    public function rateDiscount(Request $request)
    {
        $request->validate([
            // "discount" => "required",
            "company_id" => "required",
        ]);

        if (isset($request->company_id)) {
            $rate = Company::where('id', $request->company_id)->first();
            if ($rate) {
                // $rate->update(['discount' => $request->discount]);
                $rate->discount = $request->discount;
                $rate->save();
            } 
            return redirect()->back()->with('success-discount', 'Discount saved successfully.');
        } 
        // else {
        //     $rate = new Rate;
        //     $rate->company_id = $request->company_id;
        //     $rate->discount = $request->discount;
        //     $rate->save();
        //     return redirect()->back()->with('success-discount', 'Discount saved successfully.');
        // }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DataTables;
use App\Driver;
use App\Orderstatus;
use App\Order;
use App\Package;
use Image;
use DB;
use App\Vehicle;
use App\Company;

class DriverController extends Controller
{
    /**
     * driver driver profile view.
     *
     * @param mixed $request
     * @author Nived
     * @return bool
     */
    public function viewDrivers(Request $request)
    {
        return view('Drivers.drivers_card');
    }
    /**
     * driver listing table .
     *
     * @param mixed $request
     * @author Nived
     * @return bool
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Driver::latest()->where('status', 1)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $viewBtn = $editBtn =  $statusBtn = $deleteBtn = '';
                    $editBtn = '<a  href="' . route('drivers.edit', ['id' => $row->id]) . '"  data-toggle="tooltip" data-placement="top" data-container="body" title="" data-original-title="Edit Form" role="button" class="btn">' . getimage("images/edit.png") . '</a>';

                    // $deleteBtn = '<a  href="' . route('drivers.distroy', ['id' => $row->id]) . '"  data-toggle="tooltip" data-placement="top" data-container="body" title="" data-original-title="Edit Form" role="button" class="btn">' . getimage("images/cancel.png") . '</a>';

                    $statusBtn = '<a  href="' . route('drivers.distroy', ['id' => $row->id]) . '"  data-toggle="tooltip" data-placement="top" data-container="body" title="" data-original-title="Edit Form" role="button" class="btn">' . getimage("images/activate_new.png") . '</a>';
                    $class = 'delete-driver';
                    $attributes = [
                        "data-original-title" => "Delete Enrollment Form",
                        "data-id" => $row->id,
                        "data-name" => $row->fullname,
                        "data-status" => "delete",
                        "data-text-status" => "deleted"

                    ];
                    $deleteBtn = getDeleteBtn($class, $attributes);

                    // return $editBtn;
                    return '<div class="btn-group">' . $editBtn . $deleteBtn . $statusBtn . '<div>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('Drivers.list_drivers');
    }


    /**
     * driver registration form.
     *
     * @param mixed $request
     * @author Nived
     * @return bool
     */
    public function create(Request $request)
    {
        // $company = Company::where('status','active')->get();
        $companies = Company::get();
        return view('Drivers.create_drivers', ["companies" => $companies]);
    }

    public function edit($id)
    {
        // dd('hi all');
        $driverDetails = Driver::find($id);
        $driverName = explode(' ', $driverDetails->fullname);
        $firstname = $driverName[0];
        $lastname = $driverName[1];
        $licence = explode(',', $driverDetails->licence_file);

        $vehicle = Vehicle::where('driver_id', $id)->first();
        $vehicles = explode(',', $vehicle->file_path);
        // $company = Company::where('status','active')->get();
        $companies = Company::get();


        return view('Drivers.edit_drivers', ["companies" => $companies, "vehicles_details" => $vehicle, "vehicles" => $vehicles, "licences" => $licence, "driverDetails" => $driverDetails, "firstname" => $firstname, "lastname" => $lastname]);
    }


    /**
     * Prepares a driver registration for storing.
     *
     * @param mixed $request
     * @author Nived
     * @return bool
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname' => "required",
            "lastname" => "required",
            "date" => "required",
            "email" => "required|unique:users,email|email|unique:drivers,email",
            "phone" => "required",
            "password" => "required",
            "gender" => "required",
            'licenseImage' => 'required',

            'vehicle_type' => "required|in:van,car,bike",
            "model" => "required",
            "vehicle_number" => "required",
            "vehicleImage" => 'required',

            "profileImage" => "mimes:jpg,jpeg,png,svg,gif|max:2048",
            "distance" => "required",
            "emirates_id" => "required",
            "address" => "required",
            "company" => "required"
        ], [

            // 'profileImage.required' => 'Please choose profile image',
            'licenseImage.required' => 'Please upload license',
            'vehicleImage.required' => 'Please upload vehicle document',
            'emirates_id.required' => 'Please upload emirates document'
        ]);

        /**
         * Prepares a Profile image for storing.
         *
         * @param mixed $request
         * @author Nived
         * @return bool
         */
        $profilenametostore = '';
        if ($request->hasFile('profileImage')) {
            $profileImage = $request->file('profileImage');
            $filenamewithextension = $profileImage->getClientOriginalName();
            $profilename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $profileImage->getClientOriginalExtension();

            $profilenametostore = uniqid() . '.' . $extension;

            Storage::put('public/driver/profile/' . $profilenametostore, fopen($profileImage, 'r+'));
            Storage::put('public/driver/profile/thumbnail/' . $profilenametostore, fopen($profileImage, 'r+'));

            $profileThumbnailpath = public_path('storage/driver/profile/thumbnail/' . $profilenametostore);
            $img = Image::make($profileThumbnailpath);
            $img->resize(500, 500, function ($const) {
                $const->aspectRatio();
            })->save($profileThumbnailpath);
        }


        /**
         * Prepares a License image for storing.
         *
         * @param mixed $request
         * @author Nived
         * @return bool
         */
        $licenseFileName = '';
        if ($request->hasFile('licenseImage')) {
            // $imageName = '';
            foreach ($request->file('licenseImage') as $licensefile) {

                //get filename with extension
                $licensefilenamewithextension = $licensefile->getClientOriginalName();

                //get filename without extension
                $licensefilesname = pathinfo($licensefilenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $licenseextension = $licensefile->getClientOriginalExtension();

                //filename to store
                $licensefilenametostore = uniqid() . '.' . $licenseextension;
                $licenseFileName =  $licenseFileName . $licensefilenametostore . ",";
                Storage::put('public/driver/license/' . $licensefilenametostore, fopen($licensefile, 'r+'));
                Storage::put('public/driver/license/thumbnail/' . $licensefilenametostore, fopen($licensefile, 'r+'));

                //Resize image here
                $licensethumbnailpath = public_path('storage/driver/license/thumbnail/' . $licensefilenametostore);
                $img = Image::make($licensethumbnailpath)->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($licensethumbnailpath);
            }
        }
        /**
         * Prepares a emirates id image for storing.
         *
         * @param mixed $request
         * @author Nived
         * @return bool
         */

        $emiratesFileName = '';
        if ($request->hasFile('emirates_id')) {
            // $imageName = '';
            foreach ($request->file('emirates_id') as $emiratesfile) {

                //get filename with extension
                $emiratesfilenamewithextension = $emiratesfile->getClientOriginalName();

                //get filename without extension
                $emiratesfilesname = pathinfo($emiratesfilenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $emiratesextension = $emiratesfile->getClientOriginalExtension();

                //filename to store
                $emiratesfilenametostore = uniqid() . '.' . $emiratesextension;
                $emiratesFileName =  $emiratesFileName . $emiratesfilenametostore . ",";
                Storage::put('public/driver/emirates/' . $emiratesfilenametostore, fopen($emiratesfile, 'r+'));
                Storage::put('public/driver/emirates/thumbnail/' . $emiratesfilenametostore, fopen($emiratesfile, 'r+'));

                //Resize image here
                $emiratesthumbnailpath = public_path('storage/driver/emirates/thumbnail/' . $emiratesfilenametostore);
                $img = Image::make($emiratesthumbnailpath)->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($emiratesthumbnailpath);
            }
        }

        /**
         * Prepares a vehicle image for storing.
         *
         * @param mixed $request
         * @author Nived
         * @return bool
         */

        $vehicleFileName = '';
        if ($request->hasFile('vehicleImage')) {
            // $imageName = '';
            foreach ($request->file('vehicleImage') as $vehiclefile) {

                //get filename with extension
                $vehiclefilenamewithextension = $vehiclefile->getClientOriginalName();

                //get filename without extension
                $vehiclefilesname = pathinfo($vehiclefilenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $vehicleextension = $vehiclefile->getClientOriginalExtension();

                //filename to store
                $vehiclefilenametostore = uniqid() . '.' . $vehicleextension;
                $vehicleFileName =  $vehicleFileName . $vehiclefilenametostore . ",";
                Storage::put('public/driver/vehicle/' . $vehiclefilenametostore, fopen($vehiclefile, 'r+'));
                Storage::put('public/driver/vehicle/thumbnail/' . $vehiclefilenametostore, fopen($vehiclefile, 'r+'));

                //Resize image here
                $vehiclethumbnailpath = public_path('storage/driver/vehicle/thumbnail/' . $vehiclefilenametostore);
                $img = Image::make($vehiclethumbnailpath)->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($vehiclethumbnailpath);
            }
        }

        DB::transaction(function () use ($request, $licenseFileName, $vehicleFileName, $profilenametostore, $emiratesFileName) {
            $data = new Driver;
            $data['fullname'] = $request->firstname . " " . $request->lastname;
            $data['status'] = 1;
            $data['email'] = $request->email;
            $data['phone'] = $request->phone;
            $data['gender'] = $request->gender;
            $data['dob'] = $request->date;
            $data['address'] = $request->address;
            $data['profile'] = $profilenametostore;
            $data['emirates_id'] = rtrim($emiratesFileName, ',');
            $data['distance'] = $request->distance;
            $data['show_password'] = $request->password;
            $data['password'] = $request->password ? bcrypt($request->password) : "";
            $data['licence_file'] = rtrim($licenseFileName, ',');
            $data['unique_id'] = uniqid();
            $data['company_id'] = $request->company;
            $data->save();

            $vehicles = Vehicle::create([
                'file_path' => rtrim($vehicleFileName, ','),
                'driver_id' => $data->id,
                'model' => $request->model,
                'type' => $request->vehicle_type,
                'vehicle_number' => $request->vehicle_number
            ]);
        });
        // return back()->with('success', 'Driver added successfully.');
        return redirect()->route('drivers.index')->with('success', 'Driver added successfully.');
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            'firstname' => "required",
            "lastname" => "required",
            "date" => "required",
            "email" => "required",
            "phone" => "required",
            "password" => "required",
            "gender" => "required",

            'vehicle_type' => "required|in:van,car,bike",
            "model" => "required",
            "vehicle_number" => "required",

            "profileImage" => "mimes:jpg,jpeg,png,svg,gif|max:2048",
            "distance" => "required",
            "emirates_id" => "required",
            "address" => "required",
            "company" => "required",
        ], [

            'profileImage.required' => 'Please choose profile image',
            'licenseImage.required' => 'Please upload license',
            'vehicleImage.required' => 'Please upload vehicle document'
        ]);

        /**
         * Prepares a Profile image for storing.
         *
         * @param mixed $request
         * @author Nived
         * @return bool
         */
        $profilenametostore = '';
        if ($request->hasFile('profileImage')) {

            $profileImage = $request->file('profileImage');
            $filenamewithextension = $profileImage->getClientOriginalName();
            $profilename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $profileImage->getClientOriginalExtension();

            $profilenametostore = uniqid() . '.' . $extension;

            Storage::put('public/driver/profile/' . $profilenametostore, fopen($profileImage, 'r+'));
            Storage::put('public/driver/profile/thumbnail/' . $profilenametostore, fopen($profileImage, 'r+'));

            $profileThumbnailpath = public_path('storage/driver/profile/thumbnail/' . $profilenametostore);
            $img = Image::make($profileThumbnailpath);
            $img->resize(500, 500, function ($const) {
                $const->aspectRatio();
            })->save($profileThumbnailpath);
        }


        /**
         * Prepares a License image for storing.
         *
         * @param mixed $request
         * @author Nived
         * @return bool
         */
        $licenseFileName = '';
        if ($request->hasFile('licenseImage')) {
            // $imageName = '';
            foreach ($request->file('licenseImage') as $licensefile) {

                //get filename with extension
                $licensefilenamewithextension = $licensefile->getClientOriginalName();

                //get filename without extension
                $licensefilesname = pathinfo($licensefilenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $licenseextension = $licensefile->getClientOriginalExtension();

                //filename to store
                $licensefilenametostore = uniqid() . '.' . $licenseextension;
                $licenseFileName =  $licenseFileName . $licensefilenametostore . ",";
                Storage::put('public/driver/license/' . $licensefilenametostore, fopen($licensefile, 'r+'));
                Storage::put('public/driver/license/thumbnail/' . $licensefilenametostore, fopen($licensefile, 'r+'));

                //Resize image here
                $licensethumbnailpath = public_path('storage/driver/license/thumbnail/' . $licensefilenametostore);
                $img = Image::make($licensethumbnailpath)->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($licensethumbnailpath);
            }
        }

        $emiratesFileName = '';
        if ($request->hasFile('emirates_id')) {
            // $imageName = '';
            foreach ($request->file('emirates_id') as $emiratesfile) {

                //get filename with extension
                $emiratesfilenamewithextension = $emiratesfile->getClientOriginalName();

                //get filename without extension
                $emiratesfilesname = pathinfo($emiratesfilenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $emiratesextension = $emiratesfile->getClientOriginalExtension();

                //filename to store
                $emiratesfilenametostore = uniqid() . '.' . $emiratesextension;
                $emiratesFileName =  $emiratesFileName . $emiratesfilenametostore . ",";
                Storage::put('public/driver/emirates/' . $emiratesfilenametostore, fopen($emiratesfile, 'r+'));
                Storage::put('public/driver/emirates/thumbnail/' . $emiratesfilenametostore, fopen($emiratesfile, 'r+'));

                //Resize image here
                $emiratesthumbnailpath = public_path('storage/driver/emirates/thumbnail/' . $emiratesfilenametostore);
                $img = Image::make($emiratesthumbnailpath)->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($emiratesthumbnailpath);
            }
        }

        /**
         * Prepares a vehicle image for storing.
         *
         * @param mixed $request
         * @author Nived
         * @return bool
         */

        $vehicleFileName = '';
        if ($request->hasFile('vehicleImage')) {
            // $imageName = '';
            foreach ($request->file('vehicleImage') as $vehiclefile) {

                //get filename with extension
                $vehiclefilenamewithextension = $vehiclefile->getClientOriginalName();

                //get filename without extension
                $vehiclefilesname = pathinfo($vehiclefilenamewithextension, PATHINFO_FILENAME);

                //get file extension
                $vehicleextension = $vehiclefile->getClientOriginalExtension();

                //filename to store
                $vehiclefilenametostore = uniqid() . '.' . $vehicleextension;
                $vehicleFileName =  $vehicleFileName . $vehiclefilenametostore . ",";
                Storage::put('public/driver/vehicle/' . $vehiclefilenametostore, fopen($vehiclefile, 'r+'));
                Storage::put('public/driver/vehicle/thumbnail/' . $vehiclefilenametostore, fopen($vehiclefile, 'r+'));

                //Resize image here
                $vehiclethumbnailpath = public_path('storage/driver/vehicle/thumbnail/' . $vehiclefilenametostore);
                $img = Image::make($vehiclethumbnailpath)->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $img->save($vehiclethumbnailpath);
            }
        }

        DB::transaction(function () use ($request, $licenseFileName, $vehicleFileName, $profilenametostore, $emiratesFileName) {
            $data =  Driver::find($request->driver_id);
            $data->fullname = $request->firstname . " " . $request->lastname;
            // $data['status'] = 1;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->gender = $request->gender;
            $data->dob = $request->date;
            $data->address = $request->address;
            $data->profile = $profilenametostore;
            $data->emirates_id = rtrim($emiratesFileName, ',');
            $data->distance = $request->distance;
            $data->password = $request->password ? bcrypt($request->password) : "";
            $data->licence_file = rtrim($licenseFileName, ',');
            $data->company_id = $request->company;
            $data->save();

            $vehicles = Vehicle::where('driver_id', $data->id)->first();
            $vehicles->update([
                'file_path' => rtrim($vehicleFileName, ','),
                'driver_id' => $data->id,
                'model' => $request->model,
                'type' => $request->vehicle_type,
                'vehicle_number' => $request->vehicle_number
            ]);
        });
        // return back()->with('success', 'Driver added successfully.');
        return redirect()->route('drivers.index')->with('success', 'Driver added successfully.');
    }

    public function distroy(Request $request)
    {
        // $driver = $request->all();
        // dd($driver);
        // $driver->delete();
        // if ($request->status == 'delete') {
        // $pendingLeads = Telesales::where('form_id', $request->id)->where('status', 'pending')->get();
        // if ($pendingLeads->count() > 0) {
        //     return response()->json(['status' => 'error',  'message' => 'This enrollment form cannot be deleted, as there are pending leads of this form.']);
        // } else {
        try {
            $drivers = Drivers::find($request->id);
            if ($drivers) {
                DB::beginTransaction();
                // FormScripts::where('form_id', $request->id)->delete();
                Drivers::where('id', $request->id)->delete();
                DB::commit();
                return response()->json(['status' => 'success',  'message' => 'Enrollment form successfully deleted.']);
            } else {
                return $this->success('success', 'Something went wrong, please try again later.');
            }
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
        }
        // }
        // } else {
        // Clientsforms::where('id', $request->id)->update(['status' => $request->status]);
        //     return response()->json(['status' => 'success',  'message' => 'Enrollment form successfully updated.']);
        // }
        // return view('Drivers.edit_drivers');
        // return back()->with('success', 'Driver deleted successfully.');
    }

    // searchbox
    public function searchBox(Request $request)
    {

        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            if ($query != '') {
                $data = Driver::Where('fullname', 'LIKE', '%' . $query . '%')
                    ->where('status', 1)
                    // ->orWhere('email', 'LIKE', '%' . $query . '%')   
                    ->get();
            } else {
                $data = Driver::orderBy('fullname', 'asc')
                    ->where('status', 1)
                    ->get();
            }
            $total_row = $data->count();
            if ($total_row > 0) {


                foreach ($data as $row) {
                    if ($row->status == 1) {
                        $driverStatus = '<a href="' . route('driver.status', ['id' => $row->id]) . '" class="btn btn-warning" style="padding: 5px !important;"> <i class="ft-x-circle"></i> Disable</a>';
                    } else {
                        $driverStatus = '<a href="' . route('driver.status', ['id' => $row->id]) . '" class="btn btn-success" style="padding: 5px !important;"><i class="ft-check-circle"></i> Enable</a>';
                    }

                    $output .=
                        '<tr>
                    <td>' . $row->fullname . '</td>
                    <td>' . $row->email . '</td>
                    <td>' . $row->phone . '</td>
                    <td>' . $row->dob . '</td>
                    <td>
                        <a href="edit/' . $row->id . '" class="btn btn-primary" style="padding: 5px !important;"> <i class="ft-edit"></i> Edit</a>
                        ' . $driverStatus . '
                        <a href="' . route('driver.delete', ['id' => $row->id]) . '" class="btn btn-danger" style="padding: 5px !important;"> <i class="ft-delete"></i> Delete</a>
                        <a href="view/' . $row->id . '" class="btn btn-secondary" style="padding: 5px !important;"><i class="ft-eye"></i> View Details</a>
                    </td>
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

    public function statusUpdate($id)
    {

        $obj = Driver::find($id);
        $obj->toggleStatus()->save();

        if ($obj->status == 0) {
            // return redirect::back()->with('message', 'driver has Deactivated');
            return back()->with('message', 'driver has Deactivated');
        } else {
            // return redirect::back()->with('message', 'driver has Activated');
            return back()->with('message', 'driver has Activated');
        }
    }
    public function destroy($id)
    {

        Driver::where('id', $id)->update([
            "status" => 0
        ]);
        Vehicle::where('driver_id', $id)->update([
            "status" => 0
        ]);

        return back()->with('message', 'driver Deleted');
    }

    public function upload(Request $request)
    {
        $this->validate($request, [
            'profileImage' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        // dd($request->file('profileImage'));

        $this->storeImage($request);
    }


    /**
     * Prepares a image for storing.
     *
     * @param mixed $request
     * @author Niklas Fandrich
     * @return bool
     */
    public function storeImage($request)
    {
        // Get file from request
        $file = $request->file('profileImage');

        // Get filename with extension
        $filenameWithExt = $file->getClientOriginalName();

        // Get file path
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

        // Remove unwanted characters
        $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
        $filename = preg_replace("/\s+/", '-', $filename);

        // Get the original image extension
        $extension = $file->getClientOriginalExtension();

        // Create unique file name
        $fileNameToStore = $filename . '_' . time() . '.' . $extension;

        // Refer image to method resizeImage
        $save = $this->resizeImage($file, $fileNameToStore);

        return true;
    }

    /**
     * Resizes a image using the InterventionImage package.
     *
     * @param object $file
     * @param string $fileNameToStore
     * @author Niklas Fandrich
     * @return bool
     */
    public function resizeImage($file, $fileNameToStore)
    {
        // Resize image
        $resize = Image::make($file)->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');

        // Create hash value
        $hash = md5($resize->__toString());

        // Prepare qualified image name
        $image = $hash . "jpg";

        // Put image to storage
        $save = Storage::put("public/driver/{$fileNameToStore}", $resize->__toString());

        if ($save) {
            return true;
        }
        return false;
    }

    public function viewDriverdetails($id)
    {
        $driver = Driver::find($id);
        if ($driver) {
            $vehicleDetails = Vehicle::where('driver_id', $driver->id)->first();
            // vehicle file
            if (isset($vehicleDetails->file_path)) {
                $vehicleImage = explode(',', $vehicleDetails->file_path);
                // dd($images);
            } else {
                $vehicleImage = [];
            }
            // licence file
            if (isset($driver->licence_file)) {
                $licence = explode(',', $driver->licence_file);
                // dd($images);
            } else {
                $licence = [];
            }
            // emirate files
            if (isset($driver->emirates_id)) {
                $emirates = explode(',', $driver->emirates_id);
                // dd($images);
            } else {
                $emirates = [];
            }

            $company = Company::where('id', $driver->company_id)->first();


            $orderStatuses = Orderstatus::where('driver_id', $driver->id)->orderByDesc('created_at')->get();

            $orders = [];
            if ($orderStatuses) {
                foreach ($orderStatuses as $order) {
                    $orders[] = Order::where('id', $order->order_id)->with(['orderstatus', 'package'])->first();
                }
            }

            return view('Drivers/details', ["company"=>$company,"emirates" => $emirates, "vehicleImage" => $vehicleImage, 'driver' => $driver, 'orders' => $orders, 'vehicle' => $vehicleDetails, "licences" => $licence]);
        }
    }
}

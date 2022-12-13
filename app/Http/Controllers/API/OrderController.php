<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Package;
use App\PackageMedia;
use App\User;
use App\Addres;
use App\Order;
use App\Orderstatus;
use App\Driver;
use DB;
use Exception;
use Illuminate\Support\Facades\Http;
use Log;
use OneSignal;

class OrderController extends Controller
{
    // generate unique order id
    public function generateUniqueCode()
    {
        do {
            $order_id = random_int(100000, 999999);
        } while (Order::where("order_id", "=", $order_id)->first());

        return $order_id;
    }


    public function createOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'package_id' => 'required',
                // 'company_id' => 'required',
                'payment_method' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 200);
            }
            // user is required
            if (isset($request->user_id)) {
                // check user
                $existingUser = User::find($request->user_id);
                if ($existingUser) {
                    // package required
                    if (isset($request->package_id)) {
                        // check package
                        $existingPackage = Package::find($request->package_id);
                        // $packagemedia = PackageMedia::where('package_id',$existingPackage->id)->first();
                        // $image = [];
                        // $images = explode(',', $packagemedia->image);
                        // foreach($images as $value){

                        //     // $image[] = Storage::disk('local')->getAdapter()->applyPathPrefix($value);
                        //     // Storage::disk('local')->path($value);
                        //     $image[]  = config('app.url') . Storage::url('public/packages/thumbnail/' . $value);
                        // }
                        // exit();
                        // dd($image);
                        if ($existingPackage) {
                            $existingOrder = Order::where('package_id', $request->package_id)->first();
                            if (isset($existingOrder)) {
                                return $this->error("This Package is already used", 200);
                            }
                            DB::transaction(function () use ($request, &$data) {
                                $order = new Order;
                                $order->user_id = $request->user_id;
                                $order->order_id = $this->generateUniqueCode();
                                $response = Http::post('https://asia-southeast1-movex-delivery.cloudfunctions.net/app/chat_thread', [
                                    'order_id' => $order->order_id
                                ]);
                                $order->chat_id = isset($response['chat_id']) ? $response['chat_id'] : '';
                                Log::info('chat is reponse : ' . $order->chat_id);
                                // $order->chat_id = '';
                                $order->package_id = $request->package_id;
                                $order->merchant_id = $request->merchant_id;
                                $order->payment_type = $request->payment_method;
                                $order->payment_id = $request->payment_id ? $request->payment_id : null;
                                $order->status = "pending";
                                $order->company_id = $request->company_id ? $request->company_id : '';

                                $packageDeatils = Package::find($request->package_id);
                                $order->total_amount = $request->total_amount ? number_format($request->total_amount, 2, '.', '') : " ";
                                // dd($packageDeatils->amount);

                                $order->save();

                                $orderStatus = new Orderstatus;
                                $orderStatus->order_id = $order->id ?  $order->id : '';
                                $orderStatus->initial_status = $request->initial_status ?  $request->initial_status : "pending";
                                $orderStatus->approved_status = $request->approved_status ?  $request->approved_status : "pending";
                                $orderStatus->driver_status = $request->driver_status ?  $request->driver_status : "pending";
                                $orderStatus->driver_collected_status = $request->driver_collected_status ?  $request->driver_collected_status : "pending";
                                $orderStatus->delivery_status = $request->delivery_status ?  $request->delivery_status : "pending";
                                if (isset($request->driver_id)) {
                                    $driverDetails = Driver::where('id', $request->driver_id)->first();
                                    if ($driverDetails) {
                                        $orderStatus->driver_id = $request->driver_id ?  $driverDetails->id : 0;
                                    }
                                }

                                $orderStatus->save();
                                // One signal notification
                                OneSignal::sendNotificationToAll(
                                    "New order is Placed.",
                                    $url = null,
                                    $data = null,
                                    $buttons = null,
                                    $schedule = null
                                );

                                $data = array(
                                    "id" => $order->id,
                                    "order_status" => $order->status ? $order->status : "pending",
                                    "order_id" => $order->order_id ?  $order->order_id : '',
                                    'chat_id' => $order->chat_id ?  $order->chat_id : '',
                                    "user_id" => $order->user_id ?  $order->user_id : '',
                                    "package_id" => $order->package_id ?  $order->package_id : '',
                                    "company_id" => $order->company_id ?  $order->company_id : '',
                                    "merchant_id" => $order->merchant_id ?  $order->merchant_id : '',
                                    "payment_method" => $order->payment_type ?  $order->payment_type : '',
                                    "payment_id" => $order->payment_id ?  $order->payment_id : '',
                                    "total_amount" => $order->total_amount ? $order->total_amount : '',
                                    'initial_status' => $orderStatus->initial_status ?  $orderStatus->initial_status : '',
                                    'approved_status' => $orderStatus->approved_status ?  $orderStatus->approved_status : '',
                                    'driver_status' => $orderStatus->driver_status ?  $orderStatus->driver_status : '',
                                    'driver_collected_status' => $orderStatus->driver_collected_status ?  $orderStatus->driver_collected_status : '',
                                    'delivery_status' => $orderStatus->delivery_status ?  $orderStatus->delivery_status : '',
                                    'driver_id' => $orderStatus->driver_id ?  $orderStatus->driver_id : 'Please wait we are assigning a driver for you',
                                    'driver_name' =>  '',
                                    'driver_phone' => '',
                                    'driver_email' => ''
                                );
                            });

                            return $this->success('Order placed successfully', $data);
                        } else {
                            return $this->error("Package does not exist.", 200);
                        }
                    } else {
                        return $this->error("Package id required..", 200);
                    }
                } else {
                    return $this->error("User does not exist.", 200);
                }
            } else {
                return $this->error("User id required.", 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, Please try again later.'
            ], 200);
        }
    }
    public function cancelOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required'
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 200);
            }
            // user is required
            if (isset($request->order_id)) {
                // check user
                $order = Order::find($request->order_id);
                $order->cancel_reason=$request->cancel_reason;
                if ($order) {
                    DB::transaction(function () use ($order, &$data) {
                        $order->update([
                            'status' => 'cancel',
                            'cancel_reason'=>$order->cancel_reason
                        ]);
                        // One signal notification
                        try{
                            OneSignal::sendNotificationToAll(
                                "Your order is canceled.",
                                $url = null,
                                $data = null,
                                $buttons = null,
                                $schedule = null
                            );
                        }catch(Exception $e){
                            Log::info("api --cancelOrder -- Notification send error: " . $e);
                        }
                        $data = array(
                            "id" => $order->id,
                            "order_status" => "cancel",
                            "order_id" => $order->order_id ?  $order->order_id : '',
                            'chat_id' => $order->chat_id ?  $order->chat_id : '',
                            "user_id" => $order->user_id ?  $order->user_id : '',
                            "package_id" => $order->package_id ?  $order->package_id : '',
                            "company_id" => $order->company_id ?  $order->company_id : '',
                            "merchant_id" => $order->merchant_id ?  $order->merchant_id : '',
                            "payment_method" => $order->payment_type ?  $order->payment_type : '',
                            "payment_id" => $order->payment_id ?  $order->payment_id : '',
                            "total_amount" => $order->total_amount ? $order->total_amount : '',
                            "cancel_reason" => $order->cancel_reason ? $order->cancel_reason : ''
                        );
                    });
                    Log::info("api --cancelOrder -- order id " . $order->id);
                    return $this->success('Order canceled successfully', $data);
                } else {
                    return $this->error("Order does not exist.", 200);
                }
            } else {
                return $this->error("Order id required.", 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, Please try again later.'
            ], 200);
        }
    }
    public function orderStatus(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required',
            ]);
            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 200);
            }
            if (isset($request->order_id)) {
                $orderCheck = Orderstatus::where('order_id', $request->order_id)->first();
                // dd($orderCheck);
                if ($orderCheck) {
                    $orderDetails = Orderstatus::where("id", $orderCheck->id)->first();

                    $order = Order::where("id", $orderCheck->order_id)->first();

                    $driverDetails = Driver::where("id", 2)->first();

                    if (isset($orderDetails->driver_id)) {
                        $response = array(
                            'id' => $order->id ?  $order->id : '',
                            'order_id' => $order->order_id ?  $order->order_id : '',
                            'chat_id' => $order->chat_id ?  $order->chat_id : '',
                            'initial_status' => $orderDetails->initial_status ?  $orderDetails->initial_status : '',
                            'approved_status' => $orderDetails->approved_status ?  $orderDetails->approved_status : '',
                            'driver_status' => $orderDetails->driver_status ?  $orderDetails->driver_status : '',
                            'driver_collected_status' => $orderDetails->driver_collected_status ?  $orderDetails->driver_collected_status : '',
                            'delivery_status' => $orderDetails->delivery_status ?  $orderDetails->delivery_status : '',
                            'driver_id' => $orderDetails->driver_id ?  (string)$orderDetails->driver_id : '',
                            'driver_name' => $driverDetails->fullname ?  $driverDetails->fullname : '',
                            'driver_phone' => $driverDetails->phone ?  (string)$driverDetails->phone : '',
                            'driver_email' => $driverDetails->email ?  $driverDetails->email : '',
                            "order_status" => $order->status ? $order->status : ''
                        );
                    } else {
                        $response = array(
                            'id' => $order->id ?  $order->id : '',
                            'order_id' => $order->order_id ?  $order->order_id : '',
                            'chat_id' => $order->chat_id ?  $order->chat_id : '',
                            'initial_status' => $orderDetails->initial_status ?  $orderDetails->initial_status : '',
                            'approved_status' => $orderDetails->approved_status ?  $orderDetails->approved_status : '',
                            'driver_status' => $orderDetails->driver_status ?  $orderDetails->driver_status : '',
                            'driver_collected_status' => $orderDetails->driver_collected_status ?  $orderDetails->driver_collected_status : '',
                            'delivery_status' => $orderDetails->delivery_status ?  $orderDetails->delivery_status : '',
                            'driver_id' => $orderDetails->driver_id ?  (string)$orderDetails->driver_id : 'Please wait we are assigning a driver for you',
                            'driver_name' =>  '',
                            'driver_phone' => '',
                            'driver_email' => '',
                            "order_status" => $order->status ? $order->status : ''
                        );
                    }

                    return $this->success('Order details retrived successfully', $response);
                } else {
                    return $this->error("order_id is no more available", 200);
                }
            } else {
                return $this->error("order_id field is required", 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong, Please try again later.'
            ], 200);
        }
    }
}

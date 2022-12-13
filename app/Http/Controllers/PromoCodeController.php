<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\PromoCode;
use DB;
use Log;


class PromoCodeController extends Controller
{
    public function create()
    {
       
        return view('PromoCode.create-form');
    }
    function store(Request $request)
    {
        if ($request->codeID) {
            Log::info("inside update function");
           
            $promoCode = PromoCode::where('id', $request->codeID)->first();
            if ($promoCode) {
                Log::info("banner is available");
               
                    Log::info("promo code is available");
                    $promoCode->code = $request->editCode ? $request->editCode : '';
                    $promoCode->discount = $request->editDiscount ? $request->editDiscount : '';
                    $promoCode->save();
              //  }
            } else {
                return redirect()->back()->with('error', 'Promo code not available anymore.');
            }
        } else {  // insert new record
		
		
             $request->validate([
                'code' => 'required',
            ], [
                'code.required' => 'Please add promo code',
            ]); 
            Log::info("inside store function");
           
				$promoCode           = new PromoCode;
                $promoCode->code     = $request->code ? $request->code : '';
                $promoCode->discount = $request->discount ? $request->discount : '';
                $promoCode->save();
			
        }
       
        return redirect()->back()->with('success', 'Promo code added successfully.');
    }
    function edit(Request $request)
    {
        $promoCode = PromoCode::where('id', $request->id)->first();

        return response()->json(['status' => 'success', "code" => $promoCode->code]);
    }
    function update(Request $request)
    {
    }
    function destroy(Request $request)
    {
    }
  
    function fetch()
    {
       $data = PromoCode::orderBy('created_at', 'desc')->get();
		 $i = 0;
		  $output = '';
		foreach ($data as $row) {
			$output .='<tr>
                            <td>' . ++$i . '</td>
                            <td>' . $row->code . '</td>
                            <td>' . $row->discount . '</td>
                            </tr> ';
		
		}
		
		 $finalData = array(
                'table_data' => $output
            );

          
            return response()->json($finalData);
        
      //  echo $output;
       
    }
   
    function delete(Request $request)
    {

      
    }
}

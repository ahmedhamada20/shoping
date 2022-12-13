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
        return view('Promocode.create-form');
    }
    function store(Request $request)
    {
        if ($request->codeID) {
            Log::info("inside update function");
            // dd($request->all());
            $promoCode = PromoCode::where('id', $request->codeID)->first();
            if ($promoCode) {
                Log::info("banner is available");
                // $banner->url = $request->url;

                /* $bannerFileName = '';
                if ($request->hasFile('bannerImage')) {
                    $request->validate([
                        'bannerImage' => 'max:1024',
                    ], [
                        'bannerImage.max' => 'Please upload max size of 10 MB',
                    ]);

                    Log::info("image file is available");
                    // $imageName = '';
                    foreach ($request->file('bannerImage') as $bannerfile) {

                        //get filename with extension
                        $bannerfilenamewithextension = $bannerfile->getClientOriginalName();

                        //get filename without extension
                        $bannerfilesname = pathinfo($bannerfilenamewithextension, PATHINFO_FILENAME);

                        //get file extension
                        $bannerextension = $bannerfile->getClientOriginalExtension();

                        //filename to store
                        $bannerfilenametostore = uniqid() . '.' . $bannerextension;
                        $bannerFileName =  $bannerFileName . $bannerfilenametostore . ",";
                        Storage::put('public/banner/' . $bannerfilenametostore, fopen($bannerfile, 'r+'));
                        Storage::put('public/banner/thumbnail/' . $bannerfilenametostore, fopen($bannerfile, 'r+'));

                        //Resize image here
                        $bannerthumbnailpath = public_path('storage/banner/thumbnail/' . $bannerfilenametostore);
                        $img = Image::make($bannerthumbnailpath)->resize(1000, 900, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $img->save($bannerthumbnailpath);
                    }
                    Log::info("image is uploaded");
                    $BannerImage = rtrim($bannerFileName, ',');
                    $BannerImage = explode(",", $BannerImage);

                    foreach ($BannerImage as $image) {
                        // $banner = new Banner;
                        $banner->url = $request->editURL ? $request->editURL : '';
                        $banner->image = $image;
                        $banner->save();
                    }
                    Log::info("success image uploaded");
                } else { */ 
                    Log::info("promo code is available");
                    $promoCode->code = $request->editCode ? $request->editCode : '';
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
           
				$promoCode       = new PromoCode;
                $promoCode->code = $request->code ? $request->code : '';
                $promoCode->save();
			
        }
        // return redirect()->route('drivers.index')->with('success', 'Driver added successfully.');
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
        // $images = \File::allFiles(public_path('images'));
        // $images = $files = Storage::disk('public')->allFiles();

        $data = PromoCode::orderBy('created_at', 'desc')->get();
		 $i = 0;
		  $output = '';
		foreach ($data as $row) {
			$output .='<tr>
                            <td>' . ++$i . '</td>
                            <td>' . $row->code . '</td>
                            </tr> ';
		
		}
		
		 $finalData = array(
                'table_data' => $output
            );

          
            return response()->json($finalData);
        
      //  echo $output;
       
    }
    // edit button
    // <a type="button" class="btn btn-link edit_image" id="' . $image->id . '" style ="padding: 10px 10px 0 0 ;"> <img src="' . asset('admin/images/edit.png') . '" class="img-thumbnail" style="height:25px; " /></a>

    function delete(Request $request)
    {

        $banner = Banner::where('id', $request->id)->first();
        if ($banner) {
            $path = asset('/storage/banner/' . $banner->image);
            // dd(Storage::delete($path));
            // if (Storage::exists($path)) {
            Storage::delete($path);
            // }
            $banner->delete();
        }

        return response()->json(['status' => 'success', "message" => "Deleted successfully"]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Banner;
use Image;
use DB;
use Log;


class BannerController extends Controller
{
    public function create()
    {
        return view('Banner.create-form');
    }
    function store(Request $request)
    {
        if ($request->bannerID) {
            Log::info("inside update function");
            // dd($request->all());
            $banner = Banner::where('id', $request->bannerID)->first();
            if ($banner) {
                Log::info("banner is available");
                // $banner->url = $request->url;

                $bannerFileName = '';
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
                } else {
                    Log::info("only url is available");
                    $banner->url = $request->editURL ? $request->editURL : '';
                    $banner->save();
                }
            } else {
                return redirect()->back()->with('error', 'Banner not available anymore.');
            }
        } else {
            $request->validate([
                'bannerImage' => 'required|max:1024',
            ], [
                'bannerImage.required' => 'Please upload Banner',
                'bannerImage.max' => 'Please upload max size of 10 MB',
            ]);
            Log::info("inside store function");
            $bannerFileName = '';
            if ($request->hasFile('bannerImage')) {
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
                    $img = Image::make($bannerthumbnailpath)->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($bannerthumbnailpath);
                }
            }


            // $banner->url = $request->url ? $request->url : '';
            $BannerImage = rtrim($bannerFileName, ',');
            $BannerImage = explode(",", $BannerImage);

            foreach ($BannerImage as $image) {
                $banner = new Banner;
                $banner->url = $request->url ? $request->url : '';
                $banner->image = $image;
                $banner->save();
            }
        }
        // return redirect()->route('drivers.index')->with('success', 'Driver added successfully.');
        return redirect()->back()->with('success', 'Banner Uploaded successfully.');
    }
    function edit(Request $request)
    {
        $banner = Banner::where('id', $request->id)->first();

        return response()->json(['status' => 'success', "url" => $banner->url]);
    }
    function update(Request $request)
    {
    }
    function destroy(Request $request)
    {
    }
    function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $image = $request->file('file');

            $imageName = uniqid() . '.' . $image->extension();
            $banner = new Banner;
            $banner->image = $imageName;
            Storage::put('public/banner/' . $imageName, fopen($image, 'r+'));
            // Storage::put('public/banner/thumbnail/' . $imageName, fopen($image, 'r+'));
            $banner->save();

            // $image->move(public_path('images'), $imageName);

            return response()->json(['success' => $imageName]);
        }
    }

    function fetch()
    {
        // $images = \File::allFiles(public_path('images'));
        // $images = $files = Storage::disk('public')->allFiles();

        $images = Banner::orderBy('created_at', 'desc')->get();
        $output = '<div class="row">';
        foreach ($images as $image) {
            $output .= '
      <div class="col-md-2" style="margin-bottom:16px;" align="center">
                <img src="' . asset('storage/banner/' . $image->image) . '" class="img-thumbnail" width="205" height="175" style="height:145px;" />
                <a type="button" class="btn btn-link remove_image" id="' . $image->id . '" style ="padding: 10px 10px 0 0 ;"> <img src="' . asset('admin/images/cancel.png') . '" class="img-thumbnail" style="height:25px;" /></a>
            </div>
      ';
        }
        $output .= '</div>';
        echo $output;
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

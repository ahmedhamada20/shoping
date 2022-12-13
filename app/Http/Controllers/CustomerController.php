<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class CustomerController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

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
        $file = $request->file('image');

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
        $save = Storage::put("public/images/{$fileNameToStore}", $resize->__toString());

        if ($save) {
            return true;
        }
        return false;
    }

    
}

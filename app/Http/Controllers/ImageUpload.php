<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUpload extends Controller
{
    //
    function index(){
        return view('image.image');
    }
   
   


    public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // 2 MB
    ]);






    $file   = $validated['image'];                 // Illuminate\Http\UploadedFile
    // Patient images go to private storage and are only served to signed-in staff (see file()).
    $path = $request->file('image')->store('images', 'local');


    Image::create([
        'title'     => $validated['title'],
        'path'      => $path,
        'mime_type' => $file->getClientMimeType(),
        'size'      => $file->getSize(),
    ]);

    return redirect()
        ->route('pages.status')
        ->with('success', 'Image uploaded successfully');
}


    // Streams a case-file image to a signed-in user. New uploads are on the private disk;
    // images uploaded before this change are still on the public disk and are read from there.
    public function file(Image $image)
    {
        $path = $image->path ?: $image->file_path;
        abort_if(blank($path) || str_contains($path, '..'), 404);

        foreach (['local', 'public'] as $disk) {
            if (Storage::disk($disk)->exists($path)) {
                return Storage::disk($disk)->response($path, null, [
                    'Cache-Control' => 'private, no-store',
                ]);
            }
        }

        abort(404);
    }

            public function display() {
              $images = Image::all();
            return view('image.image_list', compact('images'));
        }
        public function search()
        {
            return view('image.image_search');
        }
        
       
      

        public function searchResult(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Retrieve all images that match the title
    $images = Image::where('title', $request->input('name'))->get();

    if ($images->isNotEmpty()) {
        // If there are matching images, pass them to the view
        return view('image.image_display', ['images' => $images, 'name' => $request->input('name')]);
    } else {
        // If no images are found
        return back()->with('error', 'No image found with that name.');
    }
}

            
}

<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\User;
use App\Models\UserImages;
use Illuminate\Http\Request;

class UploadImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $id) {
        $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        $images = [];
        $files = Storage::disk('s3')->files('file');
            foreach ($files as $file) {
                $images[] = [
                    'name' => str_replace('images/', '', $file),
                    'src' => $url . $file
                ];
            }
       
        return view('user.upload', compact('id'));
    
    }

    public function store(Request $request) {
        
        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $user_id = $_GET['user_id'];
            $path = $request->file('file')->store('images', 's3');
            // $filePath = 'images/' . $imageName;
            // $request->file('file')->store('docs');
            // $request->file->move(public_path('img'), $imageName);

            $image = UserImages::create([
                'user_id' =>  $user_id,
                'filename' => basename($path),
                'url' => Storage::disk('s3')->url($path)
            ]);
            
            dd($image);

            return redirect()->back()
            ->with('status', 'Image uploaded')
            ->with('file', $image);
        }
    }
}

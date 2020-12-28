<?php

namespace App\Http\Controllers;

use Storage;
use App\Models\User;
use App\Models\UserImages;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UploadImagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(User $id) {
        // $url = 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/';
        // $images = [];
        // $files = Storage::disk('s3')->files('file');
        //     foreach ($files as $file) {
        //         $images[] = [
        //             'name' => str_replace('images/', '', $file),
        //             'src' => $url . $file
        //         ];
        //     }
       
        return view('user.upload', compact('id'));
    
    }

    public function store(Request $request) {
        
        $this->validate($request, [
            'file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        dd(asset('public'));

        $imageName = date('Y-m-d').uniqid().'.'.$request->file->extension();
        $user_id = $_GET['user_id'];
        $filePath = 'images/' . $imageName;
        $request->file->move(public_path('img'), $imageName);

        if ($request->hasFile('file')) {

            $find = UserImages::where('user_id' ,$user_id)->first();
            if ($find) {

                $find->user_id = $user_id;
                $find->filename = basename($imageName);
                $find->url =  $filePath;
                $find->save();

                return redirect()->back()
                ->with('status', 'User Image Updated');
            }

            $image = UserImages::create([
                'user_id' =>  $user_id,
                'filename' => basename($imageName),
                'url' => $filePath
            ]);
            
                return redirect()->back()
                ->with('status', 'Image uploaded')
                ->with('file', $image);
        }
    }
}

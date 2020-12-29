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

    public function store(Request $request , $id) {
        
        $this->validate($request, [
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $extension = $request->file('profile')->getClientOriginalExtension();
        $filename = strtotime('Y-m-d H:i:s').$extension;
        
        $s3_path = $request->file('profile')->store('profiles' , 's3');
        if ($s3_path) {
            $user = User::findOrFail($id);
            $user->profile_path = Storage::disk('s3')->url($s3_path);
            
            if ($user->save()) {
                return redirect()->back()->with('status', 'User Image Updated');
            }
        }
    }
}

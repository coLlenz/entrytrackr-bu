<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use QrCode;
use Illuminate\Support\Facades\Storage;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $users = User::where([
            'sub_account' => 0,
            'is_admin' =>  0
        ])->get();
        return view('user.index', compact( 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('user.add');
    }
    public function create(Request $request){
        $this->validate($request, [
            'email' => 'required|unique:users',
            'name' => 'required',
            'cname' => 'required',
            'password' => 'min:8|confirmed',
        ]);
        
        $user = new User();
        $user->name = $request->input('name');
        $user->uuid = Str::uuid()->toString();
        $user->contactName = $request->input('cname');
        $user->sub_account = 0;
        $user->profile_path = '';
        $user->sub_account_id=0;
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->is_admin = 0;
        if ( $user->save() ) {
            $user->qr_path  = $this->generateCode( $user->uuid  , $user->id);
            $user->save();
        }
        return redirect()->route("user-index")->with('success', 'User Added Successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $id)
    {
        return view('user.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $id){
        if ($request->input('password')) {
            $this->validate($request, [
                'email' => 'required|unique:users',
                'name' => 'required',
                'cname' => 'required',
                'password' => 'min:8|required_with:confirmpassword|same:confirmpassword',
                'confirmpassword' => 'min:8'
            ]);
            $id->update(
                [
                    'name' => $request->input('name'),
                    'contactName' => $request->input('cname'),
                    'email' => $request->input('email'),
                    'timezone' => $request->input('timezone'),
                    'password' => Hash::make($request->input('password')),
                ]
            );
        } else {
            
            $this->validate($request, [
                // 'email' => 'required|unique:users',
                'name' => 'required',
                'cname' => 'required',
            ]);
            $id->update(
                [
                    'name' => $request->input('name'),
                    'contactName' => $request->input('cname'),
                    'email' => $request->input('email'),
                    'timezone' => $request->input('timezone'),
                ]
            );
        }

        return redirect()->route("user-index")->with('success', 'User Updated Successfully');
    }
    
    public function delete(User $id){
        $id->delete();
        return redirect()->route("user-index")->with('success', 'User Deleted Successfully');
    }
    
    public function generateCode($uuid , $userid){
        $s3_url = '';
        $url = url('/trakr/qr/login/'.$uuid.'/'.$userid);
        $filename = $uuid.'_'.strtotime( date('Y-m-d H:i') ).'.png';
        $image = QrCode::format('png')->size(250)->generate($url);
		$path = Storage::disk('s3')->put($filename, $image);
		if ($path) {
			$s3_url = Storage::disk('s3')->url($filename);
		}
        return $s3_url;
    }
}

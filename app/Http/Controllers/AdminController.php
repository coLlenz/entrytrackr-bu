<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DB;
use QrCode;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
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
    
    public function index(Request $request){
        $total_accounts = DB::table('users')->where(['is_admin' => '!= 1'])->count();
        $total_sigin_in = DB::table('visitor_log')
        ->join('trakrs' , 'trakrs.id' , '=' , 'visitor_log.visitor_id')
        ->where(['visitor_log.action' => 0])->count();
        $total_sigin_out = DB::table('visitor_log')
        ->join('trakrs' , 'trakrs.id' , '=' , 'visitor_log.visitor_id')
        ->where(['action' => 1])->count();
        $total_denied = DB::table('trakrs')->where(['status' => 1])->count();
        $trakr_id = DB::table('trakrs')->where('trakr_id' , '!=' , ' ')->count();
        
        $data = [
            'total_accounts' => $total_accounts,
            'total_sigin_in' => $total_sigin_in,
            'total_sigin_out' => $total_sigin_out,
            'total_denied' => $total_denied,
            'trakr_id' => $trakr_id
        ];
        
        $visitors = DB::table('visitor_log')
        ->join('trakrs' , 'trakrs.id' , '=' , 'visitor_log.visitor_id')
        ->where('trakrs.trakr_type_id' , '=' , 1)
        ->count();
        
        $contractor = DB::table('visitor_log')
        ->join('trakrs' , 'trakrs.id' , '=' , 'visitor_log.visitor_id')
        ->where('trakrs.trakr_type_id' , '=' , 2)
        ->count();
        
        $employee = DB::table('visitor_log')
        ->join('trakrs' , 'trakrs.id' , '=' , 'visitor_log.visitor_id')
        ->where('trakrs.trakr_type_id' , '=' , 3)
        ->count();
        
        $visitor = [
            'visitors' =>$visitors,
            'contractors' =>$contractor,
            'employees' =>$employee,
        ];
        
        return view('admin.index')
        ->with('data' , $data)
        ->with('visitor' , $visitor);
    }
    
    public function clients(){
        $users = User::where('is_admin' , '=' , 0)->orderBy('created_at' , 'DESC')->get();
        return view('admin.clients.index')->with('users' ,$users );
    }
    
    public function newClient(){
        return view('admin.clients.add');
    }
    
    public function newClientSave(Request $request){
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
        return redirect()->route("admin-clients")->with('success', 'User Added Successfully');
    }
    
    public function editClient($client_id){
        $client_data = User::findOrFail($client_id);
        if ($client_data) {
            return view('admin.clients.edit')->with('id' , $client_data);
        }
    }
    
    public function updateClient(Request $request, User $id){
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

        return redirect()->route("admin-clients")->with('success', 'User Updated Successfully');
    }
}

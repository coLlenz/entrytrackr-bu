<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;
use Str;
use PDF;
use QrCode;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Session;
class SettingsController extends Controller{
    
    public function index(){
        $settings = DB::table('question_view_settings')->select('auto_sign_out' , 'feedback_settings' , 'confirmation_msg')->where('user_id' , user_id())->first();
        $json = $settings ? json_decode($settings->auto_sign_out) : [];
        $feedback = $settings ? json_decode($settings->feedback_settings) : [];
        $confirmation = $settings ? json_decode($settings->confirmation_msg) : [];
        return view('profile.show')
        ->with('settings' , $json)
        ->with('feedback' , $feedback)
        ->with('confirmation' ,  $confirmation);
    }
    
    public function customerAdmins(){
        $userlist = User::where(
            [
                'sub_account_id' => auth()->user()->id,
                'sub_account' => 1,
            ]
        )
        ->orderBy('created_at' , 'DESC')
        ->get();
        return view('settings.index')->with('lists' , $userlist);
    }
    
    public function new_admin(Request $request){
        $validator = Validator::make($request->all(), [
            'admin_name' => 'required',
            'admin_email' => 'required|email:rfc,dns|unique:users,email',
            'admin_password' => 'required|min:5',
            'admin_password_confirmation' => 'required|same:admin_password|min:5',
        ]);
        if ($validator->passes()) {
            $new_admin = new User;
            $new_admin->uuid = auth()->user()->uuid;
            $new_admin->sub_account = 1;
            $new_admin->sub_account_id = auth()->user()->id;
            $new_admin->name =  auth()->user()->name;
            $new_admin->contactName = $request->admin_name;
            $new_admin->email = $request->admin_email;
            $new_admin->password = Hash::make($request->admin_password);
            $new_admin->is_admin = 0;
            $new_admin->qr_path = auth()->user()->qr_path;
            $new_admin->timezone = auth()->user()->timezone;
            
            if ($new_admin->save()) {
                return response()->json(['msg' => 'New admin added']);
            }
        }
        
        return response()->json(['error'=>$validator->errors()->all()]);
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
    
    public function generatePDF(){
        // return view('pdf.qrpdf');
        // PDF::setOptions(['isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
        // ->setPaper('a4', 'landscape');
        $pdf = PDF::loadView('pdf.qrpdf');
        return $pdf->download('QR_LOGIN.pdf');
    }
    
    public function viewSettings(){
        $settings = DB::table('question_view_settings')->where('user_id' , user_id() )->first();
        return view('settings.change_settings')->with('settings' , $settings );
    }
    
    public function saveSettings( Request $request ){
        $settings = DB::table('question_view_settings')->where('user_id' , user_id())->first();
        
        if (!$settings) {
            $new_settings = DB::table('question_view_settings')->insert([
                'user_id' => user_id(),
                'settings' => $request->settings
            ]);
            
            return $new_settings;
        }
        
        $new_settings = DB::table('question_view_settings')->where('user_id' , user_id() )
        ->update(['settings' => $request->settings]);
        
        return $new_settings;
        
    }
    
    public function signOutSettings( Request $request ){
        $settings_data = [];
        $settings = [];
        $result = false;
        
        $settings_data = [
            'employee' => isset( $request->employee ) ? $request->set_employee : 0,
            'visitor' => isset( $request->visitor ) ? $request->set_visitor : 0,
            'contractor' => isset( $request->contractor ) ? $request->set_contractor : 0
        ];
        
        $encode = json_encode( $settings_data );
        
        $settings = DB::table('question_view_settings')->where('user_id' , user_id())->first();
        
        if (!$settings) {
            
            $result = DB::table('question_view_settings')->insert([
                'user_id' => user_id(),
                'auto_sign_out' => $encode
            ]);
            
        }else{
            
            $result = DB::table('question_view_settings')->where('user_id' , user_id() )
            ->update(['auto_sign_out' => $encode ]);
            
        }
        
        if ($result) {
            Session::flash('message', 'Save'); 
        }else{
            Session::flash('message', 'Error saving Settings'); 
        }
        
        return back();
    }

    public function feedbackSettings( Request $request ){
        
        $settings = DB::table('question_view_settings')->where('user_id' , user_id())->first();
       
        $result = false;

        $settings_data = [
            'employee' => isset( $request->employee ) ? $request->employee : 0,
            'visitor' => isset( $request->visitor ) ? $request->visitor : 0,
            'contractor' => isset( $request->contractor ) ? $request->contractor : 0
        ];
       
        $encode = json_encode( $settings_data );
        if (!$settings) {

            $result = DB::table('question_view_settings')->insert([
                'user_id' => user_id(),
                'feedback_settings' => $encode
            ]);

        }else{

            $result = DB::table('question_view_settings')->where('user_id' , user_id() )
            ->update(['feedback_settings' => $encode ]); 

        }

        return $result;
    }

    public function confirmationSettings(Request $request){
        $settings = DB::table('question_view_settings')->where('user_id' , user_id())->first();

        $result = false;

        $settings_data = [
            'signin' => isset( $request->set_signin ) ? $request->set_signin : 0,
            'signout' => isset( $request->set_signout ) ? $request->set_signout : 0,
            'accessdenied' => isset( $request->set_accessdenied ) ? $request->set_accessdenied : 0
        ];

        $encode = json_encode( $settings_data );
        if (!$settings) {

            $result = DB::table('question_view_settings')->insert([
                'user_id' => user_id(),
                'confirmation_msg' => $encode
            ]);

        }else{

            $result = DB::table('question_view_settings')->where('user_id' , user_id() )
            ->update(['confirmation_msg' => $encode ]); 

        }

        return $result;
    }
    
    public function accountDetails(Request $request){
        $account = User::select('contactName' , 'email')->where(['id' => $request->account_id])->first();
        
        if ($account) {
            return [
                'username' =>  $account->contactName,
                'email' => $account->email
            ];
        }
        
        return false;
    }
    
    public function accountDetailsSave( Request $request ){
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,' . $request->account,
            'account' => 'required',
        ]);
        
        if ($validator->passes()) {
            $account = User::findOrFail($request->account);
            if ($account) {
                
                $account->contactName = $request->username;
                $account->email = $request->email;
                
                if ($account->save()) {
                    return response()->json(['status'=> 'success']);
                }
                
            }else{
                return response()->json(['error'=> 'nodata']);
            }
        }
        
        return response()->json(['form_error'=>$validator->errors()->all()]);
    }
}

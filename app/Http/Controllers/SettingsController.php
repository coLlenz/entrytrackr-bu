<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Hash;
use Str;
class SettingsController extends Controller
{
    public function new_admin(Request $request){
        $validator = Validator::make($request->all(), [
            'admin_name' => 'required',
            'admin_contact_name' => 'required',
            'admin_email' => 'required|email:rfc,dns|unique:users,email',
            'admin_password' => 'required|min:5',
            'admin_password_confirmation' => 'required|same:admin_password|min:5',
        ]);
        if ($validator->passes()) {
            $new_admin = new User;
            $new_admin->uuid = Str::uuid();
            $new_admin->sub_account = 1;
            $new_admin->sub_account_id = auth()->user()->id;
            $new_admin->name = $request->admin_name;
            $new_admin->contactName = $request->admin_contact_name;
            $new_admin->email = $request->admin_email;
            $new_admin->password = Hash::make($request->admin_password);
            $new_admin->is_admin = 0;
            
            if ($new_admin->save()) {
                return response()->json(['msg' => 'New admin added']);
            }
        }
        
        return response()->json(['error'=>$validator->errors()->all()]);
    }
}

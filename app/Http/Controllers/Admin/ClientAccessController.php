<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class ClientAccessController extends Controller
{
    //
    public function index(){
        $has_access = User::where('access_flg' , 1)->get();
        $accounts = User::select('id' , 'name')
        ->where('is_admin' , '!=' , 1)
        ->where('sub_account' , 0)
        ->where('access_flg' , 0)->get();
        return view('admin.special_access.index')
        ->with('has_access' , $has_access)
        ->with('accounts' , $accounts);
    }
    
    public function save(Request $request){
        $from_account = User::findOrFail($request->from_account);
        $to_account = User::findOrFail($request->to_account);
        
        $from_account->sub_account = 1;
        $from_account->sub_account_id = $to_account->id;
        $from_account->qr_path = $to_account->qr_path;
        $from_account->timezone = $to_account->timezone;
        
        $from_account->save();
        return response()->json(['status' => 'success']);
    }
}

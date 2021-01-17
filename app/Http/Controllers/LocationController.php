<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Trakr;
use Helper;
class LocationController extends Controller{    
    
    public function index(){
        $lists = DB::table('users')
        ->where([
            'sub_account' => 1,
            'sub_account_id' => auth()->user()->id
        ])->get();
        return view('location.index')->with('lists' , $lists);
    }
    
    public function visit($uuid , $id){
        $account = User::where(['uuid' =>$uuid , 'id' => $id ])->first();
        if ($account) {
            
            $account['visitors'] =  Trakr::where(['user_id' => $id , 'checked_in_status' => 0])->get();
            
            return view('location.visit')
            ->with('account',$account);
        }
        
        return redirect()->route("index")->with('msg', 'Something went wrong. Please try again');
        
    }
}
   
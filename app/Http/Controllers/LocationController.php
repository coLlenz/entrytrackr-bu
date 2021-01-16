<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LocationController extends Controller{    
    
    public function index(){
        $lists = DB::table('users')
        ->where([
            'sub_account' => 1,
            'sub_account_id' => auth()->user()->id
        ])->get();
        
        return view('location.index')->with('lists' , $lists);
    }
    
    public function visit(){
        
    }
}
   
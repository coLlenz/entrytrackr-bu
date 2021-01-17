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
            $visitor_count= [];
            // visitor list
            $account['visitors'] =  Trakr::where(['user_id' => $id , 'checked_in_status' => 0,])
            ->where('check_in_date' ,'>=' , date('Y-m-d 00:00:00'))
            ->where('check_in_date' , '<=', date('Y-m-d 23:59:59'))
            ->select('trakrs.id' , 'trakrs.firstName' ,'trakrs.lastName' , 'trakrs.trakr_id' , 'trakrs.phoneNumber' , 'trakr_types.name as visitor_type' , 'trakrs.email' , 'trakrs.who' ,'trakrs.safe' ,'trakrs.date_marked_safe', 'trakrs.name_of_company', 'trakrs.status' , 'trakrs.check_in_date')
            ->join('trakr_types' ,'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->paginate(10);
            
            // Visitor Count
            $visitor_count['visitors']      =  Trakr::where(['trakr_type_id' => 1 , 'checked_in_status' => 0 , 'user_id' => $id])->count();
            $visitor_count['contractors']   =  Trakr::where(['trakr_type_id' => 2 , 'checked_in_status' => 0 , 'user_id' => $id])->count();
            $visitor_count['employees']     =  Trakr::where(['trakr_type_id' => 3 , 'checked_in_status' => 0 , 'user_id' => $id])->count();
            
            return view('location.visit')
            ->with('account',$account)
            ->with('visitor_count' , $visitor_count);
        }
        
        return redirect()->route("index")->with('msg', 'Something went wrong. Please try again');
        
    }
}
   
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class AdminController extends Controller
{
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
}

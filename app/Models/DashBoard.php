<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class DashBoard extends Model
{
    use HasFactory;
    
    public function getdash_data(){
        //super admin user
        if ( auth()->user()->is_admin ) {
            $dash = DB::table('trakrs')
            ->select('trakrs.id', 'trakr_id','firstName' , 'lastName' , 'trakrs.created_at','trakrs.id','trakr_types.name as type' , 'checked_in_status')
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->where('checked_in_status' , 0)
            ->orderBy('trakrs.check_in_date','desc')
            ->paginate(5);
            return $dash;
        }
        
        //is sub accounts
        if ( auth()->user()->sub_account ) {
            $dash = DB::table('trakrs')
            ->select('trakrs.id', 'trakr_id','firstName' , 'lastName' , 'trakrs.created_at','trakrs.id','trakr_types.name as type' , 'checked_in_status')
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->where('user_id' , auth()->user()->sub_account_id)
            ->where('checked_in_status' , 0)
            ->orderBy('trakrs.check_in_date','desc')
            ->paginate(5);
            return $dash;
        }
        
        //for customers
        $dash = DB::table('trakrs')
        ->select('trakrs.id', 'trakr_id','firstName' , 'lastName' , 'trakrs.created_at','trakrs.id','trakr_types.name as type' , 'checked_in_status')
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
        ->where('user_id' , auth()->user()->id)
        ->where('checked_in_status' , 0)
        ->orderBy('trakrs.check_in_date','desc')
        ->paginate(5);
        return $dash;
        
    }
    
    public function getdash_assistance(){
        $assist = DB::table('trakrs')
            ->select('firstName' , 'lastName' , 'trakrs.created_at','trakrs.id','name as type' , 'safe' , 'date_marked_safe')
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->where([
                ['user_id' , '=' , auth()->user()->id],
                ['assistance' , '=' , 1]
            ])
            ->where('checked_in_status' , 0)
            ->orderBy('trakrs.check_in_date','desc')
            ->paginate(5);
        return $assist;
    }
    
    public function getdash_evac(){
        // for super admin
        if ( auth()->user()->is_admin ) {
            $assist = DB::table('trakrs')
            ->select('firstName' , 'lastName' , 'trakrs.created_at','trakrs.id','name as type' , 'assistance' , 'safe' , 'date_marked_safe')
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->where([
                ['user_id' , '=' , auth()->user()->id],
            ])
            ->where('checked_in_status' , 0)
            ->orderBy('trakrs.check_in_date','desc')
            ->get();
            return $assist;
        }
        
        // sub accounts
        if ( auth()->user()->sub_account ) {
            $assist = DB::table('trakrs')
            ->select('firstName' , 'lastName' , 'trakrs.created_at','trakrs.id','name as type' , 'assistance' , 'safe' , 'date_marked_safe')
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->where([
                ['user_id' , '=' , auth()->user()->sub_account_id],
            ])
            ->where('checked_in_status' , 0)
            ->orderBy('trakrs.check_in_date','desc')
            ->get();
            return $assist;
        }
        
        $assist = DB::table('trakrs')
        ->select('firstName' , 'lastName' , 'trakrs.created_at','trakrs.id','name as type' , 'assistance' , 'safe' , 'date_marked_safe')
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
        ->where([
            ['user_id' , '=' , auth()->user()->id],
        ])
        ->where('checked_in_status' , 0)
        ->orderBy('trakrs.check_in_date','desc')
        ->get();
        return $assist;
    }
    
    public function getdast_pie(){
        $counts = DB::table('trakrs')
                 ->select('trakr_type_id', DB::raw('count(*) as total'))
                 ->where([
                     'checked_in_status' =>0,
                     'user_id' => auth()->user()->id
                 ])
                 ->groupBy('trakr_type_id')
                 ->get();
        return $counts;
    }
    
    public function total_sign_in(){
        // for super admins
        if ( auth()->user()->is_admin ) {
            $total_signin = DB::table('trakrs')
            ->where([
                'checked_in_status' =>0,
            ])
            ->orderBy('trakrs.check_in_date','desc')
            ->get();
            $total_count = $total_signin->count();
            return $total_count;
        }
        
        // for sub accounts
        if ( auth()->user()->sub_account ) {
            $total_signin = DB::table('trakrs')
            ->where([
                'checked_in_status' =>0,
                'user_id' => auth()->user()->sub_account_id
            ])
            ->orderBy('trakrs.check_in_date','desc')
            ->get();
            $total_count = $total_signin->count();
            return $total_count;
        }
        
        // customers
        $total_signin = DB::table('trakrs')
        ->where([
            'checked_in_status' =>0,
            'user_id' => auth()->user()->id
        ])
        ->orderBy('trakrs.check_in_date','desc')
        ->get();
        $total_count = $total_signin->count();
        return $total_count;
    }
}

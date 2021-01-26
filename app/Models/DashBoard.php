<?php

namespace App\Models;

use DB;
use App\Models\Trakr;
use App\Models\TrakrType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DashBoard extends Model
{
    use HasFactory;
    
    public function getdash_data(){
        //super admin user
        if ( auth()->user()->is_admin ) {
            $dash = DB::table('trakrs')
            ->select('trakrs.id', 'trakr_id','firstName' , 'lastName' , 'trakrs.check_in_date' ,'trakrs.created_at','trakrs.id','trakr_types.name as type' , 'checked_in_status')
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->where('checked_in_status' , 0)
            ->orderBy('trakrs.check_in_date','desc')
            ->paginate(5);
            return $dash;
        }
        
        //for customers and sub account 
        $dash = DB::table('trakrs')
        ->select('trakrs.id', 'trakr_id','firstName' , 'lastName' , 'trakrs.check_in_date' ,'trakrs.created_at','trakrs.id','trakr_types.name as type' , 'checked_in_status')
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
        ->where('user_id' , auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id)
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
                ['user_id' , '=' , auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id],
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
            ->select('firstName' , 'lastName' , 'trakrs.check_in_date','trakrs.id','name as type' , 'assistance' , 'safe' , 'date_marked_safe' , 'marked_by')
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->where([
                ['user_id' , '=' , auth()->user()->id],
            ])
            ->where('checked_in_status' , 0)
            ->orderBy('trakrs.check_in_date','desc')
            ->get();
            return $assist;
        }
        
        //for customers and sub account 
        $assist = DB::table('trakrs')
        ->select('firstName' , 'lastName' , 'trakrs.check_in_date','trakrs.id','name as type' , 'assistance' , 'safe' , 'date_marked_safe' , 'marked_by')
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
        ->where([
            ['user_id' , '=' , auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id],
        ])
        ->where('checked_in_status' , 0)
        ->orderBy('trakrs.check_in_date','desc')
        ->get();
        return $assist;
    }
    
    public function getdast_pie(){
        $counts = [];
        
        $counts['visitors'] = Trakr::where(['trakr_type_id' => 1 , 'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id , 'checked_in_status' => 0])->count();
        $counts['contractors'] = Trakr::where(['trakr_type_id' => 2 , 'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id , 'checked_in_status' => 0])->count();
        $counts['employees'] = Trakr::where(['trakr_type_id' => 3 , 'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id , 'checked_in_status' => 0])->count();
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
        
        // customers
        $total_signin = DB::table('trakrs')
        ->where([
            'checked_in_status' => 0,
            'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id
        ])
        ->orderBy('trakrs.check_in_date','desc')
        ->get();
        $total_count = $total_signin->count();
        return $total_count;
    }
}

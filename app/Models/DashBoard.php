<?php

namespace App\Models;

use DB;
use App\Models\Trakr;
use App\Models\TrakrType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
class DashBoard extends Model
{
    use HasFactory;
    
    public function getdash_data(){
        $current = Carbon::now()->timezone( userTz() )->format('Y-m-d 00:00:00');
        $span = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
        
        //for customers and sub account 
        $dash = DB::table('trakrs')
        ->select('trakrs.id', 'trakr_id','firstName' , 'lastName' , 'trakrs.check_in_date' ,'trakrs.created_at','trakrs.id','trakr_types.name as type' , 'checked_in_status')
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
        ->where('user_id' , user_id())
        ->where('trakrs.check_in_date' , '>=' , $current  )
        ->where('trakrs.check_in_date' , '<=' , $span )
        ->where('checked_in_status' , 0)
        ->orderBy('trakrs.check_in_date','desc')
        ->paginate(5);
        return $dash;
        
    }
    
    public function getdash_assistance(){
        $current = Carbon::now()->timezone( userTz() )->format('Y-m-d 00:00:00');
        $span = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
        $assist = DB::table('trakrs')
            ->select('firstName' , 'lastName' , 'trakrs.created_at','trakrs.check_in_date','trakrs.id','name as type' , 'safe' , 'date_marked_safe')
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->where([
                ['user_id' , '=' , user_id()],
                ['assistance' , '=' , 1]
            ])
            ->where('trakrs.check_in_date' , '>=' , $current  )
            ->where('trakrs.check_in_date' , '<=' , $span )
            ->where('checked_in_status' , 0)
            ->orderBy('trakrs.check_in_date','desc')
            ->paginate(5);
        return $assist;
    }
    
    public function getdash_evac(){
        $current = Carbon::now()->timezone( userTz() )->format('Y-m-d 00:00:00');
        $span = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
        
        $assist = DB::table('trakrs')
        ->select('firstName' , 'lastName' , 'trakrs.check_in_date','trakrs.id','name as type' , 'assistance' , 'safe' , 'date_marked_safe' , 'marked_by')
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
        ->where('user_id' , '=' , user_id())
        ->where('trakrs.check_in_date' , '>=' , $current  )
        ->where('trakrs.check_in_date' , '<=' , $span )
        ->where('checked_in_status' , 0)
        ->orderBy('trakrs.check_in_date','desc')
        ->get();
        return $assist;
    }
    
    public function getdast_pie(){
        $current = Carbon::now()->timezone( userTz() )->format('Y-m-d 00:00:00');
        $span = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
        $counts = [];
        
        $counts['visitors'] = Trakr::where(['trakr_type_id' => 1 , 'user_id' => user_id() , 'checked_in_status' => 0])
        ->where('trakrs.check_in_date' , '>=' , $current  )
        ->where('trakrs.check_in_date' , '<=' , $span )
        ->count();
        
        $counts['contractors'] = Trakr::where(['trakr_type_id' => 2 , 'user_id' => user_id() , 'checked_in_status' => 0])
        ->where('trakrs.check_in_date' , '>=' , $current  )
        ->where('trakrs.check_in_date' , '<=' , $span )
        ->count();
        
        $counts['employees'] = Trakr::where(['trakr_type_id' => 3 , 'user_id' => user_id() , 'checked_in_status' => 0])
        ->where('trakrs.check_in_date' , '>=' , $current  )
        ->where('trakrs.check_in_date' , '<=' , $span )
        ->count();
        
        return $counts;
    }
    
    public function total_sign_in(){
        $current = Carbon::now()->timezone( userTz() )->format('Y-m-d 00:00:00');
        $span = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
        
        // customers
        $total_signin = DB::table('trakrs')
        ->where([
            'checked_in_status' => 0,
            'user_id' => user_id()
        ])
        ->where('trakrs.check_in_date' , '>=' , $current  )
        ->where('trakrs.check_in_date' , '<=' , $span )
        ->orderBy('trakrs.check_in_date','desc')
        ->get();
        $total_count = $total_signin->count();
        return $total_count;
    }
}

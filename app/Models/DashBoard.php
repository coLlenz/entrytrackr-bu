<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class DashBoard extends Model
{
    use HasFactory;
    
    public function getdash_data(){
        $dash = DB::table('trakrs')
        ->select('trakrs.id as trakr_id','firstName' , 'lastName' , 'trakrs.created_at','trakrs.id','trakr_types.name as type')
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
        $assist = DB::table('trakrs')
            ->select('firstName' , 'lastName' , 'trakrs.created_at','trakrs.id','name as type' , 'safe' , 'date_marked_safe')
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
                 ->groupBy('trakr_type_id')
                 ->get();
        return $counts;
    }
    
    public function total_sign_in(){
        $total_signin = DB::table('trakrs')->where('checked_in_status' , 0)->orderBy('trakrs.check_in_date','desc')->get();
        $total_count = $total_signin->count();
        return $total_count;
    }
}

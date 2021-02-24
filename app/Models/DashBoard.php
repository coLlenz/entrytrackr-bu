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
        $dash = DB::table('trakrs')
        ->select('trakrs.id', 'trakr_id','firstName' , 'lastName' , 'trakrs.check_in_date' ,'trakrs.created_at','trakrs.id','trakr_types.name as type' , 'checked_in_status')
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
        ->where('user_id' , user_id())
<<<<<<< HEAD
<<<<<<< HEAD
        ->where('trakrs.check_in_date' , '>=' , $current  )
        ->where('trakrs.check_in_date' , '<=' , $span )
=======
>>>>>>> b437667c2ff9554125822af43aad32aff0e3a699
=======
>>>>>>> 3f084edb9964ffa49c2e117c6222277358cbd5f1
        ->where('checked_in_status' , 0)
        ->where('trakrs.status' , 0)
        ->orderBy('trakrs.check_in_date','desc')
        ->paginate(5);
        return $dash;
        
    }
    
    public function getdash_assistance(){
        $assist = DB::table('trakrs')
            ->select('firstName' , 'lastName' , 'trakrs.created_at','trakrs.check_in_date','trakrs.id','name as type' , 'safe' , 'date_marked_safe')
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
            ->where([
                ['user_id' , '=' , user_id()],
                ['assistance' , '=' , 1]
            ])
            ->where('checked_in_status' , 0)
            ->where('trakrs.status' , 0)
            ->orderBy('trakrs.check_in_date','desc')
            ->paginate(5);
        return $assist;
    }
    
    public function getdash_evac(){
        
        $assist = DB::table('trakrs')
        ->select('firstName' , 'lastName' , 'trakrs.check_in_date','trakrs.id','name as type' , 'assistance' , 'safe' , 'date_marked_safe' , 'marked_by')
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id')
        ->where('user_id' , '=' , user_id())
        ->where('checked_in_status' , 0)
        ->where('trakrs.status' , 0)
        ->orderBy('trakrs.check_in_date','desc')
        ->get();
        return $assist;
    }
    
    public function getdast_pie(){
        $counts = [];
        
        $counts['visitors'] = Trakr::where(['trakr_type_id' => 1 , 'user_id' => user_id() , 'checked_in_status' => 0])
        ->where('trakrs.status' ,  0 )
        ->count();
        
        $counts['contractors'] = Trakr::where(['trakr_type_id' => 2 , 'user_id' => user_id() , 'checked_in_status' => 0])
        ->where('trakrs.status' ,  0 )
        ->count();
        
        $counts['employees'] = Trakr::where(['trakr_type_id' => 3 , 'user_id' => user_id() , 'checked_in_status' => 0])
        ->where('trakrs.status' ,  0 )
        ->count();
        
        return $counts;
    }
    
    public function total_sign_in(){
        $total_signin = DB::table('trakrs')
        ->where([
            'checked_in_status' => 0,
<<<<<<< HEAD
<<<<<<< HEAD
            'user_id' => user_id()
=======
            'user_id' => user_id(),
            'status' => 0
>>>>>>> b437667c2ff9554125822af43aad32aff0e3a699
=======
            'user_id' => user_id(),
            'status' => 0
>>>>>>> 3f084edb9964ffa49c2e117c6222277358cbd5f1
        ])
        ->orderBy('trakrs.check_in_date','desc')
        ->get();
        $total_count = $total_signin->count();
        return $total_count;
    }
}

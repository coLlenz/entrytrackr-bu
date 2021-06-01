<?php

namespace App\Http\Controllers\Checker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trakr;
use Carbon\Carbon;
use DB;
class CheckerController extends Controller
{
    public static function checkIfLoggedIn($conditions){
        /* 
        params format
        [
            first_name
            last_name
            phoneNumber
            trakr_id
            user_id
            
        ]
        */
        $firstname = isset($conditions['first_name']) ? $conditions['first_name'] : "";
        $lastname = isset($conditions['last_name']) ? $conditions['last_name'] : "";
        $phoneNumber = isset($conditions['phoneNumber']) ? $conditions['phoneNumber'] : "";
        $trakr_id = isset($conditions['trakr_id']) ? $conditions['trakr_id'] : "";
        $user_id = isset($conditions['user_id']) ? (int)$conditions['user_id'] : "";
        $returndata = [];
        
        // DB::enableQueryLog();
        
        $checker_query = Trakr::select('checked_in_status' , 'check_in_date','check_out_date' , 'id as visitor_id' , 'firstName')
        ->where('user_id' ,$user_id)
        ->when($firstname, function ($query , $firstname) {
            return $query->where('firstName' , $firstname);
        })
        ->when($lastname , function ($query , $lastname){
            return $query->where('lastName' , $lastname);
        })
        ->when($phoneNumber , function ($query , $phoneNumber){
            return $query->where('phoneNumber' , $phoneNumber);
        })
        ->when($trakr_id , function ($query , $trakr_id){
            return $query->whereRaw("BINARY trakr_id = '$trakr_id' ");
        })->first();
        
        if ($checker_query) {
            $returndata['visitor_id'] = $checker_query->visitor_id;
            $returndata['is_loggedin'] = $checker_query->checked_in_status;
            $returndata['check_date'] = $checker_query->check_in_date;
            $returndata['check_out_date'] = $checker_query->check_out_date;
            $returndata['firstName'] = $checker_query->firstName;
            $returndata['has_record'] = true;
            
            return $returndata;
        }
        
        return false;
        
    }

    public static function isAbleToFeedBack($user_id , $visitor_type){
        $settings = DB::table('question_view_settings')->select('feedback_settings')->where('user_id' , $user_id )->first();
        $settings_json = $settings ? json_decode( $settings->feedback_settings ) : [];
        
        return self::visitor_check($visitor_type , $settings_json);
    }

    public static function visitor_check($visitor_type , $settings){
        switch ($visitor_type) {
            case '1':
                return $settings->visitor;
                break;
            case '2':
                return $settings->contractor;
                break;
            case '3':
                return $settings->employee;
                break;    
            default:
            return false;
                break;
        }
    }

    public static function allowTempRecord( $user_id ){
        $default_temp_check = true;
        $settings = DB::table('question_view_settings')
        ->select('temperature_check')
        ->where('user_id' , $user_id)
        ->first();

        if (!isset($settings->temperature_check) ) {
            return true;
        }

        return isset($settings->temperature_check) && $settings->temperature_check == 1 ? true : false;
    }

    public static function playAudio($user_id){
        $settings = DB::table('question_view_settings')
        ->select('sound_setting')
        ->where('user_id' , $user_id)
        ->first();      

        return isset($settings->sound_setting) && $settings->sound_setting == 1 ? true : false;
    }
}

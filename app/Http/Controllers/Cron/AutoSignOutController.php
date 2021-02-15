<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trakr;
use DB;
use Carbon\Carbon;
class AutoSignOutController extends Controller
{
    public function autoSignOut(){
        
        $signin = Trakr::where(['checked_in_status' => 0 , 'user_id' => 14 ])->get();
        echo "<pre>";
            print_r( $signin );
        echo "</pre>";
        
        // if (!$signin->isEmpty()) {
        // 
        //     foreach ($signin as $key => $value) {
        // 
        //         $customer = DB::table('users')->select('timezone')->where(['id' => $value->user_id])->first();
        //         $expected_sign_out_hour = DB::table('question_view_settings')->select('auto_sign_out')->where('user_id' , $value->user_id)->first();
        //         $expected_sign_out_hour = $expected_sign_out_hour ? json_decode( $expected_sign_out_hour->auto_sign_out ) : [];
        // 
        //         $_hours = $expected_sign_out_hour ? self::visitortype(  $value->trakr_type_id , $expected_sign_out_hour ) : 0;
        // 
        //         // default UTC
        //         // convert check in date to customers timezone
        //         $visitor_check_in_date_on_timezone = Carbon::parse( $value->check_in_date )->timezone( $customer->timezone );
        // 
        //         if ( $_hours != 0 && !empty( $_hours ) && isset( $_hours ) ) {
        // 
        //             $expected_sign_out = Carbon::parse( $visitor_check_in_date_on_timezone )->addHours( $_hours );
        // 
        //             if ( $visitor_check_in_date_on_timezone->greaterThanOrEqualTo( $expected_sign_out ) ) {
        // 
        //                 // use UTC timezone
        //                 $check_out_date_utc = Carbon::parse( $value->check_in_date )->addHours( $_hours );
        //                 //
        // 
        //                 $value->check_out_date = $check_out_date_utc;
        //                 $value->updated_at = Carbon::now();
        //                 $value->checked_in_status = 1;
        //                 $status = $value->save();
        // 
        //                 // save logs
        //                 $logs = DB::table('scheduled_jobs')->insert([
        //                     'job' => 'signout:all',
        //                     'status' => $status,
        //                     'user_id' => $value->user_id,
        //                     'visitor_id' => $value->id,
        //                     'created_at' => Carbon::now()
        //                 ]);
        // 
        //                 $visitLogs = DB::table('visitor_log')->insert([
        //                     'visitor_id' => $value->id,
        //                     'user_id' => $value->user_id,
        //                     'action' => 1,
        //                     'created_at' => Carbon::now()
        //                 ]);
        //                 echo 'logged out all';
        //             }
        //         }
        // 
        //     }// end foreach
        // 
        // }
    }
    
    public function visitortype( $visitor , $data_hours ){
        switch ($visitor) {
            case '1':
                return $data_hours->visitor;
                break;
            case '2':
                return $data_hours->contractor;
                break;
            case '3':
                return $data_hours->employee;
                break;
            
            default:
                return 0;
                break;
        }
    }
}

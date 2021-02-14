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
        
        $signin = Trakr::where('checked_in_status' , 0)->get();
        
        if (!$signin->isEmpty()) {
            
            foreach ($signin as $key => $value) {
                
                $customer = DB::table('users')->select('timezone')->where(['id' => $value->user_id])->first();
                $expected_sign_out_hour = DB::table('question_view_settings')->select('auto_sign_out')->where('user_id' , $value->user_id)->first();
                $expected_sign_out_hour = json_decode( $expected_sign_out_hour->auto_sign_out );
                
                $_hours = self::visitortype(  $value->trakr_type_id , $expected_sign_out_hour);
                
                if ( $_hours != 0 ) {
                    $expected_sign_out = Carbon::parse( $value->check_in_date)->timezone( $customer->timezone )->addHours( $_hours );
                    
                    if ( Carbon::now()->timezone( $customer->timezone )->greaterThanOrEqualTo( $expected_sign_out ) ) {
                        $value->check_out_date = Carbon::parse( $expected_sign_out )->format('Y-m-d H:i:s');
                        $value->updated_at = Carbon::now();
                        $value->checked_in_status = 1;
                        $status = $value->save();
                        
                        // save logs
                        $logs = DB::table('scheduled_jobs')->insert([
                            'job' => 'signout:all',
                            'status' => $status,
                            'user_id' => $value->user_id,
                            'visitor_id' => $value->id,
                            'created_at' => Carbon::now()
                        ]);
                        
                        $visitLogs = DB::table('visitor_log')->insert([
                            'visitor_id' => $value->id,
                            'user_id' => $value->user_id,
                            'action' => 1,
                            'created_at' => Carbon::now()
                        ]);
                        
                    }
                }
                
            }// end foreach
            
        }
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

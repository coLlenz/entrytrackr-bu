<?php

namespace App\Console\Commands;

use App\Models\Trakr;
use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;
class SignOutAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signout:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Trakr $trakr)
    {
        $signin = Trakr::where('checked_in_status' , 0)->get();
        
        if (!$signin->isEmpty()) {
            
            foreach ($signin as $key => $value) {
                $customer = DB::table('users')->select('timezone')->where(['id' => $value->user_id])->first();
                $expected_sign_out = Carbon::parse($value->check_in_date)->timezone( $customer->timezone )->addHours(9);
                
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
                
            }// end foreach
            
        }
        
    }
}

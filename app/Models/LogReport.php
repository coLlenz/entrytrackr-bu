<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'visitor_id',
        'trakr_type_id',
        'who',
        'name_of_company',
        'status',
        'date_marked_safe',
        'marked_by',
        'checked_in_status',
        'check_in_date',
        'check_out_date'
    ];

    protected $table = 'report_logs';

    public function saveReport( $params ){

        $report = LogReport::create( $params );

        return $report->id;
    }

    public function reportVisitingWho( $params ){
        $report = LogReport::where(['user_id' => $params['user_id'] , 'visitor_id' => $params['visitor_id']  , 'id' => $params['report_log_id'] ])
        ->update([
            'who' => $params['who']
        ]);

        return $report;
    }

    public function reportBusiness( $params ){
        $report = LogReport::where(['user_id' => $params['user_id'] , 'visitor_id' => $params['visitor_id']  , 'id' => $params['report_log_id'] ])
        ->update([
            'name_of_company' => $params['who']
        ]);

        return $report;
    }

    public function reportCheckout( $params ){
        $report = LogReport::where(['user_id' => $params['user_id'] , 'visitor_id' => $params['visitor_id'] ])->latest()->first();
        $report->checked_in_status = 1;
        $report->check_out_date = $params['check_out_date'] ? $params['check_out_date'] : date('Y-m-d H:i:s');
        $result = $report->save();
        return $result;
    }
}

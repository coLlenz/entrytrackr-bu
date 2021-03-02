<?php

namespace App\Exports;
use App\Models\LogReport;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class ReportExport implements FromView
{
    private $report_list;

    function __construct($report_list){
        $this->report_list = $report_list;
    }

    public function view(): View{
        return view('exports.report_export', [ 'report_list' => $this->report_list ]);
    }
}

<?php
namespace App\Http\Controllers;
use App\Models\DashBoard;
use App\Models\Trakr;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
class DashboardController extends Controller
{
    public function index(){
        $list_data = [];
        $date_time = date('H:i A');
        $dash = new DashBoard();
        $list_data['current_signin'] = $dash->getdash_data();
        $list_data['need_assistance'] = $dash->getdash_assistance();
        $list_data['evac_list'] = $dash->getdash_evac();
        $list_data['total_sign_in'] = $dash->total_sign_in();
        $piedata = $dash->getdast_pie();
        $date = date('d F Y');
        $time = Carbon::now()->format('g:i A');
        return view('home')
        ->with('list_data' , $list_data)
        ->with('date' , $date)
        ->with('time', $time)
        ->with('piedata', $piedata);
    }
    
    public function generate_pdf(){
        $filename = strtotime(date('Y-m-d H:i:s'));
        $dash = new DashBoard();
        $trakrs = $dash->getdash_evac();
        view()->share('trakrs',$trakrs);
        $pdf = PDF::loadView('pdf.pdf')->setPaper('a4', 'landscape');
        return $pdf->download($filename.'.pdf');
    }
}

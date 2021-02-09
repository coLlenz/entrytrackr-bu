<?php
namespace App\Http\Controllers;
use App\Models\DashBoard;
use App\Models\Trakr;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use DB;
class DashboardController extends Controller
{
    public function index(Request $request ){
        if (auth()->user()->is_admin) {
            return redirect()->route('admin-index');
        }
        
        $list_data = [];
        $dash = new DashBoard();
        $list_data['current_signin'] = $dash->getdash_data();
        $list_data['need_assistance'] = $dash->getdash_assistance();
        $list_data['evac_list'] = $dash->getdash_evac();
        $list_data['total_sign_in'] = $dash->total_sign_in();
        $piedata = $dash->getdast_pie();
        $date = Carbon::now()->timezone( userTz() )->format('d F Y');
        $time = Carbon::now()->timezone( userTz() )->format('g:i A');
        
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
    
    public function showAll(){
        $current = Carbon::now()->timezone( userTz() )->format('Y-m-d 00:00:00');
        $span = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
        
        $trakrs = DB::table('trakrs')->select('trakrs.*' , 'trakr_types.name as type')
        ->where([
            'user_id' => user_id(),
            'checked_in_status' => 0
        ])
        ->where('trakrs.check_in_date' , '>=' , $current  )
        ->where('trakrs.check_in_date' , '<=' , $span )
        ->where('trakrs.status' , 0)
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id' )
        ->orderBy('checked_in_status' , 'DESC')
        ->get();
        return view('dashboard.viewall')->with('trakrs' , $trakrs);
    }
    
    public function showAllSearch( Request $request ){
        
        $current = Carbon::now()->timezone( userTz() )->format('Y-m-d 00:00:00');
        $span = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
        
        if (!$request->search) {
            $trakrs = DB::table('trakrs')->select('trakrs.*' , 'trakr_types.name as type')
            ->where([
                'user_id' => user_id(),
                'checked_in_status' => 0,
            ])
            ->where('check_in_date' , '>=' , $current)
            ->where('check_in_date' , '<=' , $span)
            ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id' )
            ->orderBy('checked_in_status' , 'DESC')
            ->get();
        }
        
        $trakrs = DB::table('trakrs')->select('trakrs.*' , 'trakr_types.name as type')
        ->where([
            'user_id' => user_id(),
            'checked_in_status' => 0,
        ])
        ->where('check_in_date' , '>=' , $current)
        ->where('check_in_date' , '<=' , $span)
        ->where('firstName' , 'like', $request->search.'%')
        ->join('trakr_types' , 'trakr_types.id' , '=' , 'trakrs.trakr_type_id' )
        ->orderBy('checked_in_status' , 'DESC')
        ->get();
        return view('dashboard.viewall')->with('trakrs' , $trakrs);
    }
}

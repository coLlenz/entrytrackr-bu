<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trakr;
use Illuminate\Http\Request;
use PDF;
use DB;
use Carbon\Carbon;

class AdminReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $date_now = strtotime( date('Y-m-d H:i:s') );
        $default_data = Trakr::select('firstName','lastName' ,'trakr_type_id' ,'phoneNumber' , 'check_in_date' , 'check_out_date' , 'assistance' , 'status' , 'who' , 'name_of_company')
        // ->where('user_id' , user_id())
        ->where('check_in_date' ,'>=', date('Y-m-d',strtotime("-7 days" , $date_now))." 00:00:00")
        ->orderBy('check_in_date' , 'DESC')
        ->where('check_in_date' , '<=' , date('Y-m-d')." 23:59:59")->paginate(10);
        $formdata = [
            'fdate' => date('Y-m-d' , strtotime("-7 days" , $date_now)),
            'edate' => date('Y-m-d' , $date_now),
            'ass' => 'all',
            'tvis' => 'all',
            'acc' => 'all'
        ];
        return view('admin.report.index')->with('formdata' , $formdata)->with('table_data' , $default_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request){
        DB::enableQueryLog();
        $start_date = Carbon::parse($request->input('fdate'))->format('Y-m-d 00:00:00');
        $end_date = Carbon::parse($request->input('edate'))->format('Y-m-d 23:59:59');
        $assistance = $request->input('ass');
        $type_of_visitor = $request->input('tvis');
        $status = $request->input('acc');
        $form_data = $request->all();
        $filter_query = Trakr::query();
        $filter_query->select('firstName','lastName' ,'trakr_type_id' , 'phoneNumber' ,'who' ,'name_of_company','check_in_date' , 'check_out_date' , 'assistance' , 'status');
        
        // $filter_query->where('user_id' , user_id() );
        
        $filter_query->when($start_date,function($q , $start_date) {
            return $q->where('check_in_date' , '>=' , $start_date);
        });
        
        $filter_query->when($end_date,function($q , $end_date ) {
            return $q->where('check_in_date' , '<=' , $end_date);
        });
        
        $filter_query->when($assistance == 'all',function($q , $assistance ) {
            return $q->where('assistance' , '>=' , 0);
        });
        
        $filter_query->when($assistance == '1',function($q , $assistance ) {
            return $q->where('assistance' , '=' , 1);
        });
        
        $filter_query->when($assistance == '0',function($q , $assistance ) {
            return $q->where('assistance' , '=' , 0);
        });
        
        $filter_query->when($type_of_visitor == 'all',function($q , $type_of_visitor ) {
            return $q->where('trakr_type_id' , '>' , 0);
        });
        
        $filter_query->when($type_of_visitor == '1',function($q , $type_of_visitor ) {
            return $q->where('trakr_type_id' , '=' , 1);
        });
        
        $filter_query->when($type_of_visitor == '2',function($q , $type_of_visitor ) {
            return $q->where('trakr_type_id' , '=' , 2);
        });
        
        $filter_query->when($type_of_visitor == '3',function($q , $type_of_visitor ) {
            return $q->where('trakr_type_id' , '=' , 3);
        });
        
        $filter_query->when($status == 'all',function($q , $status ) {
            return $q->where('status' , '>=' , 0);
        });
        
        $filter_query->when($status == '0',function($q , $status ) {
            return $q->where('status' , '=' , 0);
        });
        
        $filter_query->when($status == '1',function($q , $status ) {
            return $q->where('status' , '=' , 1);
        });
        
        $data = $filter_query->paginate(10);
        // $query = DB::getQueryLog();
        
        return view('admin.report.index')->with('table_data' ,$data)->with('formdata' , $form_data);
    }
    
    public function generate_pdf(Request $request){
        DB::enableQueryLog();
        $start_date = Carbon::parse($request->input('fdate'))->format('Y-m-d 00:00:00');
        $end_date = Carbon::parse($request->input('edate'))->format('Y-m-d 23:59:59');
        $assistance = $request->input('ass');
        $type_of_visitor = $request->input('tvis');
        $status = $request->input('acc');
        $filename = strtotime(date('Y-m-d H:i:s'));
        $filter_query = Trakr::query();
        $filter_query->select('firstName','lastName' ,'trakr_type_id' , 'phoneNumber' ,'who' ,'trakr_types.name as visitor_type','name_of_company','check_in_date' , 'check_out_date' , 'assistance' , 'status');
        $filter_query->join('trakr_types', 'trakr_types.id', '=', 'trakrs.trakr_type_id');
        // $filter_query->where('user_id' , user_id());
        
        $filter_query->when($start_date,function($q , $start_date) {
            return $q->where('check_in_date' , '>=' , $start_date);
        });
        
        $filter_query->when($end_date,function($q , $end_date ) {
            return $q->where('check_in_date' , '<=' , $end_date);
        });
        
        $filter_query->when($assistance == 'all',function($q , $assistance ) {
            return $q->where('assistance' , '>=' , 0);
        });
        
        $filter_query->when($assistance == '1',function($q , $assistance ) {
            return $q->where('assistance' , '=' , 1);
        });
        
        $filter_query->when($assistance == '0',function($q , $assistance ) {
            return $q->where('assistance' , '=' , 0);
        });
        
        $filter_query->when($type_of_visitor == 'all',function($q , $type_of_visitor ) {
            return $q->where('trakr_type_id' , '>' , 0);
        });
        
        $filter_query->when($type_of_visitor == '1',function($q , $type_of_visitor ) {
            return $q->where('trakr_type_id' , '=' , 1);
        });
        
        $filter_query->when($type_of_visitor == '2',function($q , $type_of_visitor ) {
            return $q->where('trakr_type_id' , '=' , 2);
        });
        
        $filter_query->when($type_of_visitor == '3',function($q , $type_of_visitor ) {
            return $q->where('trakr_type_id' , '=' , 3);
        });
        
        $filter_query->when($status == 'all',function($q , $status ) {
            return $q->where('status' , '>=' , 0);
        });
        
        $filter_query->when($status == '0',function($q , $status ) {
            return $q->where('status' , '=' , 0);
        });
        
        $filter_query->when($status == '1',function($q , $status ) {
            return $q->where('status' , '=' , 1);
        });
        
        $data = $filter_query->get();
        $query = DB::getQueryLog();
        
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.report_pdf')->setPaper('a4', 'landscape');;
        return $pdf->download($filename.'.pdf');
    }
    
    public function summaryReport(){
        $lists = DB::table('question_logs')
        // ->where('user_id' , user_id() )
        ->orderBy('created_at' , 'DESC')
        ->get();
        $formdata = 'all';
        return view('admin.report.summary')
        ->with('lists' , $lists)
        ->with('formdata' ,$formdata);
    }
    
    public function byVisitor(Request $request){
        $type = $request->type_of_visitor ? $request->type_of_visitor : 1;
        $formdata = $type;
        $lists = [];
        if ($type == 'all') {
            $lists = DB::table('question_logs')
            ->where('visitor_type' ,'>',0)
            ->where('user_id' , auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id)
            ->orderBy('created_at' , 'DESC')
            ->get();
        }else {
            $lists = DB::table('question_logs')
            ->where('visitor_type' , $type)
            ->where('user_id' , auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id)
            ->orderBy('created_at' , 'DESC')
            ->get();
        }
        
        return view('admin.report.summary')
        ->with('lists' , $lists)
        ->with('formdata' ,$formdata);
    }
    
    public function viewResults($question_id , $log_id) {
        $questions = DB::table('template_copy')->where([
            'id' => $question_id,
            'template_type' => 0,
        ])->first();
        
        $results = DB::table('question_logs')->where([
            'id' =>$log_id
        ])->first();
        
        $results->freetext = $results->freetext ? json_decode($results->freetext) : [];
        $results->answers =$results->answers ? json_decode($results->answers) : [];
        
        return view('admin.report.results')
        ->with('questions' , $questions)
        ->with('results' , $results);
    }
    
    public function downloadResult(Request $request){
        $filename = strtotime( date('Y-m-d H:i') );
        $data = $request->html;
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.visitorResults')->setPaper('a4');
        return $pdf->download($filename.'.pdf');
    }
}

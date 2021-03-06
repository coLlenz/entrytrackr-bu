<?php
namespace App\Http\Controllers;
use App\Models\LogReport;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Exports\ReportExport;
use App\Exports\CommentExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use DB;
use Carbon\Carbon;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $date_now = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
        $date_7_days_ago = Carbon::now()->subDays( 7 )->timezone( userTz() )->format('Y-m-d 00:00:00');
        
        $default_data = LogReport::select('trakrs.id as visitor_id','trakrs.firstName','trakrs.lastName' ,'report_logs.trakr_type_id' ,'trakrs.phoneNumber' , 'report_logs.check_in_date' , 
        'report_logs.check_out_date' , 'report_logs.assistance', 'report_logs.area_access',
        'report_logs.status' , 'report_logs.who' , 'report_logs.name_of_company')
        ->where('report_logs.user_id' , user_id() )
        ->where('report_logs.created_at' ,'>=', $date_7_days_ago )
        ->where('report_logs.created_at' , '<=' ,  $date_now )
        ->join('trakrs' , 'trakrs.id' , '=' , 'report_logs.visitor_id')
        ->orderBy('report_logs.created_at' , 'DESC' )
        ->paginate(10);

        $formdata = [
            'firstname' => '',
            'fdate' => Carbon::parse( $date_7_days_ago )->format('Y-m-d'),
            'edate' => Carbon::parse( $date_now )->format('Y-m-d'),
            'signin' => 'all',
            'ass' => 'all',
            'tvis' => 'all',
            'acc' => 'all'
        ];
        return view('report.index')->with('formdata' , $formdata)->with('table_data' , $default_data);
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
        $signin_status = $request->input('signin');
        $status = $request->input('acc');
        $form_data = $request->all();
        $filter_query = LogReport::query();
        
        $filter_query->select('trakrs.id as visitor_id','trakrs.firstName','trakrs.lastName' ,'report_logs.trakr_type_id' ,'trakrs.phoneNumber' , 'report_logs.check_in_date' , 
        'report_logs.check_out_date' , 'report_logs.assistance', 'report_logs.area_access',
        'report_logs.status' , 'report_logs.who' , 'report_logs.name_of_company');
        
        $filter_query->join('trakrs' , 'trakrs.id' , '=' , 'report_logs.visitor_id');

        $filter_query->where('report_logs.user_id' , user_id() );
       

        $filter_query->when($start_date,function($q , $start_date) {
            return $q->where('report_logs.created_at' , '>=' , $start_date);
        });
        
        $filter_query->when($end_date,function($q , $end_date ) {
            return $q->where('report_logs.created_at' , '<=' , $end_date);
        });
        
        $filter_query->when($signin_status , function($q , $signin_status){
            
            return $q->where('report_logs.checked_in_status' , '>=' , 0);
        });

        $filter_query->when($signin_status == '0', function($q , $signin_status){
            return $q->where('report_logs.checked_in_status' , '=' , 0);
        });

        $filter_query->when($signin_status == '1' , function($q , $signin_status){
            return $q->where('report_logs.checked_in_status' , '=' , 1);
        });

        $filter_query->when($assistance == 'all',function($q , $assistance ) {
            return $q->where('report_logs.assistance' , '>=' , 0);
        });
        
        $filter_query->when($assistance == '1',function($q , $assistance ) {
            return $q->where('report_logs.assistance' , '=' , 1);
        });
        
        $filter_query->when($assistance == '0',function($q , $assistance ) {
            return $q->where('report_logs.assistance' , '=' , 0);
        });
        
        $filter_query->when($type_of_visitor == 'all',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '>' , 0);
        });
        
        $filter_query->when($type_of_visitor == '1',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '=' , 1);
        });
        
        $filter_query->when($type_of_visitor == '2',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '=' , 2);
        });
        
        $filter_query->when($type_of_visitor == '3',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '=' , 3);
        });
        
        $filter_query->when($status == 'all',function($q , $status ) {
            return $q->where('report_logs.status' , '>=' , 0);
        });
        
        $filter_query->when($status == '0',function($q , $status ) {
            return $q->where('report_logs.status' , '=' , 0);
        });
        
        $filter_query->when($status == '1',function($q , $status ) {
            return $q->where('report_logs.status' , '=' , 1);
        });
        
        $filter_query->orderBy('report_logs.created_at' , 'DESC');
        
        $data = $filter_query->paginate(10);
        // $query = DB::getQueryLog();
        

        return view('report.index')->with('table_data' ,$data)->with('formdata' , $form_data);
    }
    
    public function printData($data , $filename){
        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.report_pdf')->setPaper('a4', 'landscape');;
        return $pdf->download($filename.'.pdf');
    }

    public function generate_pdf(Request $request){
        $filename = strtotime(date('Y-m-d H:i:s'));
        
        if ( count($request->all()) == 0 ) {
            $date_now = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
            $date_7_days_ago = Carbon::now()->subDays( 7 )->timezone( userTz() )->format('Y-m-d 00:00:00');
            $filename = strtotime(date('Y-m-d H:i:s'));
            $default_data = LogReport::select('trakrs.id as visitor_id','trakrs.firstName','trakrs.lastName' ,'report_logs.trakr_type_id' ,'trakrs.phoneNumber' , 'report_logs.check_in_date' , 
            'report_logs.check_out_date' , 'report_logs.assistance', 'report_logs.area_access',
            'report_logs.status' , 'report_logs.who' , 'report_logs.name_of_company')
            ->where('report_logs.user_id' , user_id() )
            ->where('report_logs.created_at' ,'>=', $date_7_days_ago )
            ->where('report_logs.created_at' , '<=' ,  $date_now )
            ->join('trakrs' , 'trakrs.id' , '=' , 'report_logs.visitor_id')
            ->orderBy('report_logs.created_at' , 'DESC' )
            ->get();
            
            view()->share('data',$default_data);
            $pdf = PDF::loadView('pdf.report_pdf')->setPaper('a4', 'landscape');;
            return $pdf->download($filename.'.pdf');
        }

        if (isset($request->search)) {
            $search = $request->search;
            $search_filter = DB::table('trakrs')
            ->select('trakrs.id as visitor_id','trakrs.firstName','trakrs.lastName' ,'report_logs.trakr_type_id' ,'report_logs.user_id','report_logs.status','trakrs.phoneNumber' , 'report_logs.check_in_date' , 
            'report_logs.check_out_date' , 'report_logs.assistance','report_logs.area_access',
            'report_logs.status' , 'report_logs.who' , 'report_logs.name_of_company')
            ->join('report_logs' , 'report_logs.visitor_id' , '=' , 'trakrs.id')
            ->where('trakrs.user_id' , user_id())
            ->where('trakrs.firstName' , 'Like' ,$request->search.'%')
            ->orWhere('trakrs.lastName' , 'Like' ,$request->search.'%')
            ->orderBy('report_logs.created_at' , 'DESC' )->get();
            
            view()->share('data',$search_filter);
            $pdf = PDF::loadView('pdf.report_pdf')->setPaper('a4', 'landscape');;
            return $pdf->download($filename.'.pdf');
        }

        
        // 
        $start_date = Carbon::parse($request->input('fdate'))->format('Y-m-d 00:00:00');
        $end_date = Carbon::parse($request->input('edate'))->format('Y-m-d 23:59:59');
        $assistance = $request->input('ass') ? $request->input('ass') : '';
        $type_of_visitor = $request->input('tvis') ? $request->input('tvis') : '';
        $status = $request->input('acc') ? $request->input('acc') : '';
        $signin_status = $request->input('signin');
        $filter_query = LogReport::query();
        
        $filter_query->select('trakrs.id as visitor_id','trakrs.firstName','trakrs.lastName' ,'report_logs.trakr_type_id' ,'trakrs.phoneNumber' , 'report_logs.check_in_date' , 
        'report_logs.check_out_date' , 'report_logs.assistance','report_logs.area_access',
        'report_logs.status' , 'report_logs.who' , 'report_logs.name_of_company');
        
        $filter_query->join('trakrs' , 'trakrs.id' , '=' , 'report_logs.visitor_id');

        $filter_query->where('report_logs.user_id' , user_id() );

        $filter_query->when($start_date,function($q , $start_date) {
            return $q->where('report_logs.created_at' , '>=' , $start_date);
        });
        
        $filter_query->when($end_date,function($q , $end_date ) {
            return $q->where('report_logs.created_at' , '<=' , $end_date);
        });
        
        $filter_query->when($signin_status , function($q , $signin_status){
            
            return $q->where('report_logs.checked_in_status' , '>=' , 0);
        });

        $filter_query->when($signin_status == '0', function($q , $signin_status){
            return $q->where('report_logs.checked_in_status' , '=' , 0);
        });

        $filter_query->when($signin_status == '1' , function($q , $signin_status){
            return $q->where('report_logs.checked_in_status' , '=' , 1);
        });

        $filter_query->when($assistance == 'all',function($q , $assistance ) {
            return $q->where('report_logs.assistance' , '>=' , 0);
        });
        
        $filter_query->when($assistance == '1',function($q , $assistance ) {
            return $q->where('report_logs.assistance' , '=' , 1);
        });
        
        $filter_query->when($assistance == '0',function($q , $assistance ) {
            return $q->where('report_logs.assistance' , '=' , 0);
        });
        
        $filter_query->when($type_of_visitor == 'all',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '>' , 0);
        });
        
        $filter_query->when($type_of_visitor == '1',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '=' , 1);
        });
        
        $filter_query->when($type_of_visitor == '2',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '=' , 2);
        });
        
        $filter_query->when($type_of_visitor == '3',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '=' , 3);
        });
        
        $filter_query->when($status == 'all',function($q , $status ) {
            return $q->where('report_logs.status' , '>=' , 0);
        });
        
        $filter_query->when($status == '0',function($q , $status ) {
            return $q->where('report_logs.status' , '=' , 0);
        });
        
        $filter_query->when($status == '1',function($q , $status ) {
            return $q->where('report_logs.status' , '=' , 1);
        });
        
        $filter_query->orderBy('report_logs.check_in_date' , 'DESC');
        
        $data = $filter_query->get();
        

        view()->share('data',$data);
        $pdf = PDF::loadView('pdf.report_pdf')->setPaper('a4', 'landscape');;
        return $pdf->download($filename.'.pdf');
    }
    
    public function summaryReport(){
        $lists = DB::table('question_logs')
        ->where('user_id' , user_id() )
        ->orderBy('created_at' , 'DESC')
        ->paginate(20);
        $formdata = 'all';
        return view('report.summary')
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
            ->where('user_id' , user_id())
            ->orderBy('created_at' , 'DESC')
            ->paginate(20);
        }else {
            $lists = DB::table('question_logs')
            ->where('visitor_type' , $type)
            ->where('user_id' , user_id())
            ->orderBy('created_at' , 'DESC')
            ->paginate(20);
        }
        
        return view('report.summary')
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
        
        return view('report.results')
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
    
    public function searchSummary(Request $request){
        $formdata = 'all';
        $lists = DB::table('question_logs')
        ->where('user_id' , user_id() )
        ->where('visitor_name' , 'like', '%'.$request->search.'%')
        ->orderBy('created_at' , 'DESC')
        ->paginate(50);
        
        return view('report.summary')
        ->with('lists' , $lists)
        ->with('formdata' ,$formdata);
    }

    public function export_csv(Request $request){
        $filename = time().'_report.csv';

        if ( count($request->all()) == 0 ) {
            $date_now = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
            $date_7_days_ago = Carbon::now()->subDays( 7 )->timezone( userTz() )->format('Y-m-d 00:00:00');
            
            $default_data = LogReport::select('trakrs.firstName','trakrs.lastName' ,'report_logs.trakr_type_id' ,'trakrs.phoneNumber' , 'report_logs.check_in_date' , 
            'report_logs.check_out_date' , 'report_logs.assistance','report_logs.area_access',
            'report_logs.status' , 'report_logs.who' , 'report_logs.name_of_company')
            ->where('report_logs.user_id' , user_id() )
            ->where('report_logs.check_in_date' ,'>=', $date_7_days_ago )
            ->where('report_logs.check_in_date' , '<=' ,  $date_now )
            ->join('trakrs' , 'trakrs.id' , '=' , 'report_logs.visitor_id')
            ->orderBy('report_logs.check_in_date' , 'DESC' )->get();
            return Excel::download(new ReportExport( $default_data ), $filename);
        }

        if (isset($request->search)) {
            $search = $request->search;
            $search_filter = DB::table('trakrs')
            ->select('trakrs.id as visitor_id','trakrs.firstName','trakrs.lastName' ,'report_logs.trakr_type_id' ,'report_logs.user_id','trakrs.phoneNumber' , 'report_logs.check_in_date' , 
            'report_logs.check_out_date' , 'report_logs.assistance','report_logs.area_access',
            'report_logs.status' , 'report_logs.who' , 'report_logs.name_of_company')
            ->join('report_logs' , 'report_logs.visitor_id' , '=' , 'trakrs.id')
            ->where('trakrs.user_id' , user_id())
            ->where('trakrs.firstName' , 'Like' ,$request->search.'%')
            ->orWhere('trakrs.lastName' , 'Like' ,$request->search.'%')
            ->orderBy('report_logs.created_at' , 'DESC' )->get();
            return Excel::download(new ReportExport(  $search_filter ), $filename);
        }
        
       
        // 
        $start_date = Carbon::parse($request->input('fdate'))->format('Y-m-d 00:00:00');
        $end_date = Carbon::parse($request->input('edate'))->format('Y-m-d 23:59:59');
        $signin_status = $request->input('signin');
        $assistance = $request->input('ass') ? $request->input('ass') : '';
        $type_of_visitor = $request->input('tvis') ? $request->input('tvis') : '';
        $status = $request->input('acc') ? $request->input('acc') : '';
       
        $filter_query = LogReport::query();
        
        $filter_query->select('trakrs.firstName','trakrs.lastName' ,'report_logs.trakr_type_id' ,'trakrs.phoneNumber' , 'report_logs.check_in_date' , 
        'report_logs.check_out_date' , 'report_logs.assistance','report_logs.area_access',
        'report_logs.status' , 'report_logs.who' , 'report_logs.name_of_company');
        
        $filter_query->join('trakrs' , 'trakrs.id' , '=' , 'report_logs.visitor_id');

        $filter_query->where('report_logs.user_id' , user_id() );
        
        $filter_query->when($start_date,function($q , $start_date) {
            return $q->where('report_logs.created_at' , '>=' , $start_date);
        });
        
        $filter_query->when($end_date,function($q , $end_date ) {
            return $q->where('report_logs.created_at' , '<=' , $end_date);
        });
        
        $filter_query->when($signin_status , function($q , $signin_status){
            return $q->where('report_logs.checked_in_status' , '>=' , 0);
        });

        $filter_query->when($signin_status == '0', function($q , $signin_status){
            return $q->where('report_logs.checked_in_status' , '=' , 0);
        });

        $filter_query->when($signin_status == '1' , function($q , $signin_status){
            return $q->where('report_logs.checked_in_status' , '=' , 1);
        });

        $filter_query->when($assistance == 'all',function($q , $assistance ) {
            return $q->where('report_logs.assistance' , '>=' , 0);
        });
        
        $filter_query->when($assistance == '1',function($q , $assistance ) {
            return $q->where('report_logs.assistance' , '=' , 1);
        });
        
        $filter_query->when($assistance == '0',function($q , $assistance ) {
            return $q->where('report_logs.assistance' , '=' , 0);
        });
        
        $filter_query->when($type_of_visitor == 'all',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '>' , 0);
        });
        
        $filter_query->when($type_of_visitor == '1',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '=' , 1);
        });
        
        $filter_query->when($type_of_visitor == '2',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '=' , 2);
        });
        
        $filter_query->when($type_of_visitor == '3',function($q , $type_of_visitor ) {
            return $q->where('report_logs.trakr_type_id' , '=' , 3);
        });
        
        $filter_query->when($status == 'all',function($q , $status ) {
            return $q->where('report_logs.status' , '>=' , 0);
        });
        
        $filter_query->when($status == '0',function($q , $status ) {
            return $q->where('report_logs.status' , '=' , 0);
        });
        
        $filter_query->when($status == '1',function($q , $status ) {
            return $q->where('report_logs.status' , '=' , 1);
        });
        
        $filter_query->orderBy('report_logs.created_at' , 'DESC');
        
        $data = $filter_query->get();
        
        return (new ReportExport( $data  ))->download($filename, \Maatwebsite\Excel\Excel::CSV, [
            'X-Vapor-Base64-Encode' => 'true'
        ]);
    }

    public function add_comment(Request $request ){
       $comment = Comment::create([
           'user_id' => user_id(),
           'visitor_id' => $request->id,
           'comment' => $request->comment,
           'created_at' => Carbon::now()
       ]);

       if ($comment) {
           return response()->json(['icon' => 'success' , 'msg' => 'Added comment successfully.' , 'status' => 'success']);
       }

       return response()->json(['icon' => 'error' , 'msg' => 'Something went wrong. Please try refreshing the page.' , 'status' => 'error']);

    }

    public function download_comment( $visitor_id ){
        $data = Comment::where(['user_id' => user_id() , 'visitor_id' => $visitor_id ])->orderBy('created_at' , 'DESC')->get();
        $filename = time().'_comments.csv';
        
        return (new CommentExport( $data  ))->download($filename, \Maatwebsite\Excel\Excel::CSV, [
            'X-Vapor-Base64-Encode' => 'true'
        ]);
    }

    public function getCommentHistory($visitor_id){
        $visitor_history = Comment::select('created_at' , 'comment')->where(['user_id' => user_id() , 'visitor_id' => $visitor_id])->orderBy('created_at' , 'DESC')->get();
        
        if (!$visitor_history->isEmpty()) {
            $list = false;
           foreach ($visitor_history as $key => $value) {
                $created_at = Carbon::parse( $value->created_at )->timezone( userTz() )->format('d-m-Y H:i');
                $list[$key]['created_at'] =  $created_at;
                $list[$key]['comment'] = $value->comment;
            }

           return response()->json(['status' => 'success' , 'data' =>  $list] , 200);
        }

        return response()->json(['status' => 'success' , 'data' => [] ] , 200);
    }

    public function search(Request $request){
        $date_now = Carbon::now()->timezone( userTz() )->format('Y-m-d 23:59:59');
        $date_7_days_ago = Carbon::now()->subDays( 7 )->timezone( userTz() )->format('Y-m-d 00:00:00');
        $formdata = [
            'firstname' => '',
            'fdate' => Carbon::parse( $date_7_days_ago )->format('Y-m-d'),
            'edate' => Carbon::parse( $date_now )->format('Y-m-d'),
            'signin' => 'all',
            'ass' => 'all',
            'tvis' => 'all',
            'acc' => 'all'
        ];
        
        $search_filter = DB::table('trakrs')
        ->select('trakrs.id as visitor_id','trakrs.firstName','trakrs.lastName' ,'report_logs.trakr_type_id' ,'report_logs.user_id','trakrs.phoneNumber' , 'report_logs.check_in_date' , 
        'report_logs.check_out_date' , 'report_logs.assistance','report_logs.area_access',
        'report_logs.status' , 'report_logs.who' , 'report_logs.name_of_company')
        ->join('report_logs' , 'report_logs.visitor_id' , '=' , 'trakrs.id')
        ->where('trakrs.user_id' , user_id())
        ->where('trakrs.firstName' , 'Like' ,$request->search.'%')
        ->orWhere('trakrs.lastName' , 'Like' ,$request->search.'%')
        ->paginate(10);

        return view('report.index')->with('table_data' ,$search_filter)->with('formdata' , $formdata);
    }
}

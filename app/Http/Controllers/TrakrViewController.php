<?php

namespace App\Http\Controllers;
use App\Models\Trakr;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use DB;
class TrakrViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $view_data = [];
        $view_data['is_mobile'] = false;
        return view('trakr.index')->with('view_data' , $view_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request , $userid = false){
        $validator = Validator::make($request->all() , [
            'first_name' => 'required',
            'last_name' => 'required',
            'phoneNumber' => 'required',
            // 'email' => 'email|nullable',
            'visitor_type' => 'required'
        ]);
        
        if ($validator->passes()) {
            // check if existing data 
            $checking = $this->checkIfLoggedIn($request->all());
            if (isset($checking['has_record']) && $checking['has_record']) {
                $visitor = Trakr::findOrFail($checking['visitor_id']);
                $visitor->assistance = isset($request->need_assistance) ? 1:0; 
                $visitor->checked_in_status = 0;
                $visitor->check_in_date = date('Y-m-d H:i:s');
                $visitor->check_out_date = null;
                $visitor->trakr_type_id = $request->visitor_type;
                $formated_date = Carbon::parse($visitor->check_in_date)->format('d F Y g:i A');
                
                if ( !$visitor->save() ) {
                    return response()->json(['status' => 'fail','msg' => 'There\'s a problem creating your record.'],200);
                }
                
                return response()->json(
                    [
                        'status' => 'success',
                        'has_trakr' => $visitor->trakr_id ? true : false,
                        'msg' => 'Checked-In' , 
                        'name' => $visitor->firstName , 
                        'check_date' => $formated_date,
                        'type_of_visitor' => $visitor->trakr_type_id,
                        'trakrid' => $visitor->id,
                        'questions' => $this->getVisitorQuestions(  $visitor->user_id  , $visitor->trakr_type_id)
                    ],200);
            }
            
            $trakr_new = new Trakr();
            
            $trakr_new->firstName = $request->first_name;
            $trakr_new->lastName = $request->last_name;
            $trakr_new->assistance = isset($request->need_assistance) ? 1:0;
            $trakr_new->phoneNumber = $request->phoneNumber;
            // $trakr_new->email = $request->email;
            $trakr_new->trakr_type_id = $request->visitor_type;
            $trakr_new->user_id = ($userid) ? $userid : auth()->user()->id;
            $trakr_new->status = 0;
            $trakr_new->checked_in_status = 0;
            $trakr_new->check_in_date = date('Y-m-d H:i:s');
            $formated_date = Carbon::parse($trakr_new->check_in_date)->format('d F Y g:i A');
            
            if ($trakr_new->save()) {
                return response()->json(
                    [
                        'status' => 'success',
                        'has_trakr' => $trakr_new->trakr_id ? true : false,
                        'msg' => 'Checked-In' , 
                        'name' => $trakr_new->firstName , 
                        'check_date' => $formated_date,
                        'type_of_visitor' => $trakr_new->trakr_type_id,
                        'trakrid' => $trakr_new->id,
                        'questions' => $this->getVisitorQuestions(  $trakr_new->user_id  , $trakr_new->trakr_type_id)
                ],200);
            }else{
                return response()->json(['status' => 'fail','msg' => 'There\'s a problem creating your record.'],200);
            }
        }else {
            return response()->json(['status' => 'fail','validator' => $validator->errors()->all() ],200);
        }
    }
    
    public function getVisitorQuestions( $user_id = false , $visitor_type = false){
        $questions = DB::table('template_copy')->select('title','questions' , 'content_html' ,'id' , 'description' , 'questions_to_flg')->where([
            'user_id' => $user_id,
            'template_type' => 0,
            'status' => 1
        ])->get();
        
        $data = [];
        
        foreach ($questions as $key => $value) {
            if (in_array( $visitor_type , json_decode($value->questions_to_flg) )) {
                $data = $questions[$key];
            }else{
                // do nothing my friend
            }
        }
        return $data ? $data : false;
    }
    
    public function trakrid(Request $request){
        // SIMPLE CHECK IN
        $validator = Validator::make($request->all(), [
            'trakrid' => 'required',
        ]);
        
        if ($validator->passes()) {
            // check if logged in already
            $checking = $this->checkIfLoggedIn($request->all());
            if (isset( $checking['is_loggedin'] ) && $checking['is_loggedin'] == 0) {
                return response()->json(['status' => 'loggedin' , 'check_date' => $this->carbonFormat($checking['check_date'])] , 200 );
            }
            
            //update status if not logged in
            $trakr = Trakr::where('trakr_id' ,$request->trakrid)->update(['checked_in_status' => 0,'check_in_date' => date('Y-m-d H:i:s')]);
            
            //get updated data
            $check_in_data = Trakr::where('trakr_id' ,$request->trakrid)->first();
            $date = $this->carbonFormat($check_in_data->check_in_date);
            return response()->json(
                [
                    'has_trakr' => $check_in_data->trakr_id ? true : false,
                    'check_date' =>$date , 
                    'name' => $check_in_data->firstName,
                    'status' => 'success',
                    'msg' => 'Checked-In' , 
                    'type_of_visitor' => $check_in_data->trakr_type_id,
                    'trakrid' => $check_in_data->id,
                    'questions' => $this->getVisitorQuestions(  $check_in_data->user_id  , $check_in_data->trakr_type_id)
                ] , 200);
        }else{
            return response()->json(['validation_error' => $validator->errors()->all()] , 200 );
        }
    }
    
    public function trakrcheckout(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phoneNumber' => 'required',
        ]);
        
        if ($validator->passes()) {
            // checking user status
            $checking = $this->checkIfLoggedIn($request->all());
            if (isset( $checking['is_loggedin'] ) && $checking['is_loggedin'] == 1) {
                return response()->json(['status' => 'loggedout' , 'check_date' => $this->carbonFormat($checking['check_out_date'])] , 200 );
            }
            
            //get user datas
            $trakr = Trakr::where([
                'firstName' => $request->first_name,
                'lastName' => $request->last_name,
                'phoneNumber' => $request->phoneNumber,
            ])->first();
            
            if (!$trakr) {
                return response()->json(['status' => 'nodata'] , 200 );
            }
            //update data to logged out
            $trakr->checked_in_status = 1;
            $trakr->check_out_date = date('Y-m-d H:i:s');
            if ($trakr->save()) {
                $updated_data = Trakr::select('check_out_date')->where('phoneNumber' , $request->phoneNumber)->first();
                return response()->json(
                    [
                        'status' => 'success' ,
                        'name' => $trakr->firstName ,
                        'check_date' => $this->carbonFormat($updated_data->check_out_date)
                    ] , 200 );
            }
        }else{
            // validation errors
            return response()->json(['validation_error' => $validator->errors()->all()] , 200 );
        }
    }
    
    public function visitingWho(Request $request){
        $trakr = Trakr::findOrFail($request->trakrid);
        $trakr->who = $request->visited;
        
        if ($trakr->save()) {
            return response()->json(['status' => 'success'] , 200);
        }
        
        return response()->json(['status' => 'fail'] , 200);
    }
    
    public function business(Request $request){
        $trakr = Trakr::findOrFail($request->trakrid);
        $trakr->name_of_company = $request->name_of_business;
        
        if ($trakr->save()) {
            return response()->json(['status' => 'success'] , 200);
        }
        
        return response()->json(['status' => 'fail'] , 200);
    }

    public function carbonFormat($date){
        return Carbon::parse($date)->format('d F Y g:i A');
    }
    
    public function checkIfLoggedIn($condition){
        $returndata = [];
        $checker_query = Trakr::query();
        $checker_query->select('checked_in_status' , 'check_in_date','check_out_date' , 'id as visitor_id');
        
        // 
        if (!empty($condition['first_name']) && isset($condition['first_name'])) {
            $checker_query->where('firstName' , $condition['first_name']);
        }
        
        if (!empty($condition['last_name']) && isset($condition['last_name'])) {
            $checker_query->where('lastName' , $condition['last_name']);
        }
        
        if (!empty($condition['phoneNumber']) && isset($condition['phoneNumber'])) {
            $checker_query->where('phoneNumber' , $condition['phoneNumber']);
        }
        
        // if trakrid only provided;
        
        if (!empty($condition['trakrid']) && isset($condition['trakrid'])) {
            $checker_query->where('trakr_id' , $condition['trakrid']);
        }
        
        $isLoggedIn = $checker_query->first();
        
        if ($isLoggedIn) {
            $returndata['visitor_id'] = $isLoggedIn->visitor_id;
            $returndata['is_loggedin'] = $isLoggedIn->checked_in_status;
            $returndata['check_date'] = $isLoggedIn->check_in_date;
            $returndata['check_out_date'] = $isLoggedIn->check_out_date;
            $returndata['firstName'] = $isLoggedIn->firstName;
            $returndata['has_record'] = true;
        }
        
        return $isLoggedIn ? $returndata : false;
    }
    
    public function notificationCheck($userid = false){
        $template = DB::table('template_copy')->where(['status' => 1 , 'template_type' => 1 , 'user_id' => ($userid) ? $userid :  auth()->user()->id])->first();
        
        if ($template) {
            return response()->json(['status' => 'success' , 'has_notif' => true , 'notif' => $template] , 200);
        }
        
        return response()->json(['status' => 'success' , 'has_notif' => false , 'notif' => [] ] , 200);
        
    }
    
    public function visitorAnswer(Request $request){
        $question = DB::table('template_copy')->select('questions' , 'title' , 'user_id')->where('id' , $request->questionId)->first();
        $decoded = json_decode( $question->questions );
        $wrong = 0;
        $index = 0;
        $answers = [];
        
        // Answer with Choices Only
        foreach ($request->all() as $key => $input) {
            if ($key != 'questionId' && $key != 'trakrid' && $key !='temp_check' && $key != 'freetext') {
                if (strtoupper($decoded[$index]->correctAnswer) != strtoupper($input) ) {
                    $wrong++;
                    $answers[$index] = $input;
                }else{
                    $answers[$index] = $input;
                }
                $index++;
            }
        }
        
        // Temperature Check
        if ($request->temp_check) {
            $tempCheck = DB::table('entry_allowed_temp')->first();
            if ($request->temp_check > $tempCheck->temp) {
                $wrong++;
            }
        }
        
        // get current signin data
        $trakr = Trakr::findOrFail($request->trakrid);
        $visitor_name = $trakr->firstName." ".$trakr->lastName;
        
        // save logs
        $logs = DB::table('question_logs')->insert([
            'user_id' => $question->user_id,
            'visitor_id' => $request->trakrid,
            'visitor_type' => $trakr->trakr_type_id,
            'visitor_name' => $visitor_name ? $visitor_name : '',
            'question_id' => $request->questionId ? $request->questionId : '',
            'question_title' => $question->title ? $question->title : '',
            'temperature' => $request->temp_check ? $request->temp_check : '',
            'freetext' =>  $request->freetext ? json_encode($request->freetext) : '',
            'answers' => json_encode($answers),
            'status' => $wrong > 0 ? 1 : 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        // end logs
        
        if ($wrong > 0) {
            $trakr->status = 1;
            $trakr->checked_in_status = 1;
            $trakr->check_out_date = date('Y-m-d H:i:s');
            $trakr->save();
            return response()->json(['status' => 'success' , 'examStatus' => false , 'logs' => $logs ? true : false] , 200);
        }else{
            $formated_date = Carbon::parse($trakr->check_in_date)->format('d F Y g:i A');
            return response()->json(
                [
                    'status' => 'success',
                    'has_trakr' => $trakr->trakr_id ? true : false,
                    'msg' => 'Checked-In' , 
                    'name' => $trakr->firstName ,
                    'check_date' => $formated_date,
                    'type_of_visitor' => $trakr->trakr_type_id,
                    'trakrid' => $trakr->id,
                    'examStatus' => true,
                    'logs' => $logs ? true : false
            ],200);
        }
    }
    
    function trakrIdCheck(Request $request){
        $trakr = Trakr::where('trakr_id' , $request->input)->get();
        
        if (!$trakr->isEmpty()) {
            return response()->json(['status' => 'success' , 'is_existing' => true] , 200);
        }
        return response()->json(['status' => 'success' , 'is_existing' => false] , 200);
    }
    
    function saveTrakrId(Request $request){
        $trakr = Trakr::findOrFail($request->visitor_id);
        $trakr->trakr_id = $request->trakr_id;
        if ($trakr->save()) {
            return response()->json(['status' => 'success']);
        }
        
        return response()->json(['status' => 'fail']);
    }
    
    public function QRLoginView( $uuid , $userid ){
        $qr_path = DB::table('users')->where('id' ,$userid)->first();
        $view_data = [];
        $view_data['is_mobile'] = true;
        $view_data['uuid'] = $uuid;
        $view_data['userid'] = $userid;
        $view_data['qr_path'] = $qr_path->qr_path;
        return view('trakr.mobile')->with('view_data' , $view_data);
    }
}

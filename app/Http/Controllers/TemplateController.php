<?php
namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;
use Session;

class TemplateController extends Controller
{

    public function index(){
        $templates = DB::table('template_copy')->where([
            'user_id' => user_id(),
            'template_status' => 0
        ])
        ->orderBy('created_at' , 'DESC')
        ->paginate(10);
        return view('template.index')->with('templates' , $templates);
    }
    
    public function notificationcreate(){
        $templates = [];
        
        $templates = Template::where(['template_type' => 1])
        ->orderBy('created_at' , 'DESC')
        ->get();
        
        return view("template.notificationAdd")->with('templates' , $templates);
    }

    public function save_new_notifications(Request $request){
        
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'jsondata' => 'required',
        ]);
        
        if (!$validator->passes()) {
            return response()->json(['status' => 'error' , 'form_validation' => $validator->errors()->all()] , 200);
        }
        
        if ( auth()->user()->is_admin ) {
            $template = new Template();
            $template->title = $request->title;
            $template->description = '';
            $template->content_json = $request->jsondata;
            $template->template_type = 1;
            
            if ( $template->save() ) {
                return response()->json(['status' => 'success' , 'template_id' => $template->id] , 200);
            }else{
                return response()->json(['status' => 'error' , 'msg' => 'Error Saving template.'] , 200);
            }
            
        }
        
        
        $template = DB::table('template_copy')
        ->insert([
            'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id,
            'title' => $request->title,
            'description' => '',
            'content_html' => '',
            'content_json' => $request->jsondata,
            'template_type' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        $template_id = DB::getPdo()->lastInsertId();
        
        if ($template) {
            return response()->json(['status' => 'success' , 'template_id' => $template_id] , 200);
        }else{
            return response()->json(['status' => 'error' , 'msg' => 'Error Saving template.'] , 200);
        }
    }
    
    public function notificationedit($template_id){
        if ( auth()->user()->is_admin ) {
            $template = Template::findOrfail($template_id);
            return view("template.notificationEdit", compact("template"));
        }
        
        $template = DB::table('template_copy')->where(['id' => $template_id , 'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id])->first();
        return view("template.notificationEdit", compact("template"));
    }
    
    public function notificationupdate(Request $request, $template_id){
        //for super admin
        if( auth()->user()->is_admin ){
            $template = Template::findOrfail($template_id);
            $template->title = $request->title;
            $template->content_json = $request->jsondata;
            $template->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            if ( $template->save() ) {
                return response()->json(['status' => 'success'] , 200);
            }else{
                return response()->json(['status' => 'error'] , 200);
            }
        }
        
        //for customer
        $template = DB::table('template_copy')->where(['id' => $template_id , 'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id])->update(
            [
                'title' => $request->title,
                'content_json' => $request->jsondata,
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        );
        if ($template) {
            return response()->json(['status' => 'success'] , 200);
        }else{
            return response()->json(['status' => 'error'] , 200);
        }
    }

    public function destroy($template_id){
        if (auth()->user()->is_admin) {
            $template = Template::findOrFail($template_id);
            $template->delete();
            return redirect()->route("template-index")->with('success', 'Template Deleted Successfully');
        }
        
        $template = DB::table('template_copy')->where([
            'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id,
            'id' => $template_id
        ])->update(['template_status' => 1]);
        return redirect()->route("template-index")->with('success', 'Template Deleted Successfully');
    }

    public function questionView(){
        $templates = Template::where('template_type' , 0)->get();
        return view("template.questionnaire" , compact('templates') );
    }
    
    public function questionAdd(Request $request){
        if (auth()->user()->is_admin) {
            $template = new Template();
            $template->title = $request->question_title;
            $template->description = $request->question_description;
            $template->content_html = $request->question_html;
            $template->questions = $request->question_data;
            $template->template_type = 0;
            
            if ($template->save()) {
                return response()->json(['status' => 'success' , 'template_id' => $template->id], 200);
            }
            return response()->json(['status' => 'fail'], 200);
        }
        
        $template = DB::table('template_copy')->insert([
            'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id,
            'title' => $request->question_title,
            'description' => $request->question_description,
            'content_html' =>  $request->question_html,
            'questions' => $request->question_data,
            'questions_to_flg' => $request->toVisitor,
            'status' => 0,
            'template_type' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        if ($template) {
            return response()->json(['status' => 'success' , 'template_id' => DB::getPdo()->lastInsertId()], 200);
        }
        return response()->json(['status' => 'fail'], 200);
    }
    
    public function questionEdit($template_id){
        $template = DB::table('template_copy')->where(['id' => $template_id , 'template_type' => 0])->first();
        $template->questions_to_flg = json_decode( $template->questions_to_flg );
        return view("template.questionEdit", compact("template"));
    }
    
    public function questionUpdate(Request $request, $template_id){
        if ( auth()->user()->is_admin ) {
            $template = Template::findOrFail($template_id);
            $template->title = $request->question_title;
            $template->description = $request->question_description;
            $template->content_html = $request->question_html;
            $template->questions = $request->question_data;
            if ($template->save()) {
                return response()->json(['status' => 'success'], 200);
            }
        }
        
        $template = DB::table('template_copy')->where([
            'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id,
            'id' => $template_id
        ])->update([
            'title' => $request->question_title,
            'description' => $request->question_description,
            'content_html' => $request->question_html,
            'questions' => $request->question_data,
            'questions_to_flg' => $request->toVisitor,
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
        
        if ($template) {
            return response()->json(['status' => 'success'], 200);
        }
        
    }
    
    public function QuestionChangeStatus($template_id){
        //check existing active question template
        // $active_question = DB::table('template_copy')->select('status' , 'id')->where(['template_type' => 0 , 'status' => 1])->first();
        // 
        // if (!empty($active_question) && $active_question->status) {
        //     $status = DB::table('template_copy')->where([
        //         'id' => $active_question->id
        //     ])->update(['status' => 0 , 'updated_at' => date('Y-m-d H:i:s')]);
        // }
        
        DB::table('template_copy')->where(['user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id , 'id' => $template_id])->update(['status' => 1]);
        return redirect()->route("template-index")->with('success', 'Template Activated Successfully');
    }
    
    public function activate($template_id){
        //check existing active template
        $active_template = DB::table('template_copy')->select('status' , 'id')->where([
            'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id,
            'status' => 1 , 
            'template_type' => 1
        ])->first();
        
        if (!empty($active_template) && $active_template->status) {
            DB::table('template_copy')->where([
                'id' => $active_template->id
            ])->update(['status' => 0 , 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }
        
        DB::table('template_copy')->where([
            'user_id' => auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id,
            'id' => $template_id,
            ])->update(['status' => 1]);
        return redirect()->route("template-index")->with('success', 'Template Activated Successfully');
    }
    
    public function deactivate($tempalte_id){
        DB::table('template_copy')->where('id' , $tempalte_id)->update(["status"=> 0]);
        return redirect()->route("template-index")->with('success', 'Template Deactivated Successfully');
    }

    public function copyTemplate($template){
        $template_data = DB::table('template_copy')->where('id' , $template)->first();

        $new_template = DB::table('template_copy')->insert([
            'user_id' => $template_data->user_id,
            'title'   => $template_data->title.'(Copy)',
            'description' => $template_data->description,
            'content_html' => $template_data->content_html,
            'content_json' => $template_data->content_json,
            'questions' => $template_data->questions,
            'questions_to_flg' => $template_data->questions_to_flg,
            'template_type' => $template_data->template_type,
            'status' => 0,
        ]);
        
        if ($new_template) {
            Session::flash('message', 'New template added.'); 
            return redirect()->back();
        }
        
        
    }
}

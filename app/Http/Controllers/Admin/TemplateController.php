<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class TemplateController extends Controller
{
    public function index(){
        $templates = DB::table('templates')->where('status' , 0)->get();
        return view('admin.templates.index')->with('templates' , $templates);
    }
    
    public function addView(){
        $templates = Template::where(['template_type' => 1])
        ->orderBy('created_at' , 'DESC')
        ->get();
        return view('admin.templates.notificationAdd')->with('templates' , $templates);
    }
    
    public function save_new_notifications(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'jsondata' => 'required',
        ]);
        
        if (!$validator->passes()) {
            return response()->json(['status' => 'error' , 'form_validation' => $validator->errors()->all()] , 200);
        }
        
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
    
    public function notificationedit($template_id){
        $template = Template::findOrfail($template_id);
        return view("admin.templates.notificationEdit", compact("template"));
    }
    
    public function notificatioSaveEdit(Request $request, $template_id){
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
    
    public function questionView(){
        $templates = Template::where('template_type' , 0)->get();
        return view('admin.templates.questionnaireAdd', compact('templates') );
    }
    
    public function questionSave(Request $request){
        $template = new Template();
        $template->title = $request->question_title;
        $template->description = $request->question_description ? $request->question_description : ' ';
        $template->content_html = $request->question_html;
        $template->questions = $request->question_data;
        $template->template_type = 0;
        
        if ($template->save()) {
            return response()->json(['status' => 'success' , 'template_id' => $template->id], 200);
        }
        return response()->json(['status' => 'fail'], 200);
    }
    
    public function questionEditView($template_id){
        $template = Template::where(['id' => $template_id , 'template_type' => 0])->first();
        return view('admin.templates.questionEdit')->with('template' , $template);
    }
    
    public function questionEditSave(Request $request, $template_id){
        $template = Template::findOrFail($template_id);
        $template->title = $request->question_title;
        $template->description = $request->question_description;
        $template->content_html = $request->question_html;
        $template->questions = $request->question_data;
        if ($template->save()) {
            return response()->json(['status' => 'success'], 200);
        }
    }
    
    public function templateRemove($template_id){
        $template = Template::findOrFail($template_id);
        $template->status = 1;
        $template->save();
        return redirect()->route("template-index")->with('success', 'Template Deleted Successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
class TemplateController extends Controller
{

    public function index(){
        if ( auth()->user()->is_admin ) {
            $templates = Template::paginate(10);
            return view('template.index')->with('templates' , $templates);
        }
        
        $templates = DB::table('template_copy')->where('user_id' , auth()->user()->id)->paginate(10);
        return view('template.index')->with('templates' , $templates);
    }
    
    public function notificationcreate(){
        //get all avaialable templates create by super admin
        $templates = Template::all();
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
            $template->content_json = $request->jsondata;
            $template->template_type = 1;
            
            if ( $template->save() ) {
                return response()->json(['status' => 'success'] , 200);
            }else{
                return response()->json(['status' => 'error' , 'msg' => 'Error Saving template.'] , 200);
            }
            
        }
        
        
        $template = DB::table('template_copy')
        ->insert([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'content_html' => '',
            'content_json' => $request->jsondata,
            'template_type' => 1
        ]);
        
        if ($template) {
            return response()->json(['status' => 'success'] , 200);
        }else{
            return response()->json(['status' => 'error' , 'msg' => 'Error Saving template.'] , 200);
        }
    }
    
    public function notificationedit($template_id){
        
        if ( auth()->user()->is_admin ) {
            $template = Template::findOrfail($template_id);
            return view("template.notificationEdit", compact("template"));
        }
        
        $template = DB::table('template_copy')->where(['id' => $template_id , 'user_id' => auth()->user()->id])->first();
        return view("template.notificationEdit", compact("template"));
    }
    
    public function notificationupdate(Request $request, $template_id){
        //for super admin
        if( auth()->user()->is_admin ){
            $template = Template::findOrfail($template_id);
            $template->title = $request->title;
            $template->content_json = $request->jsondata;
            $template->updated_at = date('Y-m-d H:i:s');
            if ( $template->save() ) {
                return response()->json(['status' => 'success'] , 200);
            }else{
                return response()->json(['status' => 'error'] , 200);
            }
        }
        
        //for customer
        $template = DB::table('template_copy')->where(['id' => $template_id , 'user_id' => auth()->user()->id])->update(
            [
                'title' => $request->title,
                'content_json' => $request->jsondata,
                'updated_at' => date('Y-m-d H:i:s')
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
            'user_id' => auth()->user()->id,
            'id' => $template_id
        ])->delete();
        return redirect()->route("template-index")->with('success', 'Template Deleted Successfully');
    }

    public function formcreate(){
        return view("template.formAdd");
    }
    
    public function formstore(Request $request){
        $this->validate($request, [
            'content' => 'required',
            'name1' => 'required',
        ]);

        $trakr = Template::create([
            "name" => $request->name1,
            "content"=> $request->content,
            "template_type"=> "Form",
            "user_id"=>auth()->user()->id,
        ]);
        return redirect()->route("template-index")->with('success', 'Form Added Successfully');

    }
    public function formedit($template_id){
        $template = DB::table('template_copy')->where(['id' => $template_id , 'user_id' => auth()->user()->id])->get();
        return view("template.formEdit", compact("template"));
    }
    public function formupdate(Request $request, Template $id)
    {
        // dd($request->all());
        $this->validate($request, [
            'content' => 'required',
            'name1' => 'required',
        ]);
         $id->update([
            "name" => $request->name1,
            "content"=> $request->content,
        ]);
        return redirect()->route("template-index")->with('success', 'Form Updated Successfully');
    }
    public function activate($template_id){
        //check existing active template
        $active_template = DB::table('template_copy')->select('status' , 'id')->where(['user_id' => auth()->user()->id,'status' => 1])->first();
        
        if (!empty($active_template) && $active_template->status) {
            DB::table('template_copy')->where([
                'id' => $active_template->id
            ])->update(['status' => 0 , 'updated_at' => date('Y-m-d H:i:s')]);
        }
        
        DB::table('template_copy')->where(['user_id' => auth()->user()->id , 'id' => $template_id])->update(['status' => 1]);
        return redirect()->route("template-index")->with('success', 'Template Activated Successfully');
    }
    public function deactivate($tempalte_id){
        DB::table('template_copy')->where('id' , $tempalte_id)->update(["status"=> 0]);
        return redirect()->route("template-index")->with('success', 'Template Deactivated Successfully');
    }
}

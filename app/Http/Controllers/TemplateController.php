<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::where("user_id", auth()->user()->id)->get();
        return view('template.index',compact("templates"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notificationcreate()
    {
        return view("template.notificationAdd");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'name' => 'required',
        ]);

        $trakr = Template::create([
            "name" => $request->name,
            "content"=> $request->content,
            "template_type"=> "Notification",
            "user_id"=>auth()->user()->id,
        ]);
        return redirect()->route("template-index")->with('success', 'Notification Added Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function notificationedit(Template $id)
    {
        $template = $id; 
        return view("template.notificationEdit", compact("template"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function notificationupdate(Request $request, Template $id)
    {
        
        $this->validate($request, [
            'content' => 'required',
            'name' => 'required',
        ]);
         $id->update([
            "name" => $request->name,
            "content"=> $request->content,
        ]);
        return redirect()->route("template-index")->with('success', 'Notification Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        $template->delete();
        return redirect()->route("template-index")->with('success', 'Template Deleted Successfully');
    }

    public function formcreate()
    {
        return view("template.formAdd");
    }
    public function formstore(Request $request)
    {
        // dd($request->all());
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
    public function formedit(Template $id)
    {
        // dd(simplexml_load_string($id->content));
        $template = $id; 
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
    public function activate( Template $id)
    {
        if($id->template_type == "Notification"){
            $template = Template::where("user_id",auth()->user()->id)->where("template_type","Notification")->where("status","1")->update([
                "status"=> 0
            ]);
        }else{
            $template = Template::where("user_id",auth()->user()->id)->where("template_type","Form")->where("status","1")->update([
                "status"=> 0
            ]);
        }
        
        $id->update([
            "status"=> 1
        ]);
        
        return redirect()->route("template-index")->with('success', 'Template Activated Successfully');
    }
    public function deactivate( Template $id)
    {
        $id->update([
            "status"=> 0
        ]);
        
        return redirect()->route("template-index")->with('success', 'Template Deactivated Successfully');
    }
}

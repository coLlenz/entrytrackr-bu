<?php

namespace App\Http\Controllers;

use App\Models\Support;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\SupportMail;
use Illuminate\Support\Facades\Mail;
class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $help = Support::all();
        return view('support.index')->with('help' , $help);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Supportstore(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
        ]);

        $trakr = Support::create([
            "title" => $request->title,
            "content"=> $request->content
        ]);
        return redirect()->route("support-index")->with('success', 'UserGuid Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function show(Support $support)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function edit(Support $id)
    {
        $support = $id; 
        return view("support.edit", compact("support"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Support $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required',
        ]);

        $id->update([
            "title" => $request->title,
            "content"=> $request->content
        ]);
        return redirect()->route("support-index")->with('success', 'UserGuid Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Support  $support
     * @return \Illuminate\Http\Response
     */
    public function destroy(Support $support)
    {
        //
    }

    public function support_email(Request $request) {

        $data = [
            'name' => $request->support_name,
            'email' => $request->support_email,
            'phone' => $request->support_phone,
            'message' => $request->report_request,
            'req_sub' => auth()->user()->name
        ];
        
        Mail::to( 'amabaderek@gmail.com' )->send(new SupportMail( $data ));
        

        return response()->json(['status' => 'success' , 'icon' => 'success' , 'msg' => 'Support request sent.']);
    }
}

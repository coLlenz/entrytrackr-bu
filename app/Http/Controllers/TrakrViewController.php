<?php

namespace App\Http\Controllers;

use App\Models\TrakrView;
use App\Models\Trakr;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;

class TrakrViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::where("uuid", $id)->first();
        $notification = Template::where("user_id",$user->id)->where("template_type","Notification")->where("status","1")->first();
        $form = Template::where("user_id",$user->id)->where("template_type","Form")->where("status","1")->first();
        $id = $user;
        return view('trakr.index',compact("id","notification","form"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $trakr = Trakr::create([
                "firstName" => $request->firstName,
                "lastName"=> $request->lastName,
                "trakr_id"=> $this->setUsernameAttribute(["firstName" => $request->firstName,
                "lastName"=> $request->lastName,]),
                "phoneNumber"=> $request->phone,
                "email"=> $request->email,
                "user_id"=>$request->userid,
                "trakr_type_id"=>$request->visitor,
                "who"=> $request->who,
                "assistance"=>$request->assistance,
                "form"=>$request->form,
                "answers"=>json_encode($request->customform),
                "status"=>$request->entry,
            ]);
        return $trakr->created_at->format('H:i:s M-d-Y');
    }
    public function setUsernameAttribute($value)
    {
        $firstName = $value['firstName'];
        $lastName = strtolower($value['lastName']);

        $username = $firstName[0] . $lastName;

        $i = 0;
        while(Trakr::whereTrakrId($username)->exists())
        {
            $i++;
            $username = $firstName[0] . $lastName . $i;
        }

        return $username;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function trakrid(Request $request){
        $trakr = Trakr::where("trakr_id",$request->id)->first();
        if($trakr){
            $trakr->checked_in_status = 0;
            $trakr->check_in_date = date('Y-m-d H:i:s');
            $trakr->save();
            return response()->json(['check_in_date' => $trakr->check_in_date , 'name' => $trakr->firstName]);
        }else{
            return null;
        }
    }
    public function trakrcheckout(Request $request){
        // dd(Trakr::where("firstName",$request->fname)->where("lastName",$request->lname)->where("phoneNumber",$request->phone)->where("checked_out",null)->where("status","accepted")->get());
        $trakr = Trakr::where("firstName",$request->fname)->where("lastName",$request->lname)->where("phoneNumber",$request->phone)->where("status",0)->first();
        
        if($trakr){
            $trakr->check_out_date = date("Y-m-d H:i:s");
            $trakr->checked_in_status = 1;
            $trakr->save();
            return response()->json(['check_out_date' => $trakr->check_out_date , 'name' => $trakr->firstName]);
        }else{
            return null;    
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrakrView  $trakrView
     * @return \Illuminate\Http\Response
     */
    public function show(TrakrView $trakrView)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrakrView  $trakrView
     * @return \Illuminate\Http\Response
     */
    public function edit(TrakrView $trakrView)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrakrView  $trakrView
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrakrView $trakrView)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrakrView  $trakrView
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrakrView $trakrView)
    {
        //
    }
}

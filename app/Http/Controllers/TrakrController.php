<?php

namespace App\Http\Controllers;
use App\Models\DashBoard;
use App\Models\Trakr;
use Illuminate\Http\Request;

class TrakrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $sign_in = new DashBoard();
        $list_data = $sign_in->getdash_data();
        return view('trakrId.index',compact("list_data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("trakrId.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
        $this->validate($request, [
            'fname' => 'required|min:3|max:255',
            'lname' => 'required',
            'email' => 'required|email',
            'number' => 'required',
            'vtype' => 'required',
        ]);
        // dd($request);
        $trakrr = new Trakr;
        $trakrr->firstName = $request->fname;
        $trakrr->lastName = $request->lname;
        $trakrr->trakr_id = $this->setUsernameAttribute(["firstName" => $request->fname,"lastName"=> $request->lname]);
        $trakrr->phoneNumber = $request->number;
        $trakrr->trakr_type_id = $request->vtype;
        $trakrr->email = $request->email;
        $trakrr->user_id = auth()->user()->id;
        $trakrr->assistance = 0;
        $trakrr->status = 0;
        $trakrr->checked_in_status = 0;
        $trakrr->check_in_date = date('Y-m-d H:i:s');
        
        if ($trakrr->save()) {
            return redirect()->back();
        }
        return redirect()->back();
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
     * Display the specified resource.
     *
     * @param  \App\Models\Trakr  $trakr
     * @return \Illuminate\Http\Response
     */
    public function show(Trakr $trakr)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Trakr  $trakr
     * @return \Illuminate\Http\Response
     */
    public function edit(Trakr $trakr)
    {
        return view("trakrId.edit",compact("trakr"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trakr  $trakr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trakr $trakr)
    {
        $this->validate($request, [
            'fname' => 'required|min:3|max:255',
            'lname' => 'required',
            'email' => 'required|email',
            'number' => 'required',
            'vtype' => 'required',
        ]);
        $trakr->update([
            "firstName" => $request->fname,
            "lastName"=> $request->lname,
            "phoneNumber"=> $request->number,
            "email"=> $request->email,
            "trakr_type_id"=>$request->vtype
        ]);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Trakr  $trakr
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trakr $trakr)
    {
        $trakr->delete();
        return redirect()->back();
    }

    public function safeupdate(Request $request){
        $updating = false;
        $response = [];
        
        $this->validate($request, [
            'id' => 'required',
            'value' => 'required',
        ]);
        if($request->value == "true"){
            $updating = Trakr::where('id',$request->id)->where('user_id',auth()->user()->id)->update([
                "safe" => "safe",
                "date_marked_safe" => date('Y-m-d H:i:s')
            ]);
        }else{
            $updating = Trakr::where('id',$request->id)->where('user_id',auth()->user()->id)->update([
                "safe" => "unsafe",
                "date_marked_safe" => ""
            ]);
        }
            
        if ($updating) {
            $response['status'] = 'success';
            $response['trakr_safe'] = Trakr::select('date_marked_safe')->where('id' , $request->id)->where('user_id' , auth()->user()->id)->first();
        }
            
        return response($response);
    }
    
    public function manualSignOut(Request $request){
        $manual = Trakr::findOrFail($request->data_id);
        $manual->checked_in_status = 1;
        $manual->check_out_date = date('Y-m-d H:i:s');
        if ($manual->save()) {
            return response()->json(['status' => true] , 200);
        }
        return response()->json(['status' => false] , 200);
    }
}

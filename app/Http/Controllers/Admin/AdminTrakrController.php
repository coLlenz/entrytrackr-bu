<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\DashBoard;
use App\Models\Trakr;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class AdminTrakrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $list_data = Trakr::select('trakr_id','firstName' , 'lastName' , 'trakr_types.name' , 'trakrs.id' , 'check_in_date')
        ->where('trakr_id', '!=' , '')
        ->join('trakr_types', 'trakr_types.id', '=', 'trakrs.trakr_type_id')
        ->orderBy('trakrs.created_at' , 'DESC')
        // ->where('user_id' , auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id)
        ->paginate(10);
        return view('admin.trakrId.index',compact("list_data"));
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
    public function store(Request $request){
        
        $this->validate($request, [
            'fname' => 'required|min:3|max:255',
            'lname' => 'required',
            'trakrid' => 'required',
            'number' => 'required',
            'vtype' => 'required',
        ]);
        // dd($request);
        $trakrr = new Trakr;
        $trakrr->firstName = $request->fname;
        $trakrr->lastName = $request->lname;
        $trakrr->trakr_id = $request->trakrid;
        $trakrr->phoneNumber = $request->number;
        $trakrr->trakr_type_id = $request->vtype;
        $trakrr->user_id = auth()->user()->sub_account ? auth()->user()->sub_account_id : auth()->user()->id;
        $trakrr->assistance = 0;
        $trakrr->status = 0;
        $trakrr->checked_in_status = 0;
        $trakrr->check_in_date = date('Y-m-d H:i:s');
        
        if ($trakrr->save()) {
            return redirect('/trakrid')
            ->with('success', 'Successfully Added New TrakrID');
        }
        return redirect('/trakrid')->with('success' , 'Complete the Form');
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
        return view("admin.trakrId.edit",compact("trakr"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Trakr  $trakr
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Trakr $trakr){
        $this->validate($request, [
            'fname' => 'required|min:3|max:255',
            'lname' => 'required',
            'number' => 'required',
            'vtype' => 'required',
        ]);
        $trakr->update([
            "firstName" => $request->fname,
            "lastName"=> $request->lname,
            "phoneNumber"=> $request->number,
            "trakr_id"=> $request->trakrid,
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
        $marked_by = auth()->user()->contactName;
        
        $this->validate($request, [
            'id' => 'required',
            'value' => 'required',
        ]);
        
        if($request->value){
            $updating = Trakr::where('id',$request->id)->where('user_id',auth()->user()->id)->update([
                "safe" => "safe",
                "date_marked_safe" => Carbon::now(),
                "marked_by" => $marked_by
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
        $manual->check_out_date = Carbon::now();
        if ($manual->save()) {
            // logs
            $logs = DB::table('visitor_log')->insert([
                'visitor_id' => $manual->id ? $manual->id : null,
                'user_id' =>  $manual->user_id,
                'action' => 1,
                'created_at' => Carbon::now()
            ]);
            // end logs
            return response()->json(['status' => true] , 200);
        }
        return response()->json(['status' => false] , 200);
    }
}

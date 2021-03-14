<?php

namespace App\Http\Controllers;
use App\Models\DashBoard;
use App\Models\Trakr;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Session;
use Illuminate\Support\Facades\Validator;
class TrakrController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $list_data = Trakr::select('trakr_id','firstName' , 'lastName' , 'trakr_types.name as type' , 'trakrs.id' , 'trakrs.created_at')
        ->join('trakr_types', 'trakr_types.id', '=', 'trakrs.trakr_type_id')
        ->whereNotNull('trakr_id')
        ->where('user_id' , user_id())
        ->orderBy('trakrs.firstName' , 'ASC')
        ->paginate(50);
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
    public function store(Request $request){
        $validator = Validator::make($request->all() , [
            'fname' => 'required',
            'lname' => 'required',
            'trakrid' => 'required',
            'number' => 'required',
            'vtype' => 'required',
        ]);
       
        if (!$validator->fails()) {
            $checker = self::trakrIdCheck($request->trakrid , user_id());
        
            if ($checker) {
                Session::flash('error', 'trakrID not available.'); 
                return back()->withInput();
            }
            
            $trakrr = new Trakr;
            $trakrr->firstName = $request->fname;
            $trakrr->lastName = $request->lname;
            $trakrr->trakr_id = $request->trakrid;
            $trakrr->phoneNumber = $request->number;
            $trakrr->trakr_type_id = $request->vtype;
            $trakrr->user_id = user_id();
            $trakrr->assistance = 0;
            $trakrr->status = 0;
            $trakrr->checked_in_status = NULL;
            
            if ($trakrr->save()) {
                return redirect('/trakrid')
                ->with('success', 'Successfully Added New TrakrID');
            }
        }
        
        return back()->withInput();
    }
    
    
    function trakrIdCheck($trakr_id  , $user_id){
        
        $trakr = Trakr::where(['trakr_id' => $trakr_id , 'user_id' => $user_id])->get();
        
        if (!$trakr->isEmpty()) {
            return true;
        }
        return false;
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
    
    public function searchTrakr(Request $request){
        if (!$request->search) {
            $search = DB::table('trakrs')
            ->select('trakrs.*' , 'trakr_types.name as type')
            ->join('trakr_types', 'trakr_types.id', '=', 'trakrs.trakr_type_id')
            ->whereNotNull('trakr_id')
            ->orderBy('trakrs.created_at' , 'DESC')
            ->where('user_id' , user_id())
            ->paginate(50);
            return view('trakrId.index')->with('list_data',$search);
        }
        
        $search = DB::table('trakrs')
        ->select('trakrs.*' , 'trakr_types.name as type')
        ->join('trakr_types', 'trakr_types.id', '=', 'trakrs.trakr_type_id')
        ->orderBy('trakrs.created_at' , 'DESC')
        ->whereRaw('trakr_id IS NOT NULL')
        ->where('user_id' , user_id())
        ->where('firstName' , 'Like' , $request->search.'%')
        ->orderBy('check_in_date' , 'DESC')
        ->paginate(50);
        return view('trakrId.index')->with('list_data',$search);
    }
}

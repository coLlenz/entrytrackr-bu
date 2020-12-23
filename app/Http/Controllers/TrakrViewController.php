<?php

namespace App\Http\Controllers;

use App\Models\TrakrView;
use App\Models\Trakr;
use App\Models\Template;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class TrakrViewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('trakr.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request){
        $validator = Validator::make($request->all() , [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'email:rfc,dns',
            'visitor_type' => 'required'
        ]);
        
        if ($validator->passes()) {
            $trakr_new = new Trakr();
            
            $trakr_new->firstName = $request->first_name;
            $trakr_new->lastName = $request->last_name;
            $trakr_new->trakr_id = $request->phone;
            $trakr_new->phoneNumber = $request->phone;
            $trakr_new->email = $request->email;
            $trakr_new->trakr_type_id = $request->visitor_type;
            $trakr_new->user_id = auth()->user()->id;
            $trakr_new->status = 0;
            $trakr_new->checked_in_status = 0;
            $trakr_new->check_in_date = date('Y-m-d H:i:s');
            $formated_date = Carbon::parse($trakr_new->check_in_date)->format('d F Y g:i A');
            if ($trakr_new->save()) {
                return response()->json(
                    [
                        'status' => 'success',
                        'msg' => 'Checked-In' , 
                        'name' => $trakr_new->firstName , 
                        'check_date' => $formated_date,
                        'type_of_visitor' => $trakr_new->trakr_type_id,
                        'trakrid' => $trakr_new->id
                ],200);
            }else{
                return response()->json(['status' => 'fail','msg' => 'There\'s a problem creating your record.'],200);
            }
        }else {
            return response()->json(['status' => 'fail','validator' => $validator->errors()->all() ],200);
        }
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
        // SIMPLE CHECK IN
        $validator = Validator::make($request->all(), [
            'trakrid' => 'required',
        ]);
        
        if ($validator->passes()) {
            
            // check if logged in already
            $checking = $this->checkIfLoggedIn($request->trakrid);
            
            if (isset( $checking['is_loggedin'] ) && $checking['is_loggedin'] == 0) {
                return response()->json(['status' => 'loggedin' , 'check_date' => $this->carbonFormat($checking['check_date'])] , 200 );
            }
            
            //update status if not logged in
            $trakr = Trakr::where('trakr_id' ,$request->trakrid)->update(['checked_in_status' => 0,'check_in_date' => date('Y-m-d H:i:s')]);
            
            //get updated data
            $check_in_data = Trakr::where('trakr_id' ,$request->trakrid)->first();
            $date = $this->carbonFormat($check_in_data->check_in_date);
            return response()->json(['check_date' =>$date , 'name' => $check_in_data->firstName] , 200);
        }else{
            return response()->json(['validation_error' => $validator->errors()->all()] , 200 );
        }
    }
    
    public function trakrcheckout(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name_checkout' => 'required',
            'last_name_checkout' => 'required',
            'phoneNumber_checkout' => 'required',
        ]);
        
        if ($validator->passes()) {
            // checking user status
            $checking = $this->checkIfLoggedIn($request->phoneNumber_checkout);
            if (isset( $checking['is_loggedin'] ) && $checking['is_loggedin'] == 1) {
                return response()->json(['status' => 'loggedout' , 'check_date' => $this->carbonFormat($checking['check_out_date'])] , 200 );
            }
            
            //get user datas
            $trakr = Trakr::where([
                'firstName' => $request->first_name_checkout,
                'lastName' => $request->last_name_checkout,
                'phoneNumber' => $request->phoneNumber_checkout,
            ])->first();
            
            if (!$trakr) {
                return response()->json(['status' => 'nodata'] , 200 );
            }
            //update data to logged out
            $trakr->checked_in_status = 1;
            $trakr->check_out_date = date('Y-m-d H:i:s');
            if ($trakr->save()) {
                $updated_data = Trakr::select('check_out_date')->where('phoneNumber' , $request->phoneNumber_checkout)->first();
                return response()->json(['status' => 'success' ,'name' => $trakr->firstName ,'check_date' => $this->carbonFormat($updated_data->check_out_date)] , 200 );
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

    public function carbonFormat($date){
        return Carbon::parse($date)->format('d F Y g:i A');
    }
    
    public function checkIfLoggedIn($trakrid){
        $returndata = [];
        $check_if_loggedin = Trakr::select('checked_in_status' , 'check_in_date','check_out_date')->where('trakr_id' , $trakrid)->first();
        if ($check_if_loggedin) {
            $returndata['is_loggedin'] = $check_if_loggedin->checked_in_status;
            $returndata['check_date'] = $check_if_loggedin->check_in_date;
            $returndata['check_out_date'] = $check_if_loggedin->check_out_date;
        }
        return $check_if_loggedin ? $returndata : false;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class FeedBackController extends Controller
{
    public function getFeedBack( Request $request ){
        $feedback = DB::table('feedbacks')->insert([
            'visitor_id' => $request->input('visitor_id') ? $request->input('visitor_id') : '',
            'user_id' => $request->input('user_id') ? $request->input('user_id') : '',
            'rating' => $request->input('feedback') ? $request->input('feedback') : '',
        ]);

        return $feedback;
    }

    public function feedback(){
        $total_feedback_count = DB::table('feedbacks')->count();

        $excellent = DB::table('feedbacks')->where(['rating' => 'excellent' , 'user_id' => user_id()])->count();
        $good = DB::table('feedbacks')->where(['rating' => 'good' , 'user_id' => user_id()])->count();
        $avg = DB::table('feedbacks')->where(['rating' => 'average' , 'user_id' => user_id()])->count();
        $bad = DB::table('feedbacks')->where(['rating' => 'bad' , 'user_id' => user_id()])->count();

        $excellent = $excellent ? $excellent / $total_feedback_count * 100 : 0;
        $good = $good ? $good / $total_feedback_count * 100 : 0;
        $avg = $avg ? $avg / $total_feedback_count * 100 : 0;
        $bad = $bad ? $bad / $total_feedback_count * 100 : 0;
        
        $ratings = [
            'excellent' =>  $excellent ? number_format($excellent , 2) : 0,
            'good' => $good ?  number_format($good , 2) : 0,
            'avg' => $avg ? number_format($avg , 2) : 0,
            'bad' => $bad ? number_format($bad , 2) : 0,
        ];

        return view('report.feedback')->with('ratings' ,  $ratings);

    }
}

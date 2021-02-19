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

        $excellent = DB::table('feedbacks')->where(['rating' => 'excellent' , 'user_id' => user_id()])->count() / $total_feedback_count * 100;
        $good = DB::table('feedbacks')->where(['rating' => 'good' , 'user_id' => user_id()])->count() / $total_feedback_count * 100;
        $avg = DB::table('feedbacks')->where(['rating' => 'average' , 'user_id' => user_id()])->count() / $total_feedback_count * 100;
        $bad = DB::table('feedbacks')->where(['rating' => 'bad' , 'user_id' => user_id()])->count() / $total_feedback_count * 100;

        $ratings = [
            'excellent' =>  $excellent,
            'good' => $good,
            'avg' => $avg,
            'bad' => $bad
        ];

        return view('report.feedback')->with('ratings' ,  $ratings);

    }
}

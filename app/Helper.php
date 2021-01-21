<?php
use Carbon\Carbon;

function get_local_time($date_ , $user_ip){
    $date = Carbon::createFromFormat('Y-m-d H:i:s',$date_);
    
    if ($user_ip == '127.0.0.1') {
        $user_ip = file_get_contents("http://ipecho.net/plain");
    }
    $url = 'http://ip-api.com/json/'.$user_ip;
    $tz = file_get_contents($url);

    $timezone = json_decode($tz,true)['timezone'];
    
    $date->setTimezone( Auth::check() ? auth()->user()->timezone : $timezone);
    
    return $date;
}

function userTz(){
    return auth()->user()->timezone ? auth()->user()->timezone : 'UTC';
}
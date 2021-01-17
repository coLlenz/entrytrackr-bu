<?php 

namespace App\EntryHelper;

class Helper{
    public function test(){
        echo "<pre>";
            print_r(auth()->user());
        echo "</pre>";
        exit();
    }
}

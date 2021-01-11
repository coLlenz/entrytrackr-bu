<?php

namespace App\Console\Commands;

use App\Models\Trakr;
use Illuminate\Console\Command;

class SignOutAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signout:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Trakr $trakr)
    {
        $signIn = Trakr::where('checked_in_status', '0')
        ->update(['checked_in_status' => 1, 'check_out_date' => date('Y-m-d H:i:s')]);
        return $signIn;
    }
}

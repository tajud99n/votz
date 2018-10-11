<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PollStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'status:poll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Poll status';

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
     * @return mixed
     */
    public function handle()
    {
        // Update voting status
        date_default_timezone_set("Africa/Lagos");

        DB::table('polls')
            ->where('deadline','<=', date('Y-m-d H:i'))
            ->update(['voting_status' => 'concluded']);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use DB;

class HeyCommunityDatabaseClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'HeyCommunity:database-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear the database data';

    protected $tables = [
        'admins',
        'systems',
        'topic_nodes',
        'notice_types',
    ];

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
        if (!$this->confirm('Are you sure you want to continue? [Y|N]')) {
            $this->info('exit');
            exit;
        }

        //
        Artisan::call('migrate:refresh');

        foreach ($this->tables as $table) {
            DB::table($table)->delete();
        }

        $this->info('database clear successful!');
    }
}

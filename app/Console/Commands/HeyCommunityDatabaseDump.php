<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

use Excel;
use DB;

class HeyCommunityDatabaseDump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'HeyCommunity:database-dump';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export the database data';

    /**
     *
     */
    protected $excel;

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
        $this->info('dumping ...');

        $this->excel = Excel::create('HeyCommunityData-' . date('Ymdhis'), function($excel) {});

        $this->dumpTable('Admin');
        $this->dumpTable('System');
        $this->dumpTable('User');
        $this->dumpTable('Timeline');
        $this->dumpTable('TimelineImg');
        $this->dumpTable('TimelineVideo');
        $this->dumpTable('TimelineLike');
        $this->dumpTable('TimelineComment');
        $this->dumpTable('TopicNode');
        $this->dumpTable('Topic');
        $this->dumpTable('TopicComment');
        $this->dumpTable('TopicStar');
        $this->dumpTable('TopicThumb');
        $this->dumpTable('NoticeType');
        $this->dumpTable('Notice');

        $this->excel->store('xls');

        $this->info('dump successful');
    }

    /**
     *
     */
    public function dumpTable($sheetTitle)
    {
        $dataNum = 0;
        $this->excel->sheet($sheetTitle, function($sheet) use (&$dataNum) {
            $tableName = str_plural(snake_case($sheet->getTitle()));
            $data = DB::table($tableName)->get();
            $data = json_decode(json_encode($data), true);
            $sheet->fromArray($data, null, 'A1', true);
            $dataNum = count($data);
        });

        // export
        $str = ' - dump ' . $sheetTitle;
        $i = floor(strlen($str) / 8);
        for ($i; $i < 6; $i++) {
            $str .= "\t";
        }
        $str .= $dataNum;
        $this->info($str);
    }
}

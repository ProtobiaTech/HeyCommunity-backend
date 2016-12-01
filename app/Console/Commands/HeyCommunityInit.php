<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class HeyCommunityInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'heyCommunity:init';

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
     * @return mixed
     */
    public function handle()
    {
        Model::unguard();


        //
        //
        \App\Admin::create([
            'nickname'          =>  env('ADMIN_NICKNAME', 'Admin'),
            'email'             =>  env('ADMIN_EMAIL', 'admin@hey-community.com'),
            'password'          =>  bcrypt(env('ADMIN_PASSWORD', 'hey community')),
        ]);

        //
        //
        \App\System::create([
            'id'                =>  1,
            'community_name'    =>  env('COMMUNITY_NAME', 'New Community'),
        ]);

        //
        //
        $noticeTypes = [
            ['id' => 10, 'name' => 'timeline_like'],
            ['id' => 11, 'name' => 'timeline_comment'],
            ['id' => 12, 'name' => 'timeline_comment_comment'],

            ['id' => 20, 'name' => 'topic_like'],
            ['id' => 21, 'name' => 'topic_comment'],
            ['id' => 22, 'name' => 'topic_comment_comment'],
        ];
        foreach ($noticeTypes as $type) {
            \App\NoticeType::create([
                'id'        =>      $type['id'],
                'name'      =>      $type['name'],
            ]);
        }

        //
        //
        $node = \App\TopicNode::create([
            'name'      =>      env('LOCALE') === 'zh-CN' ? '默认' : 'Default',
        ]);
        $node->makeRoot();


        Model::reguard();
    }
}

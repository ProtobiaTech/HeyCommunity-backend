<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\User;
use App\Timeline;
use App\TimelineImg;
use App\TimelineLike;
use App\TimelineComment;

class MigrateToV2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrateToV2';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'migrate v1 to v2';

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
        //
        //
        User::insert($this->getDatas(User::on('heyCommunity_v1')->withTrashed()->get(), [
            'id',
            'wx_open_id',
            'nickname',
            'avatar',
            'phone',
            'email',
            'password',
            'is_admin',
            'remember_token',
            'deleted_at',
            'created_at',
            'updated_at',
            'bio'       =>  null,
            'gender'    =>  null,
        ]));


        //
        //
        Timeline::insert($this->getDatas(Timeline::on('heyCommunity_v1')->withTrashed()->get(), [
             'id',
             'user_id',
             'content',
             'imgs' => 'field:attachment',
             'like_num',
             'view_num'     =>  null,
             'comment_num',
             'deleted_at',
             'created_at',
             'updated_at',
        ]));


        //
        //
        $timelines = Timeline::withTrashed()->get();
        foreach ($timelines as $timeline) {
            $timelineImg = new TimelineImg();
            $timelineImg->user_id   =   $timeline->user_id;
            $timelineImg->uri        =   $timeline->imgs;
            $timelineImg->save();

            $timeline->imgs = json_encode([$timelineImg->id]);
            $timeline->save();
        }


        //
        //
        TimelineLike::insert($this->getDatas(TimelineLike::on('heyCommunity_v1')->withTrashed()->get(), [
             'id',
             'user_id',
             'timeline_id',
             'deleted_at',
             'created_at',
             'updated_at',
        ]));


        //
        //
        TimelineComment::insert($this->getDatas(TimelineLike::on('heyCommunity_v1')->withTrashed()->get(), [
             'id',
             'user_id',
             'timeline_id',
             'parent_id',
             'content',
             'deleted_at',
             'created_at',
             'updated_at',
        ]));
    }

    /**
     * get datas
     *
     * @params array $models
     * @param array $fields, like ['filed', 'filedNew' => 'filed:filedOld', 'filedNew' => 'value']
     */
    public function getDatas($models, $fields)
    {
        $datas = [];
        foreach ($models as $k => $model) {
            foreach ($fields as $fieldNew => $fieldOld) {
                if (is_integer($fieldNew)) {
                    $datas[$k][$fieldOld] = $model->$fieldOld;
                } else {
                    if (substr($fieldOld, 0, 6) === 'field:') {
                        $field = substr($fieldOld, 6);
                        $datas[$k][$fieldNew] = $model->$field;
                    } else {
                        $datas[$k][$fieldNew] = $fieldOld;
                    }
                }
            }
        }
        return $datas;
    }
}

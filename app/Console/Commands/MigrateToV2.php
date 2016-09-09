<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Tenant;
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

    protected $tenants = [2, 14, 30];

    protected $users = [4, 15, 28, 39, 40, 43, 61, 62];

    protected $timelines = [];
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
        Tenant::insert($this->getDatas(Tenant::on('heyCommunity_v1')->withTrashed()->whereIn('id', $this->tenants)->get(), [
            'id',
            'site_name',
            'domain',
            'sub_domain',
            'email',
            'phone',
            'password',
            'remember_token',
            'deleted_at',
            'created_at',
            'updated_at',
        ]));


        //
        //
        User::insert($this->getDatas(User::on('heyCommunity_v1')->withTrashed()->whereIn('id', $this->users)->get(), [
            'id',
            'tenant_id' => 'value:30',
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


        $users = [
            ['user_id' => 4, 'tenant_id' => 2],
            ['user_id' => 15, 'tenant_id' => 2],
            ['user_id' => 28, 'tenant_id' => 2],
            ['user_id' => 61, 'tenant_id' => 2],
            ['user_id' => 62, 'tenant_id' => 2],
            ['user_id' => 39, 'tenant_id' => 14],
            ['user_id' => 40, 'tenant_id' => 14],
            ['user_id' => 43, 'tenant_id' => 14],
        ];
        foreach ($users as $user) {
            $User = User::findOrFail($user['user_id']);
            $User->tenant_id = $user['tenant_id'];
            $User->save();
        }

        Model::unguard();
        User::where('id', 61)->update(['tenant_id' => 30]);
        // User::where('id', '>', 0)->update(['wx_open_id' => null, 'phone' => null]);
        Model::reguard();


        //
        //
        Timeline::insert($this->getDatas(Timeline::on('heyCommunity_v1')->withTrashed()->whereIn('user_id', $this->users)->whereIn('tenant_id', $this->tenants)->get(), [
            'id',
            'tenant_id',
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
        $this->timelines = Timeline::whereIn('user_id', $this->users)->whereIn('tenant_id', $this->tenants)->get()->lists('id');


        //
        //
        $timelines = Timeline::withTrashed()->get();
        foreach ($timelines as $timeline) {
            if ($timeline->imgs) {
                $timelineImg = new TimelineImg();
                $timelineImg->user_id       =   $timeline->user_id;
                $timelineImg->tenant_id =   $timeline->tenant_id;
                $timelineImg->timeline_id   =   $timeline->id;
                $timelineImg->uri           =   $timeline->imgs;
                $timelineImg->save();

                $timeline->imgs = json_encode([$timelineImg->id]);
                $timeline->save();
            } else {
                continue;
            }
        }
        Model::unguard();
        Timeline::withTrashed()->where('tenant_id', '2')->whereIn('user_id', [61, 62])->update(['user_id' => 4]);
        Timeline::withTrashed()->where('tenant_id', '30')->whereIn('user_id', [62, 4])->update(['user_id' => 61]);
        Timeline::withTrashed()->where('tenant_id', '14')->whereIn('user_id', [61, 62, 4])->update(['user_id' => 39]);

        TimelineImg::withTrashed()->where('tenant_id', '2')->whereIn('user_id', [61, 62])->update(['user_id' => 4]);
        TimelineImg::withTrashed()->where('tenant_id', '30')->whereIn('user_id', [62, 4])->update(['user_id' => 61]);
        TimelineImg::withTrashed()->where('tenant_id', '14')->whereIn('user_id', [61, 62, 4])->update(['user_id' => 39]);
        Model::reguard();


        //
        //
        TimelineLike::insert($this->getDatas(TimelineLike::on('heyCommunity_v1')->withTrashed()->where('timeline_id', $this->timelines)->whereIn('timeline_id', $this->timelines)->whereIn('user_id', $this->users)->whereIn('tenant_id', $this->tenants)->get(), [
            'id',
            'tenant_id',
            'user_id',
            'timeline_id',
            'deleted_at',
            'created_at',
            'updated_at',
        ]));
        Model::unguard();
        TimelineLike::withTrashed()->where('tenant_id', '2')->whereIn('user_id', [61, 62])->update(['user_id' => 4]);
        TimelineLike::withTrashed()->where('tenant_id', '30')->whereIn('user_id', [62, 4])->update(['user_id' => 61]);
        TimelineLike::withTrashed()->where('tenant_id', '14')->whereIn('user_id', [61, 62, 4])->update(['user_id' => 39]);
        Model::reguard();


        //
        //
        TimelineComment::insert($this->getDatas(TimelineComment::on('heyCommunity_v1')->withTrashed()->whereIn('user_id', $this->users)->whereIn('tenant_id', $this->tenants)->get(), [
            'id',
            'tenant_id',
            'user_id',
            'timeline_id',
            'parent_id',
            'content',
            'deleted_at',
            'created_at',
            'updated_at',
        ]));
        Model::unguard();
        TimelineComment::withTrashed()->where('tenant_id', '2')->whereIn('user_id', [61, 62])->update(['user_id' => 4]);
        TimelineComment::withTrashed()->where('tenant_id', '30')->whereIn('user_id', [62, 4])->update(['user_id' => 61]);
        TimelineComment::withTrashed()->where('tenant_id', '14')->whereIn('user_id', [61, 62, 4])->update(['user_id' => 39]);
        Model::reguard();
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
                    } else if (substr($fieldOld, 0, 6) === 'value:') {
                        $value = substr($fieldOld, 6);
                        $datas[$k][$fieldNew] = $value;
                    } else {
                        $datas[$k][$fieldNew] = $fieldOld;
                    }
                }
            }
        }
        return $datas;
    }
}

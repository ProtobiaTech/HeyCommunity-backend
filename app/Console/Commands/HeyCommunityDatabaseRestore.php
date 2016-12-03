<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Excel;

class HeyCommunityDatabaseRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'HeyCommunity:database-restore {file : the excel file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import the database data';

    /**
     *
     */
    protected $excel;

    protected $UserTableFields = [
        'wx_open_id', 'nickname', 'avatar', 'bio', 'gender', 'email', 'phone', 'password', 'is_admin', 'remember_token',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $AdminTableFields = [
        'nickname', 'email', 'password', 'remember_token',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $SystemTableFields = [
        'community_name', 'enable_wechat_pa', 'wx_app_id', 'wx_app_secret', 'wx_temp_notice_id',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $NoticeTypeTableFields = [
        'name',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $NoticeTableFields = [
        'user_id', 'initiator_user_id', 'entity_id', 'entity_type', 'type_id', 'is_checked', 'target_id', 'target_type',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TimelineTableFields = [
        'user_id', 'content', 'imgs', 'video', 'poster',
        'like_num', 'view_num', 'comment_num',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TimelineImgTableFields = [
        'user_id', 'timeline_id', 'uri',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TimelineVideoTableFields = [
        'user_id', 'timeline_id', 'uri', 'poster',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TimelineLikesTableFields = [
        'user_id', 'timeline_id',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TimelineCommentTableFields = [
        'user_id', 'timeline_id', 'parent_id', 'content',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TopicTableFields = [
        'user_id', 'topic_node_id', 'title', 'content',
        'star_num', 'thumb_up_num', 'thumb_down_num', 'view_num', 'comment_num',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TopicNodeTableFields = [
        'name', 'description', 'parent_id', 'lft', 'rgt', 'depth',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TopicStarTableFields = [
        'user_id', 'topic_id',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TopicThumbTableFields = [
        'user_id', 'topic_id', 'value',
        'id', 'deleted_at', 'created_at', 'updated_at',
    ];

    protected $TopicCommentTableFields = [
        'user_id', 'topic_id', 'parent_id', 'content',
        'id', 'deleted_at', 'created_at', 'updated_at',
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

        $this->info('restoring ...');

        $excelFile = $this->argument('file');
        $this->excel = Excel::load($excelFile, function($reader) {});

        $data = $this->excel->get();
        foreach ($data as $table) {
            $sheetTitle = $table->getTitle();
            $modelName = '\\App\\' . $sheetTitle;
            $model = new $modelName;

            $ret = $this->getData($table->toArray(), $sheetTitle);
            $data = $ret['data'];
            $state = $ret['state'];
            $model->insert($data);

            // export
            $str = ' - restore ' . $sheetTitle;
            $i = floor(strlen($str) / 8);
            for ($i; $i < 6; $i++) {
                $str .= "\t";
            }
            $str .= count($data);
            $this->info($str);
        }

        $this->info('restore successful');
    }

    /**
     *
     */
    public function getData($data, $tableName)
    {
        $theFields = $tableName . 'TableFields';

        $state = null;
        $newData = [];

        foreach ($data as $field => $value) {
            $newData[$field] = $value;
        }

        if (isset($this->$theFields)) {
            $fields = $this->$theFields;
            foreach ($data as $k => $v) {
                foreach ($fields as $oldField => $newField) {
                    if (is_integer($oldField)) {
                        $newData[$k][$newField] = $v[$newField];
                    } else {
                        if (substr($newField, 0, 6) === 'field:') {
                            $field = substr($newField, 6);
                            $newData[$k][$field] = $v[$oldField];
                        } else if (substr($newField, 0, 6) === 'value:') {
                            $value = substr($newField, 6);
                            $newData[$k][$oldField] = $value;
                        } else if ($newField === null) {
                            //
                        } else {
                            //
                        }
                    }
                }
            }
            $state = 'ok';
        } else {
            $state = 'skip';
        }

        return ['data' => $newData, 'state' => $state];
    }
}

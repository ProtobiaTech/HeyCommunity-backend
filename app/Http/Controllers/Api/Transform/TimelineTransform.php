<?php
namespace App\Http\Controllers\Api\Transform;

use App\Timeline;
use League\Fractal\TransformerAbstract;

class TimelineTransform extends TransformerAbstract
{
    public function transform(Timeline $timeline)
    {
        // add what you need here
        return [
            'content'           => $timeline->content,
            'imgs'              => $timeline->imgs,
            'like_num'          => $timeline->like_num,
            'view_num'          => $timeline->view_num,
            'is_like'           => $timeline->is_like,
        ];
    }
}

<?php

namespace App\Filters;

trait TopicFilters
{

    public function getTopicsWithFilter($filter, $limit = 20)
    {
        $filter = $this->getTopicFilter($filter);

        return $this->applyFilter($filter)->paginate($limit);
    }

    public function getTopicFilter($requestFilter)
    {
        $filters = ['noreply', 'hot', 'excellent','recent'];
        if (in_array($requestFilter, $filters)) {
            return $requestFilter;
        }
        return 'default';
    }

    public function applyFilter($filter)
    {
        switch ($filter) {
            case 'noreply':
                return $this->where('comment_num', 0)->recent();
                break;
            case 'hot':
                return $this->orderBy('comment_num', 'desc')->recent();
                break;
            case 'excellent':
                return $this->orderBy('star_num', 'desc')->recent();
                break;
            default:
                return $this->recent();
        }
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}

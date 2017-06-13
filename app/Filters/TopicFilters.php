<?php

namespace App\Filters;

trait TopicFilters
{
    /**
     * @param $filter
     * @param int $limit
     * @return
     */
    public function getTopicsWithFilter($filter, $limit = 20)
    {
        $filter = $this->getTopicFilter($filter);

        return $this->applyFilter($filter)->paginate($limit);
    }

    /**
     * @param $requestFilter
     * @return string
     */
    public function getTopicFilter($requestFilter)
    {
        $filters = ['noreply', 'hot', 'excellent','recent'];
        if (in_array($requestFilter, $filters)) {
            return $requestFilter;
        }
        return 'default';
    }

    /**
     * @param $filter
     * @return
     */
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}

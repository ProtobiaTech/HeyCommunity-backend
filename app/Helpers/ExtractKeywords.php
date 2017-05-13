<?php

namespace App\Helpers;

use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\JiebaAnalyse;

class ExtractKeywords
{
    const TOP_K    = 10;

    public static function getKeywords($content)
    {
        Jieba::init();
        Finalseg::init();
        JiebaAnalyse::init();

        $keywords   = JiebaAnalyse::extractTags($content, self::TOP_K);

        return $keywords;
    }
}

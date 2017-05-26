<?php

namespace App\Helpers;

use Fukuball\Jieba\Jieba;
use Fukuball\Jieba\Finalseg;
use Fukuball\Jieba\JiebaAnalyse;

class ExtractKeywords
{
    public static function getKeywords($content, $topK = 10)
    {
        Jieba::init();
        Finalseg::init();
        JiebaAnalyse::init();

        return JiebaAnalyse::extractTags($content, $topK);
    }
}




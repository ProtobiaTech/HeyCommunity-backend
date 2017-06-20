<?php

function ss($data, $message = null)
{
    return [
        'status'    =>      'successful',
        'code'      =>      '200',
        'data'      =>      $data,
        'message'   =>      $message,
    ];
}

function ee($data, $code = 500, $message = null)
{
    return [
        'status'    =>      'failed',
        'code'      =>      $code,
        'data'      =>      $data,
        'message'   =>      $message,
    ];
}

<?php

namespace app\common;

class Web
{
    static public function error_out($code, $message)
    {
        $result = array();
        $result['code'] = $code;
        $result['message'] = $message;
        return json_encode($result);
    }
}

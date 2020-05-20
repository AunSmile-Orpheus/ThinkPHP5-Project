<?php

namespace app\common\functional;

class Web
{
    static public function error_out($code, $message)
    {
        $result = array();
        $result['code'] = $code;
        $result['message'] = $message;
        return json_encode($result);
    }
    static public function version()
    {
    	$result = array();
	$result['version'] = '1.0.0';
	return json_encode($result);
    }
}

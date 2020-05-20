<?php

namespace app\common\functional;
use think\Db;

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
    static public function check_auth($privilege, $openid)
    {
        $user_data = Db::table('tb_user')->where('openid', $openid)->find();
        $type = $user_data['type'];
        return ($privilege & (1 << $type)) == (1 << $type);
    }

    static public function priv($priv0, $priv1, $priv2)
    {
        return $priv0 + ($priv1 << 1) + ($priv2 << 2);
    }
}

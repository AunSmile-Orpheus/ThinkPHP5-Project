<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
use think\Db;
use app\common\functional\Web;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class User
{
        static function rand_str()
        {
                $rand_array = "ABCDEFGHIJKLMNOPQRSTOVWSYZabcdefghijklmnopqrstovwsyz1234567890";
                $ret = '';
                for ($i = 0; $i != 15; $i = $i + 1)
                        $ret = $ret . $rand_array[rand(0, strlen($rand_array) - 1)];
                return $ret;
        }
        static function get_type($type)
        {
                if ($type == '学生')
                        return 0;
                else if ($type == '老师')
                        return 1;
                else
                        return 2;
        }
	public function login()
        {
                $request = new Request;
                $username = $request->param('username');
                $password = $request->param('password');
                $type = User::get_type($request->param('type'));

                $user_data = Db::table('tb_user')->where('username', $username)->find();

                if ($password != $user_data['password']) {
                        return Web::error_out(1, "密码错误");
                } else if ($type != $user_data['type']) {
                        return Web::error_out(2, "用户身份不匹配");
                }

                $result = ['code' => 0, 'openid' => $user_data['openid'] ];
                return json_encode($result);
        }

        public function register()
        {
                $request = new Request;
                $username = $request->param('username');
                $password = $request->param('password');
                $type = User::get_type($request->param('type'));
                $data = [
                        'username' => $username,
                        'password' => $password,
                        'type' => $type,
                        'openid' => User::rand_str()
                ];
                Db::name('tb_user')->data($data)->insert();
		//如果是教师账户的注册则在教师表内添加教师数据
		if($type == 1){
			Db::name('tb_teacher')->data(['openid' => $data['openid'], 'username' => 'not named'])->insert();
		}
                $result = array('code' => 0);
                return json_encode($result);
        }
		
		public function query()
		{
			$request = new Request;
			//鉴权
			$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
			if($ret == false)
					return Web::error_out(1, "鉴权失败");
			
			
			$data = Db::table('tb_user')->select();
			return json_encode(['code'=>0, '$data'=>$data]);
		}
		
		public function remove()
		{
			$request = new Request;
			//鉴权
			$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
			if($ret == false)
					return Web::error_out(1, "鉴权失败");
			$username = $request->param('username');
			$data = Db::table('tb_user')->where('username', $username)->delete();
		}
}
?>

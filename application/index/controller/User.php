<?php
namespace app\index\controller;
use think\Request;
use think\Controller;
use think\Db;


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class User
{
    public function index()
    {
	    return 'abcdef';
    }
    static function rand_str()
    {
    	$rand_array = "ABCDEFGHIJKLMNOPQRSTOVWSYZabcdefghijklmnopqrstovwsyz1234567890";
	$ret = '';
	for($i = 0; $i != 15;$i = $i + 1)
		$ret = $ret.$rand_array[rand(0,strlen($rand_array) - 1)];
	return $ret;
    }
    static function get_type($type)
    {
   	if($type == '学生') 
		return 0;
	else if($type == '老师')
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

	$user_data = Db::table('tb_user')->where('username',$username)->find();

	$result = array();

	if($password != $user_data['password'])
	{
		$result['code'] = 1;
		$result['message'] = "密码错误";
	}
	else if($type != $user_data['type'])
	{
		$result['code']= 2;
		$result['message'] = "用户身份不匹配";
	}
	else
	{
		$result['code'] = 0;
		$result['openid'] = $user_data['openid'];
	}

	return json_encode($result);
}

    public function register()
    {
	$request = new Request;
	$username = $request->param('username');
	$password = $request->param('password');
	$type = User::get_type($request->param('type'));
	$data = ['username' => $username, 
		'password' => $password,
		'type'=>$type,
		'openid'=>User::rand_str()];
	Db::name('tb_user')->data($data)->insert();

	$result=array('code'=>0);
	return json_encode($result);
    }
    
}

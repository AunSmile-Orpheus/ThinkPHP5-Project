<?php
namespace app\index\controller;
use think\Request;
use think\Controller;

class Test
{
    public function index()
    {
	    return 'abcdef';
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    public function api()
    {
	    $request = new Request;
	    //$username = $this->request->param('username');
	    $username = $request->param('username');
	    $result=array('code'=>0, 'msg'=>'ok', 'username'=>$username);
	    return json_encode($result);
    }
}

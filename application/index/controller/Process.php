<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
use think\Db;
use app\common\functional\Web;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class Process
{
    //查询专业名，如果没有专业名就是遍历
    public function search()
    {
        $request = new Request;
        //鉴权
        $ret = Web::check_auth(Web::priv(1, 1, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
			
		$process_list = Db::table('tb_process')->select();
		
		return json_encode(['code'=>0, 'process_list'=>$process_list]);
    }

    //根据专业ID查看专业详细信息
    public function detail()
    {
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(1, 1, 1), $request->param('openid'));
		if($ret == false)
				return Web::error_out(1, "鉴权失败");
		
		$id = $request->param('process_id');
		
		$data = Db::table('tb_process')->where('process_id', $id)->find();
		return json_encode(['code'=>0, '$data'=>$data]);
    }
	
	//添加专业
	public function insert()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
		
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
		
		$data = array();
		$data['name'] = $request->param('name');
		$data['content'] = $request->param('content');
		$data['jobs'] = $request->param('jobs');
		
		Db::table('tb_process')->data($data)->insert();
		
		return json_encode(['code'=>0]);
	}
	
	//删除专业
	public function remove()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
		
		$process_id = $request->param('process_id');
		Db::table('tb_process')->where('process_id',$process_id)->delete();
		return json_encode(['code'=>0]);
	}

	//修改专业
	public function update()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
        if($ret == false)
			return Web::error_out(1, "鉴权失败");
		
		$data = array();
		$data['process_id'] = $request->param('process_id');
		if($request->param('name') != NULL)
			$data['name'] = $request->param('name');
		if($request->param('content') != NULL)
			$data['content'] = $request->param('content');
		if($request->param('jobs') != NULL)
			$data['jobs'] = $request->param('jobs');
		
		Db::table('tb_process')->data($data)->update();
		return json_encode(['code'=>0]);
	}
}
?>                        

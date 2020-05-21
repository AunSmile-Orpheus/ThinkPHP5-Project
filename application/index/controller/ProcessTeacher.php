<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
use think\Db;
use app\common\functional\Web;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class Processteacher
{
    //根据专业ID查看专业教师列表
    public function query()
    {
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(1, 1, 1), $request->param('openid'));
		if($ret == false)
				return Web::error_out(1, "鉴权失败");
		
		$process_id = $request->param('process_id');
		$teacher_list = Db::table('tb_process_teacher')
			->alias('pt')
			->join('tb_teacher t','pt.teacher_id = t.teacher_id')
			->where('process_id', $process_id)
			->select();
		
		return json_encode(['code'=>0, '$teacher_list'=>$teacher_list]);
    }

    //添加专业教师视图
	public function insert_view()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
		if($ret == false)
				return Web::error_out(1, "鉴权失败");
		
		$teacher_list = Db::table('tb_teacher') -> select();
		return json_encode(['code'=>0, 'teacher_list', $teacher_list]);
	}
	
	//添加专业教师
	public function insert()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
		if($ret == false)
			return Web::error_out(1, "鉴权失败");
		
		$data = array();
		$data['teacher_id'] = $request->param('teacher_id');
		if(Db::table('tb_teacher')->where('teacher_id',$data['teacher_id'])->find() == NULL)
		{
			return Web::error_out(2, "无该教师信息");
		}
		$data['process_id'] = $request->param('process_id');
		if(Db::table('tb_process')->where('process_id',$data['process_id'])->find() == NULL)
			return Web::error_out(3, "无该专业信息");

		Db::table('tb_process_teacher')->data($data)->insert();
	}
	
	//删除专业教师
	public function remove()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
		
		$process_id = $request->param('process_id');
		$teacher_id = $request->param('teacher_id');
		
		Db::table('tb_process_teacher')->where('process_id',$process_id)->where('teacher_id',$teacher_id)->delete();
		return json_encode(['code'=>0]);
	}
}
?>                        

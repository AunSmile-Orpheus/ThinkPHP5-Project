<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
use think\Db;
use app\common\functional\Web;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class Course
{
    //查询课程名，如果没有课程名就是遍历
    public function search()
    {
        $request = new Request;
        //鉴权
        $ret = Web::check_auth(Web::priv(1, 1, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
		$course_name = $request->param('course_name');
        $course_list = Db::table('tb_course')
		->alias('c')
		->join('tb_teacher t','c.teacher_id = t.teacher_id')
		->join('tb_process p','c.process_id = p.process_id')
		->where('cname', 'like', '%'.$course_name.'%')
		->select();
	    
		return json_encode(['code'=>0, 'course_list'=>$course_list]);
    }

    //根据课程ID查看课程详细信息
    public function detail()
    {
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(1, 1, 1), $request->param('openid'));
		if($ret == false)
				return Web::error_out(1, "鉴权失败");
		
		$course_id = $request->param('course_id');
		$course_data = Db::table('tb_course')
			->alias('c')
			->join('tb_teacher t','c.teacher_id = t.teacher_id')
			->join('tb_process p','c.process_id = p.process_id')
			->where('id', $course_id)
			->find();
		return json_encode(['code'=>0, '$course_data'=>$course_data]);
    }
	
	//添加视图（需要教师的信息）
	public function insert_view()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 1, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
		
		$teacher_list = Db::table('tb_teacher')->select();
		$process_list = Db::table('tb_process')->select();
		
		return json_encode(['code'=>0, 
							'teacher_list'=>$teacher_list, 
							'process_list'=>$process_list]);
	}
	
	//添加课程
	public function insert()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 1, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
		if(Db::table('tb_teacher') -> where('teacher_id', $request->param('teacher_id')) -> find() == NULL)
			return Web::error_out(2, "无教师信息");
		if(Db::table('tb_process') -> where('process_id', $request->param('process_id')) -> find() == NULL)
			return Web::error_out(3, "无专业信息");
		
		$course_data = array();
		$course_data['cname'] = $request->param('course_name');
		$course_data['grade'] = $request->param('grade');
		$course_data['stu_time'] = $request->param('stu_time');
		$course_data['teacher_id'] = $request->param('teacher_id');
		$course_data['process_id'] = $request->param('process_id');
		Db::table('tb_course')->data($course_data)->insert();
		
		return json_encode(['code'=>0]);
	}
	//修改课程
	public function update()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 1, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
	}
	//删除课程
	public function remove()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 1, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
	}
}
?>                                                                                                                            

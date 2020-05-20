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
		->where('id', $course_id)
		->find();
	return json_encode(['code'=>0, '$course_data'=>$course_data]);
    }
}
?>

<?php



namespace app\index\controller;



use think\Request;

use think\Controller;

use think\Db;

use app\common\functional\Web;



header('Access-Control-Allow-Origin:*');

header('Access-Control-Allow-Methods:*');

header('Access-Control-Allow-Headers:x-requested-with,content-type');



class Processcourse

{

    //根据专业ID查看专业课程(含学期)列表
    public function query()
    {
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(1, 1, 1), $request->param('openid'));

		if($ret == false)
			return Web::error_out(1, "鉴权失败");

		$process_id = $request->param('process_id');

		$course_list = Db::table('tb_process_course')
			->alias('pc')
			->join('tb_course t','pc.process_id = t.process_id')
			->where('process_id', $process_id)
			->order(array('term_index' => 'asc'))
			->select();
		

		return json_encode(['code'=>0, '$course_list'=>$course_list]);

    }

    //添加专业课程视图
	public function insert_view()
	{
		$request = new Request;
		
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
		if($ret == false)
			return Web::error_out(1, "鉴权失败");
		
		$process_id = $request->param('process_id')
		$course_list = Db::table('tb_course') -> where('process_id', $process_id) -> select();

		return json_encode(['code'=>0, 'course_list', $course_list]);
	}

	//添加专业课程
	public function insert()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));

		if($ret == false)
			return Web::error_out(1, "鉴权失败");
		
		$data = array();
		$data['process_id'] = $request->param('process_id');
		$data['term_index'] = $request->param('teacher_id');
		$data['course_id'] = $request->param('course_id');

		if(Db::table('tb_process')->where('process_id',$data['process_id'])->find() == NULL)
		{
			return Web::error_out(2, "无该专业信息");
		}
		$course_data = Db::table('tb_course')->where('id', $data['course_id'])->find();
		if($course_data == NULL)
		{
			return Web::error_out(3, "无该课程信息");
		}
		if($course_data['process_id'] != $data['process_id'])
		{
			return Web::error_out(4, "该课程不属于这一专业");
		}
		if($data['term_index'] > 8)
		{
			return Web::error_out(5, "学期必须在[0,7]范围内");
		}
		
		Db::table('tb_process_course')->data($data)->insert();
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
		$course_id = $request->param('course_id');

		Db::table('tb_process_course')->where('process_id',$process_id)->where('course_id',$course_id)->delete();

		return json_encode(['code'=>0]);

	}

}

?>                  

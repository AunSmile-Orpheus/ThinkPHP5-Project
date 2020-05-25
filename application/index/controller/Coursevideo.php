<?php



namespace app\index\controller;



use think\Request;

use think\Controller;

use think\Db;

use app\common\functional\Web;



header('Access-Control-Allow-Origin:*');

header('Access-Control-Allow-Methods:*');

header('Access-Control-Allow-Headers:x-requested-with,content-type');



class Coursevideo

{

    //根据课程ID查看课程课件
    public function query()
    {
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(1, 1, 1), $request->param('openid'));

		if($ret == false)
			return Web::error_out(1, "鉴权失败");

		$course_id = $request->param('course_id');

		$video_list = Db::table('tb_course_video')
			->where('course_id', $course_id)
			->order(array('order_index'=>order_index))
			->select();

		return json_encode(['code'=>0, '$video_list'=>$video_list]);

    }

	//添加视频
	public function insert()
	{
		$request = new Request;
		
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 1, 1), $request->param('openid'));
		
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
		
		$data = array();
		$data['name'] = $request->param('name');
		$data['course_id'] = $request->param('course_id');
		$data['order_index'] = $request->param('order_index');
		
		$file = $request->file('video_file');
		$info = $file->move( '../video/');
		if($info){
			$data['video_addr'] = $info->getSaveName();
		}else{
			return Web::error_out(2, $file->getError());
		}
		Db::table('tb_course_video')->data($data)->insert();
		
		return json_encode(['code'=>0]);
	}

	//删除视频
	public function remove()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 1, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");

		$id = $request->param('id');

		Db::table('tb_course_video')->where('id',$id)->delete();

		return json_encode(['code'=>0]);

	}

}

?>                  

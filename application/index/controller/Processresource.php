<?php



namespace app\index\controller;



use think\Request;

use think\Controller;

use think\Db;

use app\common\functional\Web;



header('Access-Control-Allow-Origin:*');

header('Access-Control-Allow-Methods:*');

header('Access-Control-Allow-Headers:x-requested-with,content-type');



class Processresource

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

		$resource_list = Db::table('tb_course_resource')
			->where('course_id', $course_id)
			->select();

		return json_encode(['code'=>0, '$resource_list'=>$resource_list]);

    }

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
		
		$file = $request->file('zip_file');
		$info = $file->move( '../resource/');
		if($info){
			$data['resource_addr'] = $info->getSaveName();
		}else{
			return Web::error_out(2, $file->getError());
		}
		Db::table('tb_course_resource')->data($data)->insert();
		
		return json_encode(['code'=>0]);
	}

	//删除课件
	public function remove()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 1, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");

		$id = $request->param('id');

		Db::table('tb_course_resource')->where('id',$id)->delete();

		return json_encode(['code'=>0]);

	}

}

?>                  

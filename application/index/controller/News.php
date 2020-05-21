<?php

namespace app\index\controller;

use think\Request;
use think\Controller;
use think\Db;
use app\common\functional\Web;

header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:*');
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class News
{
    //查询课程名，如果没有课程名就是遍历
    public function query()
    {
        $request = new Request;
        //鉴权
        $ret = Web::check_auth(Web::priv(1, 1, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
			
		$news_list = Db::table('tb_new')->select();
		
		return json_encode(['code'=>0, 'news_list'=>$news_list]);
    }

    //根据新闻ID查看新闻详细信息
    public function detail()
    {
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(1, 1, 1), $request->param('openid'));
		if($ret == false)
				return Web::error_out(1, "鉴权失败");
		
		$data = array();
		
		$new_id = $request->param('new_id');
		
		$new_data = Db::table('tb_new')->where('id', $new_id)->find();
		return json_encode(['code'=>0, '$new_data'=>$new_data]);
    }
	
	//添加新闻
	public function insert()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
		
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
		
		$data = array();
		$data['title'] = $request->param('title');
		$data['content'] = $request->param('content');
		$data['upload_time'] = $request->param('upload_time');
		
		// 获取表单上传文件 例如上传了001.jpg
		$file = $request->file('image');
		if($file != NULL)
		{
			// 移动到框架应用根目录/uploads/ 目录下
			$info = $file->move( '../uploads');
			if($info){
				//输出20160820/42a79759f284b767dfcb2a0197904287.jpg
				echo $info->getSaveName();
				$data['image'] = $info->getSaveName();
			}else{
				// 上传失败获取错误信息
				return Web::error_out(2, $file->getError());
			}
		}
		Db::table('tb_new')->data($data)->insert();
		
		return json_encode(['code'=>0]);
	}
	
	//删除新闻
	public function remove()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
        if($ret == false)
            return Web::error_out(1, "鉴权失败");
		
		$new_id = $request->param('new_id');
		Db::table('tb_new')->where('id',$new_id)->delete();
		return json_encode(['code'=>0]);
	}

	//修改新闻
	public function update()
	{
		$request = new Request;
		//鉴权
		$ret = Web::check_auth(Web::priv(0, 0, 1), $request->param('openid'));
        if($ret == false)
			return Web::error_out(1, "鉴权失败");
		
		$data = array();
		$data['id'] = $request->param('new_id');
		if($request->param('title') != NULL)
			$data['title'] = $request->param('title');
		if($request->param('content') != NULL)
			$data['content'] = $request->param('content');
		if($request->param('upload_time') != NULL)
			$data['upload_time'] = $request->param('upload_time');

		$file = $request->file('image');
		if($file != NULL)
		{
			// 移动到框架应用根目录/uploads/ 目录下
			$info = $file->move( '../uploads');
			if($info){
				//输出20160820/42a79759f284b767dfcb2a0197904287.jpg
				echo $info->getSaveName();
				$data['image'] = $info->getSaveName();
			}else{
				// 上传失败获取错误信息
				return Web::error_out(2, $file->getError());
			}
		}
		
		Db::table('tb_new')->data($data)->update();
		return json_encode(['code'=>0]);
	}
}
?>                                                                                                                            

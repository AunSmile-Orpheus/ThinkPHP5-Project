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
        $course_name = $request->param('course_name');
        if($ret == false)
            return Web::error_out(1, "鉴权失败");

        $where = array();
        if($course_name != NULL)
        {
            $where['cname'] = ['like','%'.$course_name.'%'];
        }
        $course_list = Db::table('tb_course')->where($where)->select();
        return $course_list;
    }

    //根据课程ID查看课程详细信息
    public function detail()
    {

    }
}
?>

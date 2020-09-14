<?php

namespace app\api\controller;


use app\admin\controller\Login;
use app\common\model\User as UserModel;
use app\common\model\UserToken;
use app\common\model\UserInfo as UserInfoModel;
use app\common\validate\UserValidate;
use think\App;
use think\Db;
use think\db\Query;
use think\Request;
use think\facade\Log;

class Trip extends Controller
{
    protected $authExcept = ['index','read_list','read','update','delete'];

    //列表
    public function index()
    {
        $data = "please specify function!";
        return success($data);
    }

    //条件检索/获取trip列表
    public function read_list(Request $request, UserToken $userToken, UserValidate $validate)
    {
        $param = $request->param();
        $validate_result = $validate->scene('add')->check($param);

        /*if (!$validate_result) {
            return error($validate->getError());
        }*/
        /*
         * 1、出发城市，区县 src_city, src_district
         * 2、目的城市，区县 dst_city, dst_district
         * 3、出发日期，departure_date
         * */

        $map = null;
        $today_date = date('Y-m-d');
        if(!empty($param['departure_date'])){
            $departure_datestamp = strtotime($param['departure_date']);
            $today_datestamp = strtotime("today");
            if($departure_datestamp>=$today_datestamp){
                //不是过去的时间
                $map['departure_date'] = $param['departure_date'];
            }
        }

        if(!empty($param['src_city'])){
            $map['src_city'] = $param['src_city'];
            if(!empty($param['src_district'])){
                $map['src_district'] = $param['src_district'];
            }
        }
        if(!empty($param['dst_city'])){
            $map['dst_city'] = $param['dst_city'];
            if(!empty($param['dst_district'])){
                $map['dst_district'] = $param['dst_district'];
            }
        }
        $trips = Db::table('trip')
            ->where('departure_date','egt',$today_date)
            ->where($map)
            ->select();

        return success($trips);

    }
    //查看某个具体trip详情
    public function read(Request $request, UserModel $model, UserValidate $validate)
    {
        $param = $request->param();
        $validate_result = $validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($validate->getError());
        }
        $result = $model::create($param);
        return $result ? success() : error();
    }
    //发布，增加
    public function publish($id, Request $request, UserModel $model, UserValidate $validate)
    {
    }
    //更新
    public function update($id, Request $request, UserModel $model, UserValidate $validate)
    {
        $data            = $model::get($id);
        $param           = $request->param();
        $validate_result = $validate->scene('edit')->check($param);
        if (!$validate_result) {
            return error($validate->getError());
        }

        $result = $data->save($param);
        return $result ? success() : error();
    }
    //删除
    public function delete($id, UserModel $model)
    {
    }

}

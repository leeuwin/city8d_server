<?php

namespace app\api\controller;

use app\common\model\User as UserModel;
use app\common\model\UserToken;
use app\common\model\UserInfo as UserInfoModel;
use app\common\validate\UserValidate;
use think\App;
use think\Db;
use think\Request;

class Trip extends Controller
{
    protected $authExcept = ['index'];

    //列表
    public function index()
    {
        $data = "please specify function!";
        return success($data);
    }

    //查看trip详情
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

    //获取trip列表
    public function readlist(Request $request, UserToken $userToken, UserValidate $validate)
    {
        $param = $request->param();

    }

    //查看
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

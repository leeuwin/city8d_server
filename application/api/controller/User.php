<?php

namespace app\api\controller;

use app\common\model\User as UserModel;
use app\common\model\UserToken;
use app\common\model\UserInfo as UserInfoModel;
use app\common\validate\UserValidate;
use think\App;
use think\Db;
use think\Request;

class User extends Controller
{
    protected $authExcept = ['index','save','register','wxregister'];

    //提示方法错误
    public function index()
    {
        $data = "please specify function!";
        return success($data);
    }
    //认证
    public function authenticate(Request $request, UserModel $model, UserValidate $validate)
    {

    }
    //登录，获取token
    public function login(Request $request, UserModel $model, UserValidate $validate)
    {
        $param           = $request->param();
        $validate_result = $validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($validate->getError());
        }
        $result = $model::create($param);
        return $result ? success() : error();
    }

    //检测用户信息是否合法
    public function check(Request $request)
    {
        $param           = $request->param();
        if(!isset($param['username'])){
            return error('请设置用户名参数');
        }
        //检查用户名是否合法
        $res = Db::table('user')->where(['username'=>$param['username']])->find();
        if ($res) {
            return error('用户名已存在');
        }
        return success();
    }

    //新增
    public function add(Request $request, UserModel $model, UserValidate $validate)
    {
        $param           = $request->param();
        $validate_result = $validate->scene('add')->check($param);
        if (!$validate_result) {
            return error($validate->getError());
        }
        $result = $model::create($param);
        return $result ? success() : error();
    }

    //查看
    public function read(UserModel $model)
    {
        $user = $model->getUserListById($this->uid);

        $userinfo = Db::table('userinfo')->where(['id'=>$user['id']])->find();
        if (!$userinfo) {
            return error('用户信息不存在');
        }
        $result = array_merge($user,$userinfo);

        unset($result['password']);
        unset($result['password1']);
        unset($result['status']);
        unset($result['openid']);
        unset($result['sessionkey']);
        if($result['avatar'][0] == '/'){
            $domain = \think\facade\Request::domain();
            $result['avatar'] = $domain.$result['avatar'];
        }

        return success($result);
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
        if (count($model->noDeletionId) > 0) {
            if (is_array($id)) {
                if (array_intersect($model->noDeletionId, $id)) {
                    return error('ID为' . implode(',', $model->noDeletionId) . '的数据无法删除');
                }
            } else if (in_array($id, $model->noDeletionId)) {
                return error('ID为' . $id . '的数据无法删除');
            }
        }

        if ($model->softDelete) {
            $result = $model->whereIn('id', $id)->useSoftDelete('delete_time', time())->delete();
        } else {
            $result = $model->whereIn('id', $id)->delete();
        }

        return $result ? success('删除成功') : error('删除失败');
    }

}

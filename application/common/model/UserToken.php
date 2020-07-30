<?php
/**
 * Created by PhpStorm.
 * User: drago
 * Date: 2020/3/27
 * Time: 19:34
 */

namespace app\common\model;


use think\facade\Log;
use think\Model;

class UserToken extends Model
{

    protected $name = 'user_token';

    public function getUserTokenByUid($uid)
    {
        try {
            $info = $this->where('user_id', $uid)->findOrEmpty()->toArray();
        } catch (\Exception $e) {

            Log::error($e->getMessage());
            return false;
        }

        return $info;

    }

    public function updateUserToken($uid, $token_time)
    {
        try {
            return $this->where('user_id', $uid)->update([
                'token_time' => $token_time,
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function addUserToken($uid, $token, $token_time)
    {
        $record = $this->where('user_id', $uid)->find();
        if ($record) {
            return $this->where('user_id', $uid)->update([
                'token' => $token,
                'token_time' => $token_time
            ]);
        }

        return $this->insert([
            'user_id' => $uid,
            'token' => $token,
            'token_time' => $token_time
        ]);
    }

}
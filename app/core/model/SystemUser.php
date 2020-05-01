<?php

namespace app\core\model;

class SystemUser extends BaseModel
{
    /**
     * @param string $username
     * @param string $password
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function verify($username, $password)
    {

        $user = self::getOne(['username' => $username]);
        if (empty($user)) return self::setErrorMsg('用户不存在');
        if(!$user->active){
            return self::setErrorMsg('账户已被禁用，请联系管理员');
        }
        if(!self::checkPassword($user->password, $password)){
            return self::setErrorMsg('密码错误，请重新输入');
        }
        return $user->hidden(['password']);
    }
    private static function checkPassword($md5Password, $password)
    {
        return $md5Password === md5($password);
    }
}
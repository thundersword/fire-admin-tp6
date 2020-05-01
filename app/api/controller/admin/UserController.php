<?php
declare(strict_types=1);
namespace app\api\controller\admin;

use app\api\controller\ApiBaseController;
use app\core\lib\Token;
use app\core\model\SystemUser;
use think\facade\Log;

class UserController extends ApiBaseController {

    /**
     * @return mixed
     */
    public function login()
    {

        $params = $this->request->post();
        $user = SystemUser::verify($params['username'],$params['password']);

        if($user){
            $token = Token::getToken($user);
            return app('json')->renderSuccess($token);
        }else{
            return app('json')->renderFail(SystemUser::getErrorMsg());
        }

    }
    public function auth()
    {
        return app('json')->renderSuccess('获取成功',[]);
    }
}
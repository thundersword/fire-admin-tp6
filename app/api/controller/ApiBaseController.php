<?php
namespace app\api\controller;
use app\core\controller\BaseController;
class ApiBaseController extends BaseController
{
    public function test()
    {
        return 'ok';
    }
}
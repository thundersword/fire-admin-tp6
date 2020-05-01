<?php
/*
 * @Author: Yu Jian
 * @Date: 2020-04-22 13:09:07
 * @Email: 41542066@qq.com
 */
namespace app\core\model;

use app\core\traits\ModelTrait;
use think\Model;
use think\facade\Db;
class BaseModel extends Model
{
    use ModelTrait;
    //自动写入时间戳
    protected $autoWriteTimestamp = 'datetime';

    private static $errorMsg;

    private static $transaction = 0;

    const DEFAULT_ERROR_MSG = 'SYSTEM ERROR';
    
    /**
     * @description: 设置错误信息
     * @param string $msg
     * @param bool $rollback
     * @return: bool
     */
    protected static function setErrorMsg($msg = self::DEFAULT_ERROR_MSG, $rollback = false)
    {
        if ($rollback) {
            self::rollbackTrans();
        }
        self::$errorMsg = $msg;
        return false;
    }
    
    /**
     * @description: 获取错误信息
     * @param
     * @return: string
     */
    public static function getErrorMsg()
    {
        return self::$errorMsg;
    }

    /**
     * @description: 开启事务
     */
    public static function startTrans()
    {
        Db::startTrans();
    }

    /**
     * @description: 事务回滚
     * @return:
     */
    public static function rollbackTrans()
    {
        Db::rollback();
    }

    /**
    * 提交事务
    */
    public static function commitTrans()
    {
        Db::commit();
    }

    /**
     * @description: 根据结果提交或者回滚事务
     * @param bool $res
     */
    public static function makeTrans(bool $res)
    {
        if ($res) {
            self::commitTrans();
        } else {
            self::rollbackTrans();
        }
    }
}

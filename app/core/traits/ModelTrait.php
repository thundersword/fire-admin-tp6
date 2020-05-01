<?php
/**
 * Created by .
 * User: Yu Jian
 * Description: 追求自由的野生程序员
 * Date: 2020-04-29
 * Time: 9:36
 * Email: 41542066@qq.com
 */
namespace app\core\traits;
trait ModelTrait
{
    /**
     * @param string/array $where
     * @return mixed
     */
    public static function getOne($where)
    {
        if (!is_array($where)) {
            return self::find($where);
        } else {
            return self::where($where)->find();
        }
    }

    /**
     * @param $function
     * @return mixed
     */
    public static function getAll($function)
    {
        $query = self::newQuery();
        $function($query);
        return $query->select();
    }

    /**
     * 添加多条数据
     * @param $group
     * @param bool $replace
     * @return mixed
     */
    public static function setAll($group, $replace = false)
    {
        return self::insertAll($group, $replace);
    }

    /**
     * 修改一条数据
     * @param $data
     * @param $id
     * @param $field
     * @return bool $type 返回成功失败
     */
    public static function editOne($data, $id, $field = null)
    {
        $model = new self;
        if (!$field) $field = $model->getPk();
        $res = $model->update($data, [$field => $id]);
        if (isset($res->result))
            return 0 < $res->result;
        else if (isset($res['data']['result']))
            return 0 < $res['data']['result'];
        else
            return false !== $res;
    }

    /**
     * 查询一条数据是否存在
     * @param array $map
     * @param string $field
     * @return bool
     */
    public static function being($map, $field = '')
    {
        $model = (new self);
        if (!is_array($map) && empty($field)) $field = $model->getPk();
        $map = !is_array($map) ? [$field => $map] : $map;
        return 0 < $model->where($map)->count();
    }

    /**
     * 删除一条数据
     * @param $id
     * @return bool $type
     */
    public static function deleteOne($id)
    {
        return false !== self::destroy($id);
    }

    /**
     * 分页
     * @param null $model 模型
     * @param null $eachFn 处理结果函数
     * @param array $params 分页参数
     * @param int $limit 分页数
     * @return array
     */
    public static function page($model = null, $eachFn = null, $params = [], $limit = 20)
    {
        if (is_numeric($eachFn) && is_numeric($model)) {
            return parent::page($model, $eachFn);
        }

        if (is_numeric($eachFn)) {
            $limit = $eachFn;
            $eachFn = null;
        } else if (is_array($eachFn)) {
            $params = $eachFn;
            $eachFn = null;
        }

        if (is_callable($model)) {
            $eachFn = $model;
            $model = null;
        } elseif (is_numeric($model)) {
            $limit = $model;
            $model = null;
        } elseif (is_array($model)) {
            $params = $model;
            $model = null;
        }

        if (is_numeric($params)) {
            $limit = $params;
            $params = [];
        }
        $listRows = [
            'list_rows' => $limit,
            'query' => $params
        ];
        $paginate = $model === null ? self::paginate($listRows, false) : $model->paginate($listRows, false);
        $list = is_callable($eachFn) ? $paginate->each($eachFn) : $paginate;
        $page = $list->render();
        $total = $list->total();
        return compact('list', 'page', 'total');
    }
}
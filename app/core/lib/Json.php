<?php
/**
 * Created by .
 * User: Yu Jian
 * Description: 追求自由的野生程序员
 * Date: 2020-04-25
 * Time: 22:41
 * Email: 41542066@qq.com
 */
declare(strict_types=1);
namespace app\core\lib;
use think\response;
class Json
{
    private $code = 200;

    /**
     * 设置状态码
     * @param int $code
     * @return $this
     */
    public function code(int $code):self
    {
        $this->code = $code;
        return $this;
    }

    public function create(int $status, string $message, ?array $data = null): Response
    {
        $result = compact('status', 'message');

        if (!is_null($data))
            $result['data'] = $data;

        return Response::create($result, 'json', $this->code);
    }
    public function renderSuccess($message = 'ok', ?array $data = null): Response
    {
        if (is_array($message)) {
            $data = $message;
            $message = 'ok';
        }

        return $this->create(200, $message, $data);
    }
    public function renderFail($message = 'fail', ?array $data = null): Response
    {
        if (is_array($message)) {
            $data = $message;
            $message = 'ok';
        }

        return $this->create(400, $message, $data);
    }
}
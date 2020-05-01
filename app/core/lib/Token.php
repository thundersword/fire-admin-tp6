<?php
/**
 * Created by .
 * User: Yu Jian
 * Description: 追求自由的野生程序员
 * Date: 2020-04-25
 * Time: 23:17
 * Email: 41542066@qq.com
 */
namespace app\core\lib;
use Firebase\JWT\JWT;
use app\core\model\SystemUser;
class Token
{
    public static function getToken($user)
    {
        $accessToken = self::createAccessToken($user);
        $refreshToken = self::createRefreshToken($user);
        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }

    private static function createAccessToken($user)
    {
        $key = config('secure.access_token_salt');
        $payload = [
            'iss' => 'fire-admin', //签发者
            'iat' => time(), //什么时候签发的
            'exp' => time() + 7200, //过期时间
            'user' => $user,
        ];
        return JWT::encode($payload, $key);

    }

    private static function createRefreshToken($user)
    {
        $key = config('secure.refresh_token_salt');
        $payload = [
            'iss' => 'fire-admin', //签发者
            'iat' => time(), //什么时候签发的
            'exp' => time() + 604800, //过期时间，一个星期
            'user' => ['id' => $user->id],
        ];
        return JWT::encode($payload, $key);
    }
}
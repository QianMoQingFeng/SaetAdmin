<?php

namespace app\common\library;

use DateTime;
use think\facade\Cache;
class Token
{

    protected $tokenCache;
    /**
     * 缓存最大存放时间,防止内存过载
     *
     * @var integer
     */
    protected static $memcachedMaxSecond = 86400;

/**
 * 设置token缓存类型
 *
 * @return tokenCache
 */
    public static function getTokenCache()
    {
        if (extension_loaded('memcached')) {
            return Cache::store('memcached');
        }
        if (extension_loaded('memcache')) {
            return Cache::store('memcache');
        }
        return false;
    }

    /**
     * @createToken:
     * @param string $auth 签发模型 admin、user
     * @param Int $auth_id 模型ID
     * @param string $app 签发应用 free = 全部
     * @param String|Int $expire_time 过期秒数或具体时间
     * @param String|Int $active_time 生效时间秒或者具体时间
     * @return Token
     */
    public static function createToken($auth_id, $auth = 'admin', $app = 'free', $expire_time = 2592000, $active_time = 0, $storage = ['mysql', 'memcached'])
    {
        if (is_int($expire_time) && is_int($active_time)) {
            $expire_second = $expire_time;
            $expire_time = datetime(null, (time() + $active_time + $expire_time));
            $active_time = datetime(null, time() + $active_time);

        } elseif (is_string($expire_time) && is_int($active_time)) {
            $active_time = datetime(null, time() + $active_time);
            $expire_second = strtotime($expire_time) - time() + $active_time;
        } elseif (is_int($expire_time) && is_string($active_time)) {
            $expire_second = $expire_time;
            $expire_time = datetime(null, strtotime($active_time) + $expire_time);
        } elseif (is_string($expire_time) && is_string($active_time)) {
            $expire_second = strtotime($expire_time) - strtotime($active_time);
        }

        $authArr = ['admin' => ['idField' => 'aid', 'model' => 'app\admin\model\admin\Token'], 'user' => ['idField' => 'uid', 'model' => 'app\common\model\UserToken']];
        $data = [
            $authArr[$auth]['idField'] => $auth_id,
            'app' => $app,
            'expire_second' => $expire_second,
            'expire_time' => $expire_time,
            'active_time' => $active_time,
        ];

        $dataStr = json_encode($data);
        // $encry = md5(md5($dataStr) . \saet\tool\Random::alnum(10));
        $encry = md5(md5($dataStr) . \think\helper\Str::random(10,2,'0123456789'));
        $data['token'] = $token = self::encryptToken($auth_id, $encry);

        $tokenCache = self::getTokenCache();
        if (in_array('memcached', $storage) && $tokenCache) {
            $tokenInfo = ['s' => strtotime($active_time), 'e' => strtotime($expire_time)];
            $tokenCache->set($auth . '_' . $token, $tokenInfo, $expire_second < self::$memcachedMaxSecond ? $expire_second : self::$memcachedMaxSecond);
        }

        if (in_array('mysql', $storage)) {
            // $tokenModel = Db::name($auth.'_token');
            $tokenModel = new $authArr[$auth]['model']();
            $tokenModel->save($data);
        }

        return $token;
    }

    /**
     * 检测Token是否存在有效
     *
     * @param [type] $token
     * @param string $auth admin|user 权限类型
     * @param array $storage 存储库
     * @return void
     */
    public static function checkToken($token, $auth = 'admin', $storage = ['mysql', 'memcached'])
    {

        $status = false;
        $auth_id = self::decryptToken($token);
        if (!$auth_id) {
            return ['status' => $status, 'message' => 'Token格式不正确'];
        }
        // memcached、memcache
        $tokenCache = self::getTokenCache();
        if (in_array('memcached', $storage) && $tokenCache) {
            $tokenInfo = $tokenCache->get($auth . '_' . $token);
            if ($tokenInfo) {
                if ($tokenInfo['s'] <= time() && $tokenInfo['e'] > time()) {
                    $status = true;
                    $message = 'memcached：right';
                    return ['status' => $status, 'message' => $message, 'auth_id' => $auth_id, 'type' => 'memcached/memcache'];
                } else {
                    $tokenCache->delete($token);
                    $message = 'memcached：Token过期或未生效';
                }
            } else {
                $message = 'memcached：Token不存在';
            }
        }
        if (in_array('mysql', $storage)) {
            $authArr = ['admin' => ['idField' => 'aid', 'model' => 'app\admin\model\admin\Token'], 'user' => ['idField' => 'uid', 'model' => 'app\common\model\user\Token']];
            $tokenModel = new $authArr[$auth]['model']();
            $tokenInfo = $tokenModel->where([$authArr[$auth]['idField'] => $auth_id, 'token' => $token])->find();
            if ($tokenInfo) {
                if (strtotime($tokenInfo['active_time']) <= time() && strtotime($tokenInfo['expire_time']) > time()) {
                    $status = true;
                    $message = 'mysql：right';
                    // 执行此处，说明尚未添加token到memcached 3600s/次
                    $tokenCache = self::getTokenCache();
                    if (in_array('memcached', $storage) && $tokenCache) {
                        $expire_second = strtotime($tokenInfo['expire_time']) - time(); //当前剩余
                        $tokenInfo = ['s' => strtotime($tokenInfo['active_time']), 'e' => strtotime($tokenInfo['expire_time'])];
                        $tokenCache->set($auth . '_' . $token, $tokenInfo, $expire_second < self::$memcachedMaxSecond ? $expire_second : self::$memcachedMaxSecond);
                    }
                } else {
                    $tokenInfo->delete();
                    $message = 'mysql：Token过期或未生效';
                }
            } else {
                $message = 'mysql：Token不存在';
            }
            return ['status' => $status, 'message' => $message, 'auth_id' => $auth_id, 'type' => 'mysql'];
        }
    }

    public static function deleteToken($token, $auth = 'admin', $storage = ['mysql', 'memcached'])
    {
        // memcached、memcache
        $tokenCache = self::getTokenCache();
        if (in_array('memcached', $storage) && $tokenCache) {
            $tokenCache->delete($auth . '_' . $token);
        }
        if (in_array('mysql', $storage)) {
            $authArr = ['admin' => ['idField' => 'aid', 'model' => 'app\admin\model\admin\Token'], 'user' => ['idField' => 'uid', 'model' => 'app\common\model\UserToken']];
            $tokenModel = new $authArr[$auth]['model']();
            $tokenInfo = $tokenModel->where(['token' => $token])->find();
            if ($tokenInfo['is_temporary']) {
                $tokenInfo->delete();
            }
        }
        return true;
    }

    /**
     * 追加authid形成新的Token
     *
     * @param [type] $id
     * @param [type] $encry
     * @param integer $length 加密长度
     * @param string $explode
     * @return void
     */
    public static function encryptToken($id, $encry, $length = 12, $explode = '@')
    {
        $id = strrev($id);
        $strlen = strlen($id);
        $diffLen = $length - $strlen - 1;
        $id = $id . $explode . substr($encry, 0, $diffLen);
        $base64 = base64_encode($id);
        $token = substr($encry, 8, 8) . '-' . substr($base64, 0, 8) . '-' . substr($encry, 16, 8) . '-' . substr($base64, 8, 8);
        return $token;
    }
    public static function decryptToken(String $token, $explode = '@')
    {
        if (strlen($token) != 35) return false;
        $tokenArr = explode('-', $token);
        $str = base64_decode($tokenArr[1] . $tokenArr[3]);
        $strArr = explode($explode, $str);
        return (int) strrev($strArr[0]);
    }

    public static function clear()
    {
        $tokenCache = self::getTokenCache();
        $tokenCache->clear();
    }
}

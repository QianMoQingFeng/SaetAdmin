<?php

namespace app\common\library;

use DateTime;
use think\facade\Cache;
use think\facade\Db;

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
    public static function createToken($auth_id, $auth = 'admin', $app = 'free', $active_time = null, $expire_second = 2592000, $storage = ['mysql', 'memcached'])
    {


        $authArr     = ['admin' => ['idField' => 'aid', 'model' => 'app\admin\model\admin\Token'], 'user' => ['idField' => 'uid', 'model' => 'app\common\model\UserToken']];
        $active_time = $active_time == null ? time() : $active_time;
        $expire_time = $active_time +  $expire_second;
        $data = [
            $authArr[$auth]['idField'] => $auth_id,
            'app' => $app,
            'expire_second' => $expire_second,
            'expire_time' => $expire_time,
            'active_time' => $active_time,
            'create_time' => time(),
        ];

        $dataStr = json_encode($data);
        // $encry = md5(md5($dataStr) . \saet\tool\Random::alnum(10));
        $encry = md5(md5($dataStr) . \think\helper\Str::random(10, 2, '0123456789'));
        $data['token'] = $token = self::encryptToken($auth_id, $encry);

        $tokenCache = self::getTokenCache();
        if (in_array('memcached', $storage) && $tokenCache) {
            $tokenInfo = ['s' => $active_time, 'e' => $expire_time];
            $tokenCache->set($auth . '_' . $token, $tokenInfo, $expire_second < self::$memcachedMaxSecond ? $expire_second : self::$memcachedMaxSecond);
        }

        if (in_array('mysql', $storage)) {
            $tokenModel = Db::name($auth . '_token');
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
            $tokenModel =   Db::name($auth . '_token');
            $tokenInfo = $tokenModel->where([$authArr[$auth]['idField'] => $auth_id, 'token' => $token])->find();
            if ($tokenInfo) {
                if ($tokenInfo['active_time'] <= time() && $tokenInfo['expire_time'] > time()) {
                    $status = true;
                    $message = 'mysql：right';
                    // 执行此处，说明尚未添加token到memcached 3600s/次
                    $tokenCache = self::getTokenCache();
                    if (in_array('memcached', $storage) && $tokenCache) {
                        $expire_second = $tokenInfo['expire_time'] - time(); //当前剩余
                        $tokenInfo = ['s' => $tokenInfo['active_time'], 'e' => $tokenInfo['expire_time']];
                        $tokenCache->set($auth . '_' . $token, $tokenInfo, $expire_second < self::$memcachedMaxSecond ? $expire_second : self::$memcachedMaxSecond);
                    }
                } else {
                    $tokenModel->where([$authArr[$auth]['idField'] => $auth_id, 'token' => $token])->delete();
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
            $tokenModel =  new ($authArr[$auth]['model']);
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

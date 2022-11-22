<?php

use think\exception\HttpResponseException;
use think\Response;

if (!function_exists('success')) {
    /**
     * 操作成功返回的数据
     * @param string $msg    提示信息
     * @param mixed  $data   要返回的数据
     * @param int    $code   错误码，默认为1
     * @param string $type   输出类型
     * @param array  $header 发送的 Header 信息
     */
    function success($msg = '', $data = null, $code = 1, $type = null, array $header = [])
    {
        result($msg, $data, $code, $type, $header);
    }
}
if (!function_exists('error')) {
    /**
     * 操作失败返回的数据
     * @param string $msg    提示信息
     * @param mixed  $data   要返回的数据
     * @param int    $code   错误码，默认为0
     * @param string $type   输出类型
     * @param array  $header 发送的 Header 信息
     */
    function error($msg = '', $data = null, $code = 0, $type = null, array $header = [])
    {
        result($msg, $data, $code, $type, $header);
    }
}

if (!function_exists('result')) {
    function result($msg = '', $data = null, $code = 1, $type = null, array $header = [])
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            // 'time' => Request::instance()->server('REQUEST_TIME'),
            'data' => $data,
        ];
        // 如果未设置类型则自动判断
        $type = $type ? $type : (request()->param(config('var_jsonp_handler')) ? 'jsonp' : (request()->isJson() || request()->isAjax() ? 'json' : 'html'));
        // dump($type);
        $type = 'json';
        if (isset($header['statuscode'])) {
            $code = $header['statuscode'];
            unset($header['statuscode']);
        } else {
            //未设置状态码,根据code值判断
            $code = $code >= 1000 || $code < 200 ? 200 : $code;
        }
        $response = Response::create($result, $type, $code)->header($header);
        throw new HttpResponseException($response);
        die;
    }
}

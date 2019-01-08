<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 2019/1/8
 * Time: 4:43 PM
 */

namespace App\Utils;
/**
 * Created by PhpStorm.
 * User: Felix
 * Email: felix@1201.us
 * Date: 2017/2/14
 * Time: 10:16
 */
trait EchoJson
{
    /**
     * 响应JSON
     * @param string $message
     * @param int $code
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function echoJson(string $message,int $code = 0 ,array $data = [])
    {
        $arr = [
            'code'      => $code,
            'message'   => $message,
            'data'      => $data,
        ];
        return response()->json($arr);
    }

    /**
     * 响应成功JSON
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function echoSuccessJson(string $message,array $data = [])
    {
        return $this->echoJson($message,0,$data);
    }

    /**
     * 响应错误JSON
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function echoErrorJson(string $message,array $data = [])
    {
        return $this->echoJson($message,100,$data);
    }
}
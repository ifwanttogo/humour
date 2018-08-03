<?php
/**
 * Created by PhpStorm.
 * User: xiaohan
 * Date: 2018-08-03
 * Time: 14:16
 */

namespace app\lib\exception;


use think\Exception;
use think\exception\Handle;
use think\Request;

class ExceptionHandle extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    // 需要返回客户端当前的请求URL

    public function render(Exception $e)
    {
        if($e instanceof BaseException)
        {
            // 如果是自定义异常
            $this->code = $e->code;
            $this->msg  = $e->msg;
            $this->errorCode= $e->errorCode;
        }else{
            $this->code = 500;
            $this->msg  ='服务器内部错误，不想告诉你';
            $this->errorCode = 999;
        }
        $request = Request::instance();
        $result = [
            'err_code' => $this->errorCode,
            'msg'      => $this->msg,
            'request_url' => $request->url()
        ];
        return json($result,$this->code);
    }
}
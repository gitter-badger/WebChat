<?php
/**
 * Created by PhpStorm.
 * User: linyulin
 * Date: 16/10/11
 * Time: 下午11:52
 */

namespace Server;


class RequestServer extends HttpServer
{

    public function onRequest($request, $response)
    {
        //$type = $request->post('type');

    }

    public function start()
    {
        echo "请求响应服务启动...\r\n监听端口:". $this->port;
        parent::start(); // TODO: Change the autogenerated stub
    }

}
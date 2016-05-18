<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 13:37
 * Email: jhasheng@hotmail.com
 */

namespace Jhasheng\Purple\Collections;


use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class Request extends AbstractCollection
{

    protected $name = 'request';

    public function after(Application $app, Response $response)
    {
        /**
         * 收集请求数据
         * @var $request \Symfony\Component\HttpFoundation\Request
         */
        $request = $app['request'];

        $this->data['request'] = [
            'headers' => $request->headers->all(),
            'method'  => $request->getMethod(),
            'uri'     => $request->getRequestUri(),
            'status'  => $response->getStatusCode(),
            'name'    => $this->name
        ];

        $this->global = [
            'uri'    => $request->getRequestUri(),
            'method' => $request->getMethod()
        ];
    }
}
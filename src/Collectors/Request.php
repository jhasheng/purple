<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 13:37
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Collectors;


use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class Request extends AbstractCollection
{

    protected $name = 'request';

    protected $icon = 'refresh';

    protected $template = 'request';

    public function after(Application $app, Response $response)
    {
        /**
         * 收集请求数据
         * @var $request \Symfony\Component\HttpFoundation\Request
         */
        $request = $app['request'];
        $this->data[$this->template] = [
            'headers'  => $request->headers->all(),
            'method'   => $request->getMethod(),
            'uri'      => $request->getRequestUri(),
            'status'   => $response->getStatusCode(),
            'response' => $response->headers->all(),
            'server'   => $request->server,
            'data'     => $request->all()
        ];

        $this->global = [
            'uri'     => $request->getRequestUri(),
            'method'  => $request->getMethod(),
            'time'    => microtime(true) - LARAVEL_START,
            'version' => Application::VERSION
        ];

        $this->calcBadge();
    }
}
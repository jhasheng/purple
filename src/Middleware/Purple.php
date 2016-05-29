<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 14:42
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Middleware;

use Closure;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Request;

class Purple
{
    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function handle(Request $request, Closure $next)
    {
        /**
         * @var $hook \Purple\PurpleHook
         */
        $hook = $this->app['purple.hook'];
        /**
         * 不针对内部请求及命令行模式
         */
        if(!$hook->isEnable() || $hook->isBuiltInRequest() || $hook->inConsole()) {
            return $next($request);
        }
        // 开始收集数据
        $hook->beforeHook();
        $response = $next($request);
        // 结束数据收集
        $hook->afterHook($response);
        return $response;
    }
}
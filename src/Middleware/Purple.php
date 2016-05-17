<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 14:42
 * Email: jhasheng@hotmail.com
 */

namespace Jhasheng\Purple\Middleware;

use Closure;
use Jhasheng\Purple\PurpleHook;
use Symfony\Component\HttpFoundation\Request;

class Purple
{
    protected $hook;

    public function __construct(PurpleHook $hook)
    {
        $this->hook = $hook;
    }

    public function handle(Request $request, Closure $next)
    {
        $hook = $this->hook;
        /**
         * 不针对内部请求及命令行模式
         */
        if(!$hook->isEnable() || $hook->isInteractRequest() || $hook->inConsole()) {
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
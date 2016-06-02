<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 5/29/2016
 * Time: 9:57 PM
 */

namespace Purple\Collections;


use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class Route extends AbstractCollection
{
    protected $name = 'route';

    protected $icon = 'road';
    
    protected $template = 'routes';
    
    public function after(Application $app, Response $response)
    {
        /**
         * @var $router \Illuminate\Routing\Router
         */
        $router = $this->app['router'];
        $routes = $router->getRoutes()->getRoutes();
        /**
         * @var $route \Illuminate\Routing\Route
         */
        foreach ($routes as $route) {
            array_push($this->data[$this->template], [
                'methods' => $route->getMethods(),
                'name'    => $route->getName(),
                'path'    => $route->getPath(),
                'action'  => $route->getActionName(),
            ]);
        }
        
        $current = $router->current();

        $this->data['current'] = $this->global = [
            'methods' => $current->getMethods(),
            'name'    => $current->getName(),
            'path'    => $current->getPath(),
            'action'  => $current->getActionName(),
        ];

        $this->calcBadge();
    }
}
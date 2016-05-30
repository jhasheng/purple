<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 16:27
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Request;


use Illuminate\Foundation\Application;

class Request
{
    protected $uuid;

    protected $time;

    protected $uri;

    protected $content;

    protected $app;
    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @param mixed $time
     */
    public function setTime($time)
    {
        $this->time = $time;
    }

    /**
     * @param mixed $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = serialize($content);
    }
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function hydra(array $collections)
    {
        /**
         * @var $hook \Purple\PurpleHook;
         */
        $hook = $this->app['purple.hook'];
        foreach ($collections as $name => $data) {
            $collection = $hook->getCollection($name);
            dd($collection);
        }
    }

    public function toArray()
    {
        return [
            'uuid'    => $this->uuid,
            'time'    => microtime(true) - LARAVEL_START,
            'content' => $this->content,
            'uri'     => $this->uri
        ];
    }
}
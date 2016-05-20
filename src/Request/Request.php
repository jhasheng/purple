<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 16:27
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Request;


class Request
{
    protected $uuid;

    protected $time;

    protected $uri;

    protected $content;

    public function hydra(array $array)
    {
        $result = $menu = $global = [];
        foreach ($array as $key => $value) {
            array_push($menu, ['name' => $key, 'badge' => $value['badge']]);
            $global       = array_merge($global, $value['global']);
            $result[$key] = $value['data'];
        }

        $data = [
            'menu'  => $menu,
            'child' => $result,
        ];

        $data = array_merge($data, $global);

        $this->uri     = $data['method'] . ' ' .$data['uri'];
        $this->content = serialize($data);
        $this->time    = time();
        $this->uuid    = uniqid();
    }

    public function toArray()
    {
        return [
            'uuid'    => $this->uuid,
            'time'    => microtime(true) - LARAVEL_START,
            'storage' => $this->content,
            'uri'     => $this->uri
        ];
    }
}
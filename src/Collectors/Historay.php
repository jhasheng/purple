<?php
/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/6/7
 * Time: 14:10
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Collectors;


use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class Historay extends AbstractCollection
{

    protected $name = 'history';

    protected $template = 'history';

    protected $icon = 'history';

    public function after(Application $app, Response $response)
    {
        $this->app = $app;
    }

    public function live()
    {
        /**
         * @var $storage \Purple\Storage\StorageInterface
         */
        $storage = $this->app['purple.storage'];

        $this->data[$this->name] = $storage->fetch($this->app['request']->get('page'));
    }

}
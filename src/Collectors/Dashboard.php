<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 6/1/2016
 * Time: 11:48 PM
 */

namespace Purple\Collectors;


use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class Dashboard extends AbstractCollection
{
    protected $template = 'dashboard';

    protected $name = 'dashboard';

    protected $icon = 'dashboard';

    public function after(Application $app, Response $response)
    {
//        parent::after($app, $response);
    }

    public function live()
    {
        // Initialize widget array.
        $this->data['widgets'] = [];
    }
}
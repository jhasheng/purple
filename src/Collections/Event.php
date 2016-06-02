<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 5/29/2016
 * Time: 6:58 PM
 */

namespace Purple\Collections;


use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class Event extends AbstractCollection
{
    protected $name = 'event';

    protected $icon = 'exclamation-circle';
    
    protected $template = 'events';

    public function before(Application $application)
    {
        /**
         * @var $event \Illuminate\Events\Dispatcher
         */
        parent::before($application);
        $event = $application['events'];
        $event->listen('*', [$this, 'eventFired']);
    }

    public function eventFired()
    {
        /**
         * @var $event \Illuminate\Events\Dispatcher
         */
        $event = $this->app['events'];

        array_push($this->data[$this->template], [
            'name' => $event->firing(),
            'time' => microtime(true) - LARAVEL_START
        ]);
    }

    public function after(Application $app, Response $response)
    {
        $this->calcBadge();
    }
}
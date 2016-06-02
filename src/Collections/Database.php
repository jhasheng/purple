<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 5/29/2016
 * Time: 8:35 PM
 */

namespace Purple\Collections;


use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class Database extends AbstractCollection
{
    protected $name = 'db';

    protected $icon = 'database';

    protected $template = 'query';

    public function before(Application $application)
    {
        parent::before($application);
        $event = $application['events'];

        $event->listen(QueryExecuted::class, [$this, 'databaseFired']);
    }

    public function databaseFired(QueryExecuted $query)
    {
        /**
         * @var $event \Illuminate\Database\Events\QueryExecuted
         */
        array_push($this->data[$this->template], [
            'query'      => $query->sql,
            'bindings'   => $query->bindings,
            'time'       => $query->time,
            'connection' => $query->connectionName
        ]);

    }

    public function after(Application $app, Response $response)
    {
        $this->calcBadge();
    }
}
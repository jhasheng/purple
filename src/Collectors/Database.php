<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 5/29/2016
 * Time: 8:35 PM
 */

namespace Purple\Collectors;


use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Foundation\Application;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class Database extends AbstractCollection
{
    protected $name = 'db';

    protected $icon = 'database';

    protected $template = 'queries';

    public function before(Application $application)
    {
        parent::before($application);
        $event = $application['events'];

        if (Str::startsWith(Application::VERSION, ['5.0', '5.1'])) {
            $event->listen('illuminate.query', function ($query, $bindings, $time, $name) {
                array_push($this->data[$this->template], [
                    'query'      => $query,
                    'bindings'   => $bindings,
                    'time'       => $time,
                    'connection' => $name
                ]);
            });
        } else if (Str::startsWith(Application::VERSION, ['5.2'])) {
            $event->listen(QueryExecuted::class, [$this, 'databaseFired']);
        }
    }

    public function databaseFired(QueryExecuted $query)
    {
        $query->sql = preg_replace_callback('/\?/', function($matches) use($query) {
            foreach ($matches as $k => $match) {
                return $query->bindings[$k];
            }
        }, $query->sql);

        /**
         * @var $event QueryExecuted
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
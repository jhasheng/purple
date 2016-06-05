<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 6/5/2016
 * Time: 3:28 PM
 */

namespace Purple\Storage;

use Cache;
use Purple\Request\Request;

class RedisStorage implements StorageInterface
{
    use StorageTrait;

    public function retrieve($id)
    {
        /**
         * @var $config \Illuminate\Config\Repository
         */
        $config = $this->app['config'];
        $table = $config->get('purple.table', 'purple');

        $client = Cache::store('redis')->connection();
        $values = unserialize($client->hget($table, $id));
        return unserialize($values['content']);
    }

    public function store(Request $request)
    {
        /**
         * @var $config \Illuminate\Config\Repository
         */
        $config = $this->app['config'];
        $table = $config->get('purple.table', 'purple');

        $client = Cache::store('redis')->connection();
        $client->hset($table, $request->getUuid(), serialize($request->toArray()));
    }

    public function purge()
    {
        /**
         * @var $config \Illuminate\Config\Repository
         */
        $config = $this->app['config'];
        $table = $config->get('purple.table', 'purple');

        Cache::store('redis')->connection()->del($table);
    }
}
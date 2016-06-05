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

    /**
     * 获取指定数据
     * @param $token
     * @return array
     */
    public function retrieve($token)
    {
        /**
         * @var $config \Illuminate\Config\Repository
         */
        $config = $this->app['config'];
        $table = $config->get('purple.table', 'purple');

        $client = Cache::store('redis')->connection();
        $values = unserialize($client->hget($table, $token));
        return unserialize($values['content']);
    }

    /**
     * 保存收集到的数据
     * @param Request $request
     * @return void
     */
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

    /**
     * 清空数据
     * @return void
     */
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
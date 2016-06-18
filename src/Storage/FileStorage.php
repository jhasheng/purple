<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 6/5/2016
 * Time: 10:07 PM
 */

namespace Purple\Storage;


use Illuminate\Pagination\LengthAwarePaginator;
use Purple\Exceptions\InvalidTokenException;
use Purple\Request\Request;

class FileStorage implements StorageInterface
{
    use StorageTrait;

    /**
     * 获取指定数据
     * @param $token
     * @return array
     * @exception InvalidTokenException
     */
    public function retrieve($token)
    {
        if ($token && file_exists($file = $this->getFileName($token))) {
            $content = unserialize(file_get_contents($file));
            return unserialize($content['content']);
        } else {
            throw new InvalidTokenException;
        }
    }

    /**
     * 保存收集到的数据
     * @param Request $request
     * @return boolean
     */
    public function store(Request $request)
    {
        $fileName = $this->getFileName($request->getUuid());

        $profileIndexed = is_file($fileName);
        if (!$profileIndexed) {
            // Create directory
            $dir = dirname($fileName);
            if (!is_dir($dir) && false === @mkdir($dir, 0777, true) && !is_dir($dir)) {
                throw new \RuntimeException(sprintf('Unable to create the storage directory (%s).', $dir));
            }
        }

        $data = $request->toArray();
        $data['created_at'] = date('Y-m-d H:i:s');
        if (false === file_put_contents($fileName, serialize($data))) {
            return false;
        }

        if (!$profileIndexed) {
            // Add to index
            if (false === $file = fopen($this->getFileIndexName(), 'a')) {
                return false;
            }

            fputcsv($file, array(
                $request->getUuid()
            ));
            fclose($file);
        }

        return true;
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

        $flags = \FilesystemIterator::SKIP_DOTS;
        $iterator = new \RecursiveDirectoryIterator(storage_path($table), $flags);
        $iterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);

        foreach ($iterator as $file) {
            if (is_file($file)) {
                unlink($file);
            } else {
                rmdir($file);
            }
        }
    }

    /**
     * 获取所有数据，可分页
     * @param $pageNow
     * @return array|LengthAwarePaginator
     */
    public function fetch($pageNow)
    {
        $data = [];

        $path     = $this->app['request']->getPathInfo();
        $pageSize = $this->app['config']->get('purple.history_size', 10);

        $indexContent = file_get_contents($this->getFileIndexName());

        $indexArr = preg_split('/\s/', trim($indexContent));
        $results  = collect($indexArr)->forPage($pageNow, $pageSize)->toArray();
        foreach ($results as $index) {
            array_push($data, (object)unserialize(file_get_contents($this->getFileName($index))));
        }
        return new LengthAwarePaginator($data, count($indexArr), $pageSize, $pageNow, ['path' => $path]);
    }

    protected function getFileName($token)
    {
        /**
         * @var $config \Illuminate\Config\Repository
         */
        $config = $this->app['config'];
        $table = $config->get('purple.table', 'purple');

        return storage_path($table) . DIRECTORY_SEPARATOR . $token . '.csv';
    }

    protected function getFileIndexName()
    {
        /**
         * @var $config \Illuminate\Config\Repository
         */
        $config = $this->app['config'];
        $table = $config->get('purple.table', 'purple');

        return storage_path($table) . DIRECTORY_SEPARATOR . 'index.csv';
    }
}
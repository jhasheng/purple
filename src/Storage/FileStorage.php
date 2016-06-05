<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 6/5/2016
 * Time: 10:07 PM
 */

namespace Purple\Storage;


use Purple\Request\Request;

class FileStorage implements StorageInterface
{
    use StorageTrait;

    public function retrieve($token)
    {
        if ($token && file_exists($file = $this->getFileName($token))) {
            $content = unserialize(file_get_contents($file));
            return unserialize($content['content']);
        }
    }

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

        if (false === file_put_contents($fileName, serialize($request->toArray()))) {
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
<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 6/5/2016
 * Time: 9:40 PM
 */

namespace Purple\Command;


use Illuminate\Console\Command;
use Purple\Storage\StorageInterface;

class PurpleCommand extends Command
{
    protected $signature = 'purple:clear';

    protected $description = 'Purple profiler command tools';

    protected $storage = null;

    public function __construct(StorageInterface $storage)
    {
        parent::__construct();
        $this->storage = $storage;
    }

    public function handle()
    {
        $this->info('clear storage data');
        $this->storage->purge();
    }
}
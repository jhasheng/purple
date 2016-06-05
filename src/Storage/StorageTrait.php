<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 6/5/2016
 * Time: 4:45 PM
 */

namespace Purple\Storage;


use Illuminate\Foundation\Application;

trait StorageTrait
{
    protected $app;
    
    public function setApplication(Application $application)
    {
        $this->app = $application;
    }
}
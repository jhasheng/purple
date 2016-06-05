<?php

/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 13:34
 * Email: jhasheng@hotmail.com
 */

namespace Purple\Collectors;

use Illuminate\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

interface CollectionInterface
{
    public function register(Application $app);
    
    public function before(Application $app);

    public function live();

    public function after(Application $app, Response $response);

    public function getData();

    public function getName();
    
    public function formatData();
    
    public function getTemplate();
}
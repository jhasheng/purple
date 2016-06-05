<?php

/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 14:15
 * Email: jhasheng@hotmail.com
 */
namespace Purple\Exceptions;

class InvalidStorageException extends \RuntimeException
{
    protected $message = 'this storage not support yet!';
}
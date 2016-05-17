<?php

/**
 * Created by PhpStorm.
 * User: Krasen
 * Date: 16/5/17
 * Time: 14:15
 * Email: jhasheng@hotmail.com
 */
namespace Jhasheng\Purple\Exceptions;

class InvalidCollectionException extends \RuntimeException
{
    protected $message = 'The collection must be implement CollectionInterface';
}
<?php
/**
 * Created by PhpStorm.
 * User: krasen
 * Date: 6/5/2016
 * Time: 11:21 PM
 */

namespace Purple\Exceptions;


class InvalidTokenException extends \RuntimeException
{
    protected $message = 'invalid token';
}
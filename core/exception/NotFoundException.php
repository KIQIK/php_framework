<?php

namespace app\core\exception;

class NotFoundException extends \Exception
{
    protected $message = 'The page not found';
    protected $code = 404;

}
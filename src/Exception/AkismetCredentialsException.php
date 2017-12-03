<?php

namespace Backtheweb\Akismet\Exception;

class AkismetCredentialsException extends \RuntimeException
{
    protected $message = 'Akismet invalid key or site';
}
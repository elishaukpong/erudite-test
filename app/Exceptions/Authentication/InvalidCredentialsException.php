<?php

declare(strict_types=1);

namespace App\Exceptions\Authentication;

use Illuminate\Auth\AuthenticationException;

class InvalidCredentialsException extends AuthenticationException
{

    public function __construct()
    {
        parent::__construct(__('Invalid Credentials'));
    }
}

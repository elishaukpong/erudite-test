<?php

declare(strict_types=1);

namespace App\Exceptions\Event;

use Exception;
use Illuminate\Http\Response;

class MaxParticipantsCannotBeLowerThanCurrentException extends Exception
{

    public function __construct()
    {
        parent::__construct(__('Event currently has more participants than the new max count. Update not possible!'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
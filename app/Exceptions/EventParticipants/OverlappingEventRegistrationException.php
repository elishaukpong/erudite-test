<?php

namespace App\Exceptions\EventParticipants;

use Exception;
use Illuminate\Http\Response;

class OverlappingEventRegistrationException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('Participant is already registered to another event starting at the same time is this event.'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}

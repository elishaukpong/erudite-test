<?php

declare(strict_types=1);

namespace App\Exceptions\EventParticipants;

use Exception;
use Illuminate\Http\Response;

class MaxParticipantsCountExceededException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('Event is filled! Cannot register new participants for event.'), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Events\StoreEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventParticipantService;
use App\Traits\APIResponses;
use Illuminate\Http\JsonResponse;
use Throwable;

class EventParticipantController extends Controller
{
    use APIResponses;

    public function __construct(protected EventParticipantService $eventParticipantService)
    {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event, StoreEventRequest $request): JsonResponse
    {
        try {
            $event = $this->eventParticipantService->store($request->validated());

            return $this->ok(__('Event Participant(s) created!'), new EventResource($event));
        }catch (Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

}
<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1;

use App\Exceptions\EventParticipants\MaxParticipantsCountExceededException;
use App\Exceptions\EventParticipants\OverlappingEventRegistrationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\EventParticipants\StoreEventParticipantRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Models\User;
use App\Services\EventParticipant\EventParticipantService;
use App\Traits\APIResponses;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class EventParticipantController extends Controller
{
    use APIResponses;

    public function __construct(protected EventParticipantService $eventParticipantService)
    {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event, StoreEventParticipantRequest $request): JsonResponse
    {
        try {
            $this->eventParticipantService->store($event, $request->validated());

            return $this->ok(__('Event Participant registered!'), new EventResource($event), Response::HTTP_CREATED);
        }catch (MaxParticipantsCountExceededException | OverlappingEventRegistrationException | Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, User $participant): JsonResponse
    {
        try {
            $this->eventParticipantService->delete($event, $participant);

            return $this->ok(__('Participant has been removed from event!'));
        }catch (Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

}
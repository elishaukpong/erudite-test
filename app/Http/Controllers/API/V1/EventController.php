<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1;

use App\Exceptions\Event\MaxParticipantsCannotBeLowerThanCurrentException;
use App\Http\Controllers\Controller;
use App\Http\Filters\V1\EventFilter;
use App\Http\Requests\API\Events\StoreEventRequest;
use App\Http\Requests\API\Events\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;
use App\Traits\APIResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class EventController extends Controller
{
    use APIResponses;

    public function __construct(protected EventService $eventService)
    {}

    /**
     * Display a listing of the resource.
     */
    public function index(EventFilter $filters): AnonymousResourceCollection
    {
        return EventResource::collection(Event::filter($filters)->paginate());

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEventRequest $request): JsonResponse
    {
        try {
            $event = $this->eventService->store($request->validated());

            return $this->ok(__('Event created!'), new EventResource($event));
        }catch (Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): JsonResponse
    {
        try {
            return $this->ok(__('Event retrieved!'), new EventResource($event));
        }catch (Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event): JsonResponse
    {
        try {
            $event = $this->eventService->update($event,$request->validated());

            return $this->ok(__('Event updated!'), new EventResource($event));
        }catch (MaxParticipantsCannotBeLowerThanCurrentException|Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): JsonResponse
    {
        try {
            $this->eventService->delete($event);

            return $this->ok(__('Event deleted!'));
        }catch (Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Services\EventParticipant;

use App\Exceptions\EventParticipants\MaxParticipantsCountExceededException;
use App\Exceptions\EventParticipants\OverlappingEventRegistrationException;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EventParticipantService
{

    /**
     * @throws MaxParticipantsCountExceededException
     * @throws OverlappingEventRegistrationException
     */
    public function store(Event $event, array $data): Model
    {
        if(! $event->canAddParticipant()) {
            throw new MaxParticipantsCountExceededException();
        }

        if($this->participantHasConflictingStartDateForEvent($event, (int)$data['participant_id'])) {
            throw new OverlappingEventRegistrationException();
        }

        $event->participants()->attach($data['participant_id']);

        //send email to participant

        return $event->fresh();
    }

    private function participantHasConflictingStartDateForEvent(Event $event, int $participant_id): bool
    {
        return Event::whereDate('start_date', $event->start_date)
            ->whereHas('participants', fn(Builder $query) => $query->where('users.id', $participant_id))
            ->exists();
    }

    public function delete(Event $event, User $participant): void
    {
        $event->participants()->detach($participant->id);
    }
}
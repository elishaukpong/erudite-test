<?php

declare(strict_types=1);

namespace App\Services\Event;

use App\Exceptions\Event\MaxParticipantsCannotBeLowerThanCurrentException;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Can decide to use a repository class for all db interactions
 * or use action classes.
 */
class EventService
{

    public function store(array $data): Model
    {
        return Event::create([
            ...$data,
            'created_by' => auth()->id()
        ]);
    }

    public function update(Event $event, array $data): Model
    {
        if(isset($data['max_participant_count']) && ! $this->hasValidMaxParticipantCount($event, (int) $data['max_participant_count'])) {
            throw new MaxParticipantsCannotBeLowerThanCurrentException();
        }

        $event->update($data);

        return $event->fresh();
    }

    /**
     * @throws Throwable
     */
    public function delete(Event $event): void
    {
        DB::beginTransaction();

        try {
            $event->participants()->detach();

            $event->delete();
        } catch (Throwable $e) {
            throw $e;
        }

    }

    /**
     * @param Event $event
     * @param int $max_participant_count
     * @return bool
     */
    public function hasValidMaxParticipantCount(Event $event, int $max_participant_count): bool
    {
        return $max_participant_count >= $event->participants()->count();
    }
}
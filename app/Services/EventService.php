<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Event\MaxParticipantsCannotBeLowerThanCurrentException;
use App\Models\Event;
use Exception;
use Illuminate\Database\Eloquent\Model;

class EventService
{

    /**
     * @throws Exception
     */
    public function store(array $data): Model
    {
        /**
         * Can decide to use a repository class for all db interactions
         * or use action classes.
         */

        return Event::create([
            ...$data,
            'created_by' => auth()->id()
        ]);
    }

    /**
     * @throws Exception
     */
    public function update(Event $event, array $data): Model
    {
        /**
         * Can decide to use a repository class for all db interactions
         * or use action classes.
         */

        if(isset($data['max_participant_count']) && ! $this->hasValidMaxParticipantCount($event, (int) $data['max_participant_count'])) {
            throw new MaxParticipantsCannotBeLowerThanCurrentException();
        }

        $event->update($data);

        return $event->fresh();
    }

    /**
     * @param $max_participant_count
     * @param Event $event
     * @return bool
     */
    public function hasValidMaxParticipantCount(Event $event, int $max_participant_count): bool
    {
        return $max_participant_count >= $event->participants()->count();
    }
}
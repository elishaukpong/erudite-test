<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $registeredParticipantsCount = $this->participants()->count();

        return [
            'type' => 'events',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'start_date' => $this->start_date->format('Y-m-d H:i:s'),
                'end_date' => $this->start_date->format('Y-m-d H:i:s'),
                'max_participant_count' => $this->max_participant_count,
                'can_register_participant' => $this->max_participant_count > $registeredParticipantsCount,
                'available_participant_slot' => $this->remaining_participants_count,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at
            ],
            'relationships' => [
                'creator' => new UserResource($this->createdBy),
                'participants' => ParticipantResource::collection($this->participants),
            ]
        ];
    }
}

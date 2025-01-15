<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Events;

use App\Traits\APIResponses;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateEventRequest extends FormRequest
{
    use APIResponses;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $event = $this->route('event');

        return $this->user()->can('update', $event);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after:start_at',
            'max_participant_count' => 'sometimes|int',
        ];
    }

    protected function failedAuthorization(): void
    {
        $this->error('Unauthorized action', Response::HTTP_FORBIDDEN)->send();
    }
}

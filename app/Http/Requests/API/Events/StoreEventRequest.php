<?php

declare(strict_types=1);

namespace App\Http\Requests\API\Events;

use App\Models\Event;
use App\Traits\APIResponses;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreEventRequest extends FormRequest
{
    use APIResponses;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', Event::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:events,name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_at',
            'max_participant_count' => 'required|int',
        ];
    }

    protected function failedAuthorization(): void
    {
        $this->error('Unauthorized action', Response::HTTP_FORBIDDEN)->send();
    }
}

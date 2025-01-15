<?php

declare(strict_types=1);

namespace App\Http\Requests\API\EventParticipants;

use App\Traits\APIResponses;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreEventParticipantRequest extends FormRequest
{
    use APIResponses;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'participant_id' => 'required|exists:users,id',
        ];
    }

    protected function failedAuthorization(): void
    {
        $this->error('Unauthorized action', Response::HTTP_FORBIDDEN)->send();
    }
}
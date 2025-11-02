<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTweetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|max:280',
        ];
    }

    public function toDTO(): \App\DTOs\CreateTweetDTO
    {
        return new \App\DTOs\CreateTweetDTO(
            content: $this->input('content'),
            userId: auth()->id()
        );
    }
}

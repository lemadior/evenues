<?php
declare(strict_types=1);

namespace App\Http\Requests\Admin\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 'poster' field here is not required
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2',
            'event_date' => 'required|string|min:2',
            'poster' => 'sometimes|dimensions:min_width=400,min_height=400',
            'venue_id' => 'required|int|gt:0'
        ];
    }
}

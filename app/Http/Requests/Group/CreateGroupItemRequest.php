<?php

namespace App\Http\Requests\Group;

use App\Http\Requests\Request;

class CreateGroupItemRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:5',
            'total' => 'required|integer',
            'due_date' => 'required|string'
        ];
    }
}

<?php

namespace App\Http\Requests\Group;

use App\Http\Requests\Request;

class JoinGroupRequest extends Request
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
            'group_code' => 'required|string|exists:groups,code'
        ];
    }
}

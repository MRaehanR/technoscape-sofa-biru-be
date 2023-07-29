<?php

namespace App\Services\Group;

use App\Models\Group;
use Illuminate\Support\Str;

class GroupServiceImplement implements GroupService
{
    public function createGroup(array $data)
    {
        $code = Str::upper(Str::random(6));

        $group = Group::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'code' => $code,
        ]);

        return ['group' => $group];
    }
}

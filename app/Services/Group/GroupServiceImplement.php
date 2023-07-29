<?php

namespace App\Services\Group;

use App\Exceptions\ResponseException;
use App\Models\Group;
use App\Models\GroupMember;
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

        $groupMember = GroupMember::create([
            'user_id' => auth()->user()->id,
            'group_id' => $group->id,
            'is_manager' => true,
        ]);

        return ['group' => $group, 'group_member' => $groupMember];
    }

    public function joinGroup(array $data)
    {
        $group = Group::where('code', strtoupper($data['group_code']))->first();

        if (!$group) {
            throw new ResponseException("Group Not Found", 404);
        }

        $groupMember = GroupMember::where('user_id', auth()->user()->id)->where('group_id', $group->id)->first();
        if ($groupMember) {
            throw new ResponseException("User Already Joined", 403);
        }

        $newMember = GroupMember::create([
            'user_id' => auth()->user()->id,
            'group_id' => $group->id,
            'is_manager' => false,
        ]);

        return ['group' => $group, 'new_member' => $newMember];
    }
}

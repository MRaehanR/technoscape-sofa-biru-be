<?php

namespace App\Services\Group;

use App\Models\Group;
use App\Models\GroupItem;
use App\Models\GroupMember;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ResponseException;

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

    public function createGroupItem(array $data)
    {
        $group = Group::where('id', $data['group_id'])->first();

        if (!$group) {
            throw new ResponseException("Group Not Found", 404);
        }

        $groupItem = GroupItem::create([
            'group_id' => $group->id,
            'title' => $data['title'],
            'total' => $data['total'],
            'due_date' => $data['due_date']
        ]);

        return ['group' => $group, 'new_group_item' => $groupItem];
    }

    public function groupList()
    {
        $user = Auth::user();

        $groups = Group::with('members')->whereHas('members', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        foreach ($groups as $group) {
            unset($group->members);
        }

        return ['groups' => $groups];
    }

    public function getGroupItemList(int $group_id)
    {
        $group = Group::where('id', $group_id)->first();

        if (!$group) {
            throw new ResponseException("Group Not Found", 404);
        }

        $groupItems = GroupItem::where('group_id', $group->id)->get();

        if (count($groupItems) === 0) {
            throw new ResponseException("Group Item Not Found", 404);
        }

        return ['group_items' => $groupItems];
    }
}

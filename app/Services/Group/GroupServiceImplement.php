<?php

namespace App\Services\Group;

use App\Models\Group;
use App\Models\GroupItem;
use App\Models\GroupMember;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ResponseException;
use App\Models\ItemsTransaction;
use App\Repositories\Technoscape\TechnoscapeRepository;

class GroupServiceImplement implements GroupService
{
    private $technoscapeRepository;

    public function __construct(TechnoscapeRepository $technoscapeRepository)
    {
        $this->technoscapeRepository = $technoscapeRepository;
    }

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

    public function createGroupItem(array $data, string $group_code)
    {
        $group = Group::where('code', $group_code)->first();

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
        $data = [];
        $user = Auth::user();

        $groups = Group::with('members')->whereHas('members', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        foreach ($groups as $group) {
            $data[] = [
                'id' => $group->id,
                'name' => $group->name,
                'code' => $group->code,
                'url_item' => '/groups/' . $group->code . '/items'
            ];
        }

        return ['groups' => $data];
    }

    public function getGroupItemList(string $group_code)
    {
        $group = Group::where('code', $group_code)->first();

        if (!$group) {
            throw new ResponseException("Group Not Found", 404);
        }

        $groupItems = GroupItem::where('group_id', $group->id)->get();

        if (count($groupItems) === 0) {
            throw new ResponseException("Group Item Not Found", 404);
        }

        return ['group_items' => $groupItems];
    }

    public function getGroupMemberList(string $group_code)
    {
        $data = [];
        $group = Group::where('code', $group_code)->first();

        if (!$group) {
            throw new ResponseException("Group Not Found", 404);
        }

        $groupMembers = GroupMember::with(['user', 'group'])->where('group_id', $group->id)->get();

        foreach ($groupMembers as $member) {
            $user = $member->user;
            $data[] = [
                'id' => $user->id,
                'name' => $user->username,
                'email' => $user->email,
                'phone' => $user->phone,
                'birth_date' => $user->birth_date,
                'account_number' => $user->account_number,
                'is_manager' => $member->is_manager
            ];
        }

        return ['group' => [
            'name' => $member->group->name,
            'description' => $member->group->description,
            'code' => $member->group->code,
            'url_add_item' => "/groups/" . $member->group->code . "/items"
        ], 'group_members' => $data];
    }

    public function payGroupItem(string $group_code, int $item_id, $amount)
    {
        $groupItem = GroupItem::where('id', $item_id)->first();

        $manager = GroupMember::where('group_id', $groupItem->group_id)->where('is_manager', true)->first();
        $receiverAccountNumber = $manager->user->account_number;

        $senderAccountNumber = Auth()->user()->account_number;

        $technoscapeAccessToken = $this->technoscapeRepository->createAccessToken(Auth()->user()->username, Auth()->user()->password)->accessToken;

        $this->technoscapeRepository->createTransaction($senderAccountNumber, $receiverAccountNumber, $amount, $technoscapeAccessToken);

        $transactionItem = ItemsTransaction::create([
            'user_id' => Auth()->user()->id,
            'group_items_id' => $groupItem->id
        ]);

        return ['transaction_item' => $transactionItem];
    }

    public function getHistoriesPayment(int $group_items_id)
    {
        $data = [];
        $historiesPayment = ItemsTransaction::with('user')->where('group_items_id', $group_items_id)->get();

        foreach ($historiesPayment as $history) {
            $data[] = [
                "id" => $history->user->id,
                "username" => $history->user->username,
                "email" => $history->user->email,
                "phone" => $history->user->phone,
                "birth_date" => $history->user->birth_date,
                "account_number" => $history->user->account_number,
            ];
        }

        return ['histories_payment' => $data];
    }
}

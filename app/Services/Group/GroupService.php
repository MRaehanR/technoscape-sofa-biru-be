<?php

namespace App\Services\Group;

interface GroupService
{
    public function createGroup(array $data);
    public function joinGroup(array $data);
    public function createGroupItem(array $data, string $group_code);
    public function groupList();
    public function getGroupItemList(string $group_code);
    public function getGroupMemberList(string $group_code);
    public function payGroupItem(string $group_code, int $item_id, $amount);
    public function getHistoriesPayment(int $group_items_id);
}

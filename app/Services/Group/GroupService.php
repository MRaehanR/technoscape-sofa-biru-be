<?php

namespace App\Services\Group;

interface GroupService 
{
    public function createGroup(array $data);
    public function joinGroup(array $data);
}
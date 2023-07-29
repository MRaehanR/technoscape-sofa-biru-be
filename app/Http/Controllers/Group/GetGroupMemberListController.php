<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Services\Group\GroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetGroupMemberListController extends Controller
{
    private $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($group_code)
    {
        $result = $this->groupService->getGroupMemberList($group_code);

        return response()->success('Success Get Group Member List', Response::HTTP_OK, $result);
    }
}

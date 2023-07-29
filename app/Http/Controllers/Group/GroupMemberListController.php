<?php

namespace App\Http\Controllers\Group;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Group\GroupService;
use App\Http\Requests\Group\GroupMemberListRequest;

class GroupMemberListController extends Controller
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
    public function __invoke(GroupMemberListRequest $request)
    {
        $result = $this->groupService->groupMemberList($request->all());

        return response()->success('Success Joined Group', Response::HTTP_OK, $result);
    }
}

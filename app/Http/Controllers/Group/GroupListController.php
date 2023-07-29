<?php

namespace App\Http\Controllers\Group;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\Group\GroupService;

class GroupListController extends Controller
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
    public function __invoke()
    {
        $result = $this->groupService->groupList();

        return response()->success('Success Sent Group List', Response::HTTP_OK, $result);
    }
}

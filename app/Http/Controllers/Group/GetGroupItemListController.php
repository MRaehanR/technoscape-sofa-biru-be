<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Group\GetGroupItemListRequest;
use App\Services\Group\GroupService;
use Illuminate\Http\Response;

class GetGroupItemListController extends Controller
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
    public function __invoke($group_id)
    {
        $result = $this->groupService->getGroupItemList($group_id);

        return response()->success('Success Sent Group List', Response::HTTP_OK, $result);
    }
}

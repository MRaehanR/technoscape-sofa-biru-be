<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Group\CreateGroupItemRequest;
use App\Services\Group\GroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreateGroupItemController extends Controller
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
    public function __invoke(CreateGroupItemRequest $request, $group_code)
    {
        $result = $this->groupService->createGroupItem($request->all(), $group_code);

        return response()->success('Success Created Group Item', Response::HTTP_CREATED, $result);
    }
}

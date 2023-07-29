<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Group\CreateGroupRequest;
use App\Services\Group\GroupService;
use Illuminate\Http\Response;

class CreateGroupController extends Controller
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
    public function __invoke(CreateGroupRequest $request)
    {
        $result = $this->groupService->createGroup($request->all());

        return response()->success('Success Created Group', Response::HTTP_CREATED, $result);
    }
}

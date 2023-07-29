<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Http\Requests\Group\JoinGroupRequest;
use App\Services\Group\GroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class JoinGroupController extends Controller
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
    public function __invoke(JoinGroupRequest $request)
    {
        $result = $this->groupService->joinGroup($request->all());

        return response()->success('Success Joined Group', Response::HTTP_CREATED, $result);
    }
}

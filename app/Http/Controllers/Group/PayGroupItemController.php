<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Services\Group\GroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PayGroupItemController extends Controller
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
    public function __invoke(Request $request, $group_code, $item_id)
    {
        $result = $this->groupService->payGroupItem($group_code, $item_id, $request->input('amount'));

        return response()->success('Success Joined Group', Response::HTTP_OK, $result);
    }
}

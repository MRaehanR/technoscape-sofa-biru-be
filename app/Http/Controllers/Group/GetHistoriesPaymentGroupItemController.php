<?php

namespace App\Http\Controllers\Group;

use App\Http\Controllers\Controller;
use App\Services\Group\GroupService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class GetHistoriesPaymentGroupItemController extends Controller
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
    public function __invoke($group_items_id)
    {
        $result = $this->groupService->getHistoriesPayment($group_items_id);

        return response()->success('Success Get Group Member List', Response::HTTP_OK, $result);
    }
}

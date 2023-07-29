<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $code = Str::upper(Str::random(6));

        $group = Group::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'code' => $code,
        ]);

        return response()->json($group);
    }
}

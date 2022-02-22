<?php

namespace App\Http\Controllers;

use App\Models\Wisdom;

use Illuminate\Http\Request;

class WisdomController extends Controller
{
    //

    public function getWisdoms()
    {
        $wisdoms = Wisdom::all();
        return response()->json($wisdoms);
    }

    public function getWisdom(Request $request)
    {
        $wisdom = Wisdom::find($request->wisdom_id);
        return response()->json($wisdom);
    }
}

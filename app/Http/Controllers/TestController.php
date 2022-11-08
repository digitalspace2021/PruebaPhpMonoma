<?php

namespace App\Http\Controllers;

use App\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function store(Request $request)
    {
        $test = new Test();
        $test->name = $request->name;
        $test->save();
        return response()->json($test);
    }
}

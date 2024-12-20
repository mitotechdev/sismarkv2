<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function showDataProgress(Request $request)
    {
        $data = $request->all();
        return $data;
    }

    public function testing()
    {
        return view('testing');
    }

    public function testingResponse(Request $request)
    {
        return response()->json($request->all());
    }
}

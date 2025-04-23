<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GetController extends Controller
{
    public function sayHello(){
        return response()->json(['message' => 'weh asbroder']);
    }
}


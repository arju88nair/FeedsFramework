<?php

namespace App\Http\Controllers;
use App\Model\user;
use Illuminate\Http\Request;
use App\Http\Requests;

class feedController extends Controller
{


    public function getFeeds(Request $request)
    {
        return feeds::getFeeds($request->all());
    }
}
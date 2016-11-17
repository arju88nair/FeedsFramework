<?php

namespace App\Http\Controllers;
use App\Model\user;
use Illuminate\Http\Request;
use App\Http\Requests;

class userController extends Controller
{


    public function index(Request $request)
    {
        return user::userCheck($request->all());
    }
}
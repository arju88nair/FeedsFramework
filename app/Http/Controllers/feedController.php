<?php

namespace App\Http\Controllers;

use App\Model\user;
use Illuminate\Http\Request;
use App\Http\Requests;

class feedController extends Controller
{


    public function getFeeds(Request $request)
    {


        if (!$request->has('sessionHandle')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Session Handle is missing'))->header('Content-Type', 'application/json');
        }

        if (!$request->has('uId')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Unique device ID is missing'))->header('Content-Type', 'application/json');
        }

        if (!$request->has('ids')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'IDs are missing'))->header('Content-Type', 'application/json');
        }
        return feeds::getFeeds($request->all());
    }


    public function getFeedIds(Request $request)
    {

        if (!$request->has('sessionHandle')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Session Handle is missing'))->header('Content-Type', 'application/json');
        }


        if (!$request->has('uId')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Unique device ID is missing'))->header('Content-Type', 'application/json');
        }
        return feeds::getFeeds($request->all());
    }


    public function like(Request $request)
    {

        if (!$request->has('session')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Session Handle is missing'))->header('Content-Type', 'application/json');
        }
        if (!$request->has('uID')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Unique device ID is missing'))->header('Content-Type', 'application/json');
        }
        if (!$request->has('feedId')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Feed ID is missing'))->header('Content-Type', 'application/json');
        }

        return feeds::like($request->all());
    }


    public function unlike(Request $request)
    {

        if (!$request->has('session')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Session Handle is missing'))->header('Content-Type', 'application/json');
        }
        if (!$request->has('uID')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Unique device ID is missing'))->header('Content-Type', 'application/json');
        }
        if (!$request->has('feedId')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Feed ID is missing'))->header('Content-Type', 'application/json');
        }
        return feeds::unlike($request->all());
    }
}
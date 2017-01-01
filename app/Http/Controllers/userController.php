<?php

namespace App\Http\Controllers;

use App\Model\user;
use Illuminate\Http\Request;
use App\Http\Requests;

class userController extends Controller
{


    public function index(Request $request)
    {


        if (!$request->has('authType')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'AuthType is missing'))->header('Content-Type', 'application/json');
        }
        if ($request['authType'] != "Guest") {
            if (!$request->has('userID')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'User ID is missing'))->header('Content-Type', 'application/json');
            }
            if (!$request->has('password')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Password is missing'))->header('Content-Type', 'application/json');
            }
            if (!$request->has('imageUrl')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Image URL is missing'))->header('Content-Type', 'application/json');
            }
            if (!$request->has('clientPlf')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Client Plf is missing'))->header('Content-Type', 'application/json');
            }
            if (!$request->has('userName')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'User name is missing'))->header('Content-Type', 'application/json');
            }
            if (!$request->has('deviceType')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Device type is missing'))->header('Content-Type', 'application/json');
            }
            if (!$request->has('appVersion')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'App version is missing'))->header('Content-Type', 'application/json');
            }
            if (!$request->has('uniqueDeviceID')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Unique DeviceID is missing'))->header('Content-Type', 'application/json');
            }
            if (!$request->has('pushNotificationID')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'PushNotificationID is missing'))->header('Content-Type', 'application/json');
            }
            if (!$request->has('location')) {
                $statusCode = config('StatusCodes.MISSING_PARAMETER');
                return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Location is missing'))->header('Content-Type', 'application/json');
            }
        }
        if (!$request->has('uniqueDeviceID')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Unique DeviceID is missing'))->header('Content-Type', 'application/json');
        }
        return user::userCheck($request->all());
    }


    public function feedCount(Request $request)
    {
        if (!$request->has('sessionHandle')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Session Handle is missing'))->header('Content-Type', 'application/json');
        }
        if (!$request->has('action')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Action is missing'))->header('Content-Type', 'application/json');
        }
        if (!$request->has('feedId')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Feed ID is missing'))->header('Content-Type', 'application/json');
        }


        return feedCount::updateCount($request->all());
    }



    public function comments(Request $request)
    {
        if (!$request->has('sessionHandle')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'session Handle is missing'))->header('Content-Type', 'application/json');
        }
        if (!$request->has('uId')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Unique ID is missing'))->header('Content-Type', 'application/json');
        }
        if (!$request->has('comment')) {
            $statusCode = config('StatusCodes.MISSING_PARAMETER');
            return response(array('code' => '1', "status" => "failure", 'statusCode' => $statusCode, 'message' => 'Comment is missing'))->header('Content-Type', 'application/json');
        }
        return comments::comments($request->all());
    }



    public function admin(){

        return view('login');

    }




}
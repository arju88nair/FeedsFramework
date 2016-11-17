<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Date;
use Jenssegers\Mongodb\Schema\Blueprint;

class user extends Eloquent
{
    //


    protected $connection = "mongodb";
    protected $collection = "user";

    public static function login()
    {
        $model = new self();
        return $model::all();
        $model->name = "kl";
        $model->save();
        return $model;
    }


    public static function userCheck($input)
    {
        $model = new self();
        $name = $model->name = $input['userName'];
        $emailId = $model->userId = $input['userID'];
        $authenticationType = $model->auth_type = $input['authType'];
        $snsHandle = $model->snsHandle = $input['password'];
        $platform = $model->clientPlf = $input['clientPlf'];
        $model->imageUrl = $input['imageUrl'];
        $device_model = $model->deviceType = $input['deviceType'];
        $model->appVersion = $input['appVersion'];
        $model->uniqueDeviceID = $input['uniqueDeviceID'];
        $push = $model->pushNotificationID = $input['pushNotificationID'];
        $location = $model->userLocation = $input['location'];
        $array_auth = ['Google', 'LinkedIn', 'Facebook', 'Email', 'Guest'];
        $array_plt = ['android', 'ios', 'webApp', 'Guest'];
        $array_device = ['smartphone', 'tablet', 'Guest'];
        $userTypes = ['guest', 'normal'];
        $testEmailArray = ['mail2appzoy@gmail.com', 'rahulsadafule@gmail.com', 'appzoytest@gmail.com', 'aditya.shankar@gmai.com', 'dheeraj@ipl.edu.in', 'Kaushik.Balasubramanian@ipl.edu.in', 'marya.wani@ipl.edu.in', 'padmaja.narsipur@ipl.edu.in', 'pshah@ipl.edu.in', 'rahul@ipl.edu.in', 'rahul@appzoy.com', 'arju88nair@gmail.com', 'ramanan@productleadership.com', 'rajesh@ipl.edu.in', 'rohan.krishna@ipl.edu.in', 'aditya.shankar@ipl.edu.in', 'jobin.john@ipl.edu.in', 'kavitha@appzoy.com', 'ramanan@ipl.edu.in', 'seema.joshi@ipl.edu.in', 'shwetha@clearlyblue.in', 'vishy@ipl.edu.in', 'pinkesh.shah@ipl.edu.in', 'rahulsadafule@gmail.com', 'rishikesh.pathak16@gmail.com', 'bharath.keshava.25@gmail.com'];


        if (!in_array($authenticationType, $array_auth)) {
            return array("status" => "failure", "resultCode" => "1", "message" => "Incorrect authentication ");
        }
        if (!in_array($platform, $array_plt)) {
            return array("status" => "failure", "resultCode" => "1", "message" => "Incorrect platform ");
        }
        if (!in_array($device_model, $array_device)) {
            return array("status" => "failure", "resultCode" => "1", "message" => "Incorrect device ");
        }
        if ($authenticationType == "Guest") {
            $model->name = "";
            $emailId = $model->userId = "";
            $authenticationType = $model->auth_type = "";
            $snsHandle = $model->snsHandle = "";
            $model->userType = "Guest";
            $platform = $model->clientPlf = "";
            $model->imageUrl = "http://blog.ramboll.com/fehmarnbelt/wp-content/themes/ramboll2/images/profile-img.jpg";
            $device_model = $model->deviceType = $input['deviceType'];
            $model->appVersion = $input['appVersion'];
            $model->uniqueDeviceID = $input['uniqueDeviceID'];
            $model->pushNotificationID = $input['pushNotificationID'];
            $model->userLocation = $input['location'];
            if (!isset($input['uniqueDeviceID']) || $input['uniqueDeviceID'] == "" || $input['uniqueDeviceID'] == null) {
                return array("status" => "failure", "resultCode" => "1", "message" => "Incorrect Device Id ");
            } else {
                $users = $model::where('auth_type', '=', $authenticationType)->where('uniqueDeviceID', '=', $input['uniqueDeviceID'])->first();
                if (!isset($users) || count($users) == 0) {
                    $model->liked = array();
                    $model->feedCount = 0;
                    $uniqueID = $model->usrSessionHdl = "Guest";
                    $model->save();
                    $date = $model['created_at'];
                    return array("status" => "success", "resultCode" => "1", "userType" => "Guest", "message" => "New user created", "sessionHandle" => "Guest",  'createdAt' => $date);
                } else {


                    return array("status" => "success", "resultCode" => "1", "userType" => "Guest", "message" => "User Already Present", "sessionHandle" => "Guest",  'createdAt' => $users['created_at']);


                }
            }

        } else {


            $uniqueID = $model->usrSessionHdl = uniqid();
            $users = $model::where('userId', '=', $emailId)->first();
            $idUser = $model::where('uniqueDeviceID', '=', $input['uniqueDeviceID'])->first();


            if (!isset($users) || count($users) == 0) {
                $model->liked = array();
                if (in_array($emailId, $testEmailArray)) {
                    $model->userType="Test";
                    $userType="Test";
                }
                else{
                    $model->userType="Normal";
                    $userType="Normal";
                }

                $model->save();
                return array("status" => "success", "resultCode" => "01", "userType" => $userType, "message" => "New user created", "sessionHandle" => $uniqueID,);


            } else {
                if (in_array($emailId, $testEmailArray)) {
                    $model->userType = "Test";
                    $userType = "Test";
                } else {
                    $model->userType = "Normal";
                    $userType = "Normal";
                }


                    $userHandle = $users['usrSessionHdl'];


                $new = $model::where('userId', '=', $emailId)->first();
                $new->pushNotificationID = $push;
                $new->name = $input['userName'];
                $new->name = $input['userName'];
                $new->auth_type = $input['authType'];
                $new->snsHandle = $input['password'];
                $new->clientPlf = $input['clientPlf'];
                $new->imageUrl = $input['imageUrl'];
                $new->deviceType = $input['deviceType'];
                $model->userLocation = $input['location'];
                $new->appVersion = $input['appVersion'];
                $new->uniqueDeviceID = $input['uniqueDeviceID'];
                $new->save();


                return array("status" => "success", "resultCode" => "01", "userType" => $userType, "message" => "User already present", "sessionHandle" => $userHandle);


            }

        }

    }

}


<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Date;
use Jenssegers\Mongodb\Schema\Blueprint;
use App\Model\Tests;
use View;
use Redirect;
use Input;


use App\Http\Requests;

class comments extends Eloquent
{

    protected $connection = 'mongodb';
    protected $collection = "comments";

// For user inputs about adding contents and suggestions .Similar with feedback !

    public static function comments($input)
    {
        $model=new self();
        $session=$input['sessionHandle'];
        $uID=$input['uId'];
        $comment=$input['comment'];
        $user=addUser::where('usrSessionHdl','=',$session)->where('uniqueDeviceID','=',$uID)->first();
        if($user==null || $user==[])
        {
            return array("status" => "failure", "resultCode" => "1", "message" => "Can't find the user");
        }

        $userId=$user['userId'];
        if($userId == "" ||$userId == null)
        {
            $userId= "Guest";
        }
        $model->uID=$uID;
        $model->userId=$userId;
        $model->sessionHandle=$session;
        $model->status="New";
        $model->comments=htmlspecialchars($comment, ENT_QUOTES | ENT_SUBSTITUTE | ENT_DISALLOWED | ENT_HTML5, 'UTF-8');
        $isSaved=$model->save();
        if($isSaved)
        {
            return array("status" => "success", "resultCode" => "0", "message" => "Successfully added");

        }
        return array("status" => "failure", "resultCode" => "1", "message" => "Please try again later");




    }


}
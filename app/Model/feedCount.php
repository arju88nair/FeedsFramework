<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Date;
use Jenssegers\Mongodb\Schema\Blueprint;
use View;
use Redirect;
use Input;


class feedCount extends Eloquent
{
    //
    protected $connection = "mongodb";
    protected $collection = "feed_counts";


    public static function updateCount($input)
    {

        //  Book keeping API for logging the required actions for statistical purpose !


        $model = new self();
        $session = $input['sessionHandle'];
        $feedId = $input['feedId'];
        $action = $input['action'];
        $userTypes = ['audio', 'bookmark', 'share', 'source'];
        if (!in_array($action, $userTypes)) {
            return array("status" => "failure", "resultCode" => "1", "message" => "Incorrect action ");
        }
        $check = addUser::where('usrSessionHdl', '=', $session)->first();
        if (isset($check) || count($check) != 0) {
            $feed = feeds::where('_id', '=', $feedId)->first();
            if (isset($feed) || count($feed) != 0) {

                $countCheck = $model::where('userId', '=', $session)->where('feedId', '=', $feedId)->where('action', '=', $action)->get();

                if (!isset($countCheck) || count($countCheck) == 0) {

                    $model->userId = $session;
                    $model->feedId = $feedId;
                    $model->feedTitle = $feed['feedTitle'];
                    $model->action = $action;
                    $saved = $model->save();
                    if ($saved) {
                        return array(
                            "status" => "success",
                            "resultcode" => "0",
                            "message" => "Successfully saved"
                        );

                    } //$saved
                    else {
                        return array(
                            "status" => "error",
                            "resultcode" => "1",
                            "message" => "Please try again"
                        );

                    }

                } //!isset($countCheck) || count($countCheck) == 0
                else {
                    return array(
                        "status" => "error",
                        "resultcode" => "1",
                        "message" => "Already viewed"
                    );

                }
            } //isset($feed) || count($feed) != 0
            else {
                return array(
                    "status" => "error",
                    "resultcode" => "1",
                    "message" => "Incorrect feed Id received"
                );

            }


        } //isset($check) || count($check) != 0
        else {
            return array(
                "status" => "error",
                "resultcode" => "1",
                "message" => "Incorrect session received"
            );

        }
    }


}

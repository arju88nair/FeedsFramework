<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Date;
use Jenssegers\Mongodb\Schema\Blueprint;

class feeds extends Eloquent
{
    //


    protected $connection = "mongodb";
    protected $collection = "feeds";


    public static function getFeed($input)
    {
        $model = new self();
        $id = $input['sessionHandle'];
        $uid = $input['uId'];
        $idArray = $input['ids'];

        foreach ($idArray as $idA) {
            $feed = $model::where('_id', '=', $idA)->first();
            if ($feed == null) {
                return array(
                    "status" => "error",
                    "resultCode" => "0",
                    "message" => "One or many of the feed(s) can't be found"
                );
            }
        }
        $user = user::where('usrSessionHdl', '=', $id)->where('uniqueDeviceID', '=', $uid)->first();
        if ($id == "Guest") {

            $guest = user::where('uniqueDeviceID', '=', $input['uId'])->where('usrSessionHdl', '=', 'Guest')->first();
            if (!isset($guest) || count($guest) == 0) {
                return array(
                    "status" => "error",
                    "resultCode" => "0",
                    "message" => "User Can't Be Found"
                );

            } else {


                $feedArray = array();

                foreach ($idArray as $id) {
                    $feed = $model::where('_id', '=', $id)->first();
                    array_push($feedArray, $feed);
                }

                $feed = $feedArray;
                $array = array();
                foreach ($feed as $item) {
                    $userArray = $guest['liked'];

                    $feedid = $item['_id'];
                    if (in_array($feedid, $userArray)) {
                        $item->liked = "Yes";
                    } else {
                        $item->liked = "No";

                    }
                    array_push($array, $item);
                }
                $category = extra::first();


                return array(
                    "status" => "success",
                    "resultCode" => "1",
                    "userFeed" => $array,
                    'category' => $category['categories'],
                    'feedCount' => $guest['feedCount']
                );

            }

        } else {


            if (!isset($user) || count($user) == 0) {
                return array(
                    "resultCode" => "1",
                    "status" => "error",
                    "message" => "User can't be found"
                );


            } else {
                $feedArray = array();

                foreach ($idArray as $id) {
                    $feed = $model::where('_id', '=', $id)->first();
                    array_push($feedArray, $feed);
                }

                $feed = $feedArray;
                $array = array();
                foreach ($feed as $item) {
                    $userArray = $user['liked'];

                    $feedid = $item['_id'];
                    if (in_array($feedid, $userArray)) {
                        $item->liked = "Yes";
                    } else {
                        $item->liked = "No";

                    }
                    array_push($array, $item);
                }
                $category = extra::first();


                return array(
                    "status" => "success",
                    "resultCode" => "1",
                    "userFeed" => $array,
                    'category' => $category['categories'],
                    'feedCount' => 0
                );


            }
        }
    }


    public static function getFeedIds($input)
    {

        $session = $input['sessionHandle'];
        $uID = $input['uId'];
        $user = addUser::where('uniqueDeviceID', '=', $uID)->where('usrSessionHdl', '=', $session)->get();
        if (count($user) != 0) {

            $feedArray = array();

            $feeds = mainFeed::all();

            foreach ($feeds as $feed) {
                array_push($feedArray, $feed);
            }
            return array(
                "code" => "0",
                "status" => "success",
                "feedIdArray" => array_reverse($feedArray)

            );


        } else {
            $statusCode = config('StatusCodes.DATABASE_SAVE_ERROR');

            return array(
                "code" => "1",
                "status" => "error",
                "statusCode" => $statusCode
            );
        }
    }

    public static function like($input)
    {

        $session = $input['session'];
        $uId = $input['uID'];
        $user = addUser::where('usrSessionHdl', '=', $session)->where('uniqueDeviceID', '=', $uId)->first();
        $feed = feeds::where('_id', '=', $input['feedId'])->first();
        $feeds = mainFeed::where('_id', '=', $input['feedId'])->first();
        Log::info("Liked feed API with " . $session . " UID " . $uId . " and feed  " . $input['feedId']);

        if (empty($feed)) {
            $statusCode = config('StatusCodes.CAN\'T FIND THE REQUEST');
            return array("resultCode" => "1", "status" => "error", 'statusCode' => $statusCode, "message" => "Requested feed not found");
        }
        $feedId = $input['feedId'];
        if (!isset($user) || count($user) == 0) {
            $statusCode = config('StatusCodes.CAN\'T FIND THE REQUEST');
            return array("resultCode" => "1", "status" => "error", 'statusCode' => $statusCode, "message" => "User can't be found", "likeCount" => $feed['likeCount']);


        } else {
            if (isset($user['liked'])) {
                $ar = $user['liked'];
                if (in_array($input['feedId'], $user['liked'])) {
                    $statusCode = config('StatusCodes.INVALID REQUEST');
                    return array("resultCode" => "1", "status" => "error", 'statusCode' => $statusCode, "message" => "Already liked", "likeCount" => $feed['likeCount']);
                } else {
                    if (!isset($feed['likeCount'])) {
                        $count = $feed['likeCount'] = 0;
                        $count = $count + 1;
                        $feed->likeCount = $count;
                        $feeds->likeCount = $count;
                        $feeds->save();
                        $feed->save();

                    } else {

                        $count = $feed['likeCount'];
                        $count = $count + 1;
                        $feed->likeCount = $count;
                        $feeds->likeCount = $count;
                        $feeds->save();
                        $feed->save();

                    }
                    array_push($ar, $feedId);
                    $user->liked = $ar;
                    $user->save();

                    return array("resultCode" => "0", "status" => "success", "message" => "Successfully Liked", "likeCount" => $feed['likeCount']);
                }

            }

        }
    }


    public static function unlike($input)
    {

        $session = $input['session'];
        $uId = $input['uID'];
        $user = addUser::where('usrSessionHdl', '=', $session)->where('uniqueDeviceID', '=', $uId)->first();
        $feed = feeds::where('_id', '=', $input['feedId'])->first();
        $feeds = mainFeed::where('_id', '=', $input['feedId'])->first();
        Log::info("Liked Feed API with " . $session . " UID " . $uId . " and feed  " . $input['feedId']);

        if (empty($feed)) {
            $statusCode = config('StatusCodes.CAN\'T FIND THE REQUEST');
            return array("resultCode" => "1", "status" => "error", 'statusCode' => $statusCode, "message" => "Requested feed not found");
        }
        $feedId = $input['feedId'];
        if (!isset($user) || count($user) == 0) {
            $statusCode = config('StatusCodes.CAN\'T FIND THE REQUEST');
            return array("resultCode" => "1", "status" => "error", 'statusCode' => $statusCode, "message" => "User can't be found", "likeCount" => $feed['likeCount']);


        } else {
            if (in_array($input['feedId'], $user['liked']) == False) {
                $statusCode = config('StatusCodes.INVALID REQUEST');
                return array("resultCode" => "1", "status" => "error", 'statusCode' => $statusCode, "message" => "Already unliked", "likeCount" => $feed['likeCount']);
            } else {

                if (isset($feed) || count($feed) == 0) {

                    if (!isset($feed['likeCount'])) {
                        $count = $feed['likeCount'] = 0;
                        $feed->likeCount = $count;
                        $feed->save();
                        $feeds->likeCount = $count;
                        $feeds->save();
                    } else {
                        $count = $feed['likeCount'];
                        if ($count > 0) {
                            $ar = $user['liked'];
                            $key = array_search($input['feedId'], $user['liked']);
                            unset($ar[$key]);
                            $user->liked = $ar;
                            $user->save();
                            $count = $count - 1;
                            $feed->likeCount = $count;
                            $feed->save();
                            $feeds->likeCount = $count;
                            $feeds->save();

                        }

                        return array("resultCode" => "0", "status" => "success", "message" => "Successfully Unliked", "likeCount" => $feed['likeCount']);


                    }

                } else {
                    return array("resultCode" => "1", "status" => "error", "message" => "Feed can't be found");

                }

            }
        }


    }

}


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
        $cat = $input['category'];
        $uid = $input['uId'];
        $idArray = $input['ids'];
        $feedArray = array();

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
        $user = user::where('usrSessionHdl', '=', $id)->first();
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


                    $categories = 'All,Product Management,Agile,Product Marketing,UX,Growth Hacking,Roadmapping,Sales Enablement,Career,Leadership,Executive Presence';
                    $url = 'https://files.slack.com/files-pri/T04T20JQR-F1X3LFLKC/product_management.png?pub_secret=b4594be939,https://files.slack.com/files-pri/T04T20JQR-F1X3LFLKC/product_management.png?pub_secret=b4594be939,https://files.slack.com/files-pri/T04T20JQR-F1X3LA97C/agile.png?pub_secret=168e02e6ed,https://files.slack.com/files-pri/T04T20JQR-F1X3B0T1V/product_marketing.png?pub_secret=c86510df6d,https://files.slack.com/files-pri/T04T20JQR-F1X32A06S/ux_icon.png?pub_secret=4d8a67cca5,https://files.slack.com/files-pri/T04T20JQR-F1X3FB3S5/growth_hack.png?pub_secret=7bd2efd880,https://files.slack.com/files-pri/T04T20JQR-F1X3294J2/road_map.png?pub_secret=8c0e9ba2dc,https://files.slack.com/files-pri/T04T20JQR-F1X3B1M2T/sales.png?pub_secret=5af5c105d1,https://files.slack.com/files-pri/T04T20JQR-F1X3243K8/career.png?pub_secret=6349569c46,https://files.slack.com/files-pri/T04T20JQR-F1X3AUW7R/leadership_icon.png?pub_secret=920e647a14,https://files.slack.com/files-pri/T04T20JQR-F1X3LD5AN/executive_presence.png?pub_secret=4316358c71';

                    return array(
                        "status" => "success",
                        "resultCode" => "1",
                        "categories" => $categories,
                        'image' => $url,
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
        $user = user::where('uniqueDeviceID', '=', $uID)->where('usrSessionHdl', '=', $session)->get();
        if (count($user) != 0) {

            $arr = array();
            $array = array();

            $feeds = feeds::where('feedStatus', '=', 'Published')->get();
            foreach ($feeds as $feed) {
                unset($feed['category']);
                unset($feed['summarised']);
                unset($feed['addedBy']);
                unset($feed['feedOwner']);
                unset($feed['feedSchedule']);
                unset($feed['feedType']);
                unset($feed['trending']);
                unset($feed['location']);
                unset($feed['feedDate']);
                unset($feed['feedTitle']);
                unset($feed['feedImage']);
                unset($feed['likeCount']);
                unset($feed['feedContent']);
                unset($feed['feedSource']);
                unset($feed['feedSourceTag']);
                unset($feed['feedSourceTag']);
                unset($feed['feedAudio']);
                unset($feed['created_at']);
                unset($feed['feedGCM']);


            }

            return array(
                "code" => "0",
                "status" => "success",
                "feedIdArray" => $feeds

            );


        } else {
            return array(
                "code" => "1",
                "status" => "error"
            );
        }
    }


}


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



}
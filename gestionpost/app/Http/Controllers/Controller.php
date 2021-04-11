<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\GenerateCode;
use App\Traits\GeneratePassword;

class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, GenerateCode,GeneratePassword;
}

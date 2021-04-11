<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\AuthorizationException;

class ApiController extends Controller
{
    use ApiResponse;


    public function  __construct()
    {
        $this->middleware(['auth:api','admin_user']);
    }

    public function allowedAdminAction(){
        throw new AuthorizationException('This action is not allowed');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends BaseController
{
    public function getUsersCount()
    {
        $count = $this->userRepository->getUsersCount();

        return response()->json([
            'status' => 'success',
            'data' => $count,
        ], Response::HTTP_OK);
    }

    public function getAuthUser()
    {
        $user = $this->user;

        return response()->json([
            'status' => 'success',
            'data' => $user,
        ], Response::HTTP_OK);
    }

}


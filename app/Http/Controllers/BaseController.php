<?php

namespace App\Http\Controllers;

use App\Models\Base;
use App\Repository\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\LetterRepository;
use App\Repository\AffirmationRepository;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    protected $user;
    protected $letterRepository;
    protected $affirmationRepository;

    const PERMISSION_DENIED = 'permission denied';
    const NOT_FOUND = 'not found';
    const NO_DATA = 'no data';
    const SOMETHING_WENT_WRONG = 'something went wrong';

    public function __construct()
    {
        parent::__construct();
     //   $this->middleware('auth:api');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->letterRepository = new LetterRepository();
            $this->affirmationRepository = new AffirmationRepository();

            return $next($request);
        });
    }

    public static function httpBadRequest($error_message, $status = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'success' => false,
            'error_code' => $status,
            'error_message' => __($error_message)
        ], $status);
    }

}

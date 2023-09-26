<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Repository\UserRepository;
use App\Repository\CountryRepository;
use App\Repository\LetterRepository;
use App\Repository\AffirmationRepository;
use App\Repository\ReportRepository;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    protected $user;
    protected $userRepository;
    protected $countryRepository;
    protected $letterRepository;
    protected $affirmationRepository;
    protected $reportRepository;

    const PERMISSION_DENIED = 'permission denied';
    const NOT_FOUND = 'not found';
    const NO_DATA = 'no data';
    const SOMETHING_WENT_WRONG = 'something went wrong';

    public function __construct()
    {
        // $this->middleware('auth:sanctum');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->userRepository = new UserRepository();
            $this->countryRepository = new CountryRepository();
            $this->letterRepository = new LetterRepository();
            $this->reportRepository = new ReportRepository();
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

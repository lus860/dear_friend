<?php

namespace App\Http\Controllers;

use App\Repository\BaseRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repository\CountryRepository;

class CountryController extends Controller
{
    protected $countryRepository;

    public function index()
    {
        $this->countryRepository = new CountryRepository();
        $countries = $this->countryRepository->getCountries();

        if (!$countries) {
            return response()->json([
                'success' => false,
                'error_code' => Response::HTTP_NOT_FOUND,
                'error_message' => __('not found')
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $countries,
        ], Response::HTTP_OK);
    }

}

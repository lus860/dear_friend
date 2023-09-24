<?php

namespace App\Http\Controllers;

use App\Http\Requests\Affirmation\AffirmationStoreRequest;
use App\Http\Requests\Letter\LetterEditRequest;
use App\Models\Affirmation;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AffirmationController extends BaseController
{
    public function index()
    {
        $affirmations = $this->affirmationRepository->getAffirmations();

        if (!$affirmations) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $affirmations,
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $affirmation = $this->affirmationRepository->getAffirmationById($id);

        if (!$affirmation) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $affirmation,
        ], Response::HTTP_OK);
    }

    public function store(AffirmationStoreRequest $request)
    {
        $letter = Affirmation::createAffirmation($request);
        if ($letter) {
            return response()->json([
                'status' => 'success',
                'data' => $letter,
            ], Response::HTTP_CREATED);
        }

        return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
    }

    public function update(LetterEditRequest $request, $id)
    {
        $affirmation = $this->affirmationRepository->getAffirmationById($id);

        if (!$affirmation) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        $res = Affirmation::updateAffirmation($request, $affirmation);

        if ($res) {
            return response()->json([
                'status' => 'success',
                'data' => $affirmation->refresh(),
            ], Response::HTTP_OK);
        } else {
            return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
        }
    }

    public function delete($id)
    {
        $affirmation = $this->affirmationRepository->getAffirmationById($id);

        if (!$affirmation) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }
        $res = $affirmation->delete();

        if ($res) {
            return response()->json([
                'status' => 'success',
            ], Response::HTTP_OK);
        } else {
            return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
        }
    }

}

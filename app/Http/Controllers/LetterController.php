<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Letter\LetterEditRequest;
use App\Http\Requests\Letter\LetterStoreRequest;

class LetterController extends BaseController
{
    public function index(Request $request)
    {
        if ($this->user->hasRole('admin')) {
            $status = null;
            if ($request->has('status') && $request->status) {
                $status = $request->status;
            }
            $letters = $this->letterRepository->getLetters($status, $request);
        } else {
            $status = Letter::APPROVED_STATUS;
            $letters = $this->letterRepository->getLetters($status, $request, $this->user->id);
        }

        if (!$letters) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $letters,
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $letter = $this->letterRepository->getLetterById($id);

        if (!$letter) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $letter,
        ], Response::HTTP_OK);
    }

    public function store(LetterStoreRequest $request)
    {
        $letter = Letter::createLetter($request, $this->user->id);

        if ($letter) {
            if ($request->hasFile('attachment')) {
                FileController::saveLetterAttachment($letter, $request->file('attachment'));
            }

            return response()->json([
                'status' => 'success',
                'data' => $letter,
            ], Response::HTTP_CREATED);
        }

        return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
    }

    public function update(LetterEditRequest $request, $id)
    {
        $letter = $this->letterRepository->getLetterById($id);

        if (!$letter) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        if (!$this->user->hasRole('admin') && $letter->user_id != $this->user->id) {
            return self::httpBadRequest(self::PERMISSION_DENIED);
        }

        $letter = Letter::updateLetter($request, $letter, $this->user);

        if ($letter) {
            if ($request->hasFile('attachment')) {
                FileController::saveLetterAttachment($letter, $request->file('attachment'));
            }
            return response()->json([
                'status' => 'success',
                'data' => $letter->refresh(),
            ], Response::HTTP_OK);
        } else {
            return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
        }
    }

    public function destroy($id)
    {
        $letter = $this->letterRepository->getLetterById($id);

        if (!$letter) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        if (!$this->user->hasRole('admin') && $letter->user_id != $this->user->id) {
            return self::httpBadRequest(self::PERMISSION_DENIED);
        }

        $res = $letter->delete();

        if ($res) {
            FileController::deleteLetterAttachment($letter);
            return response()->json([
                'status' => 'success',
            ], Response::HTTP_OK);
        } else {
            return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
        }
    }

    public function changeStatus(Request $request)
    {
        if (!$this->user->hasRole('admin')) {
            return self::httpBadRequest(self::PERMISSION_DENIED);
        }

        $letter = $this->letterRepository->getLetterById($request->id);

        if (!$letter) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        $letter->moderation_status = $request->status;

        if ($letter->save()) {
            return response()->json([
                'status' => 'success',
                'data' => $letter->refresh(),
            ], Response::HTTP_OK);
        } else {
            return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
        }
    }

}

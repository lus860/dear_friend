<?php

namespace App\Repository;

use App\Models\Letter as Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LetterRepository extends BaseRepository
{
    protected $model;

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getLetters($status, $request, $userId = null)
    {
        $query = $this->startCondition()->with(['user', 'reports']);
        if ($status) {
            $query->where('moderation_status', $status);
        }

        if ($userId) {
            $query->orWhere('user_id', $userId);
        }

        $per_page = env('PER_PAGE', 21);

        if ($request->per_page) {
            $per_page = $request->per_page;
        }

        return $query->orderBy('created_at', 'desc')
            ->paginate($per_page);
    }

    public function getLetterById($id)
    {
        return $this->startCondition()->where('id', $id)->with(['user', 'reports'])->first();
    }

}


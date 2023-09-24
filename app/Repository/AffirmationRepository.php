<?php

namespace App\Repository;

use App\Models\Affirmation as Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AffirmationRepository extends BaseRepository
{
    protected $model;

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getAffirmations()
    {
        $query = $this->startCondition()->orderBy('created_at', 'desc');

        return $query->paginate(env('PER_PAGE', 21));
    }

    public function getAffirmationById($id)
    {
        return $this->startCondition()->where('id', $id)->first();
    }
}


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

   public function getLetters()
   {
       $query = $this->startCondition()->with(['user', 'reports'])->orderBy('created_at', 'desc');

       return $query->paginate(env('PER_PAGE', 21));
   }

    public function getLetterById($id)
    {
        return $this->startCondition()->where('id', $id)->with(['user', 'reports'])->first();
    }
}


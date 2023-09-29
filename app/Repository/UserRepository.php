<?php

namespace App\Repository;

use App\Models\User as Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UserRepository extends BaseRepository
{
    protected $model;

    protected function getModelClass()
    {
        return Model::class;
    }

   public function getUsers()
   {
       $query = $this->startCondition()->with(['letters', 'reports', 'roles'])->orderBy('created_at', 'desc');

       return $query->paginate(env('PER_PAGE', 21));
   }

    public function getUserById($id)
    {
        return $this->startCondition()->where('id', $id)->with(['letters', 'reports', 'roles'])->first();
    }

    public function getUsersCount()
    {
        return $this->startCondition()->count();
    }

}


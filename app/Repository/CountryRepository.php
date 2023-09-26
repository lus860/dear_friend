<?php

namespace App\Repository;

use App\Models\Country as Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CountryRepository extends BaseRepository
{
    protected $model;

    protected function getModelClass()
    {
        return Model::class;
    }

   public function getCountries()
   {
       return $this->startCondition()->get();
   }

}


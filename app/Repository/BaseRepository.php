<?php

namespace App\Repository;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    abstract protected function getModelClass();

    protected function startCondition()
    {
        return clone $this->model;
    }

}

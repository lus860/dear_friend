<?php

namespace App\Repository;

use App\Models\Report as Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReportRepository extends BaseRepository
{
    protected $model;

    protected function getModelClass()
    {
        return Model::class;
    }

    public function getReports()
    {
        $query = $this->startCondition()->with(['user', 'letter'])->orderBy('created_at', 'desc');

        return $query->paginate(env('PER_PAGE', 21));
    }

    public function getReportById($id)
    {
        return $this->startCondition()->with(['user', 'letter'])->where('id', $id)->first();
    }

}


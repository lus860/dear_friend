<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Base
{
    use HasFactory;

    protected $fillable = ['letter_id', 'user_id', 'reason'];

    // A report belongs to one letter
    public function letter() {
        return $this->belongsTo(Letter::class);
    }

    // A report is made by one user
    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function createReport($request, $user_id)
    {
        $report = new self();
        $report->reason = $request->reason;
        $report->letter_id = $request->letter_id;
        $report->user_id = $user_id;

        if ($report->save()) {
            return $report;
        }
        return false;
    }

    public static function updateReport($request, $report)
    {
        $fields = $request->only($report->getFillable());
        $report->fill($fields);
        if ($report->save()) {
            return $report;
        }

        return false;
    }

}

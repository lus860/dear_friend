<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'content', 'submission_date', 'moderation_status'];

    // A letter belongs to one user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // A letter can have many reports
    public function reports() {
        return $this->hasMany(Report::class);
    }

    protected $casts = [
        'submission_date' => 'datetime',
    ];

    public static function createLetter($request, $user_id)
    {
        $letter = new self();
        $letter->content = $request->content;
        $letter->user_id = $user_id;
        $letter->submission_date = Carbon::now('UTC');
        if ($letter->save()) {
            return $letter;
        }
        return false;
    }

    public static function updateLetter($request, $letter)
    {
        $letter->content = $request->content;
        $letter->moderation_status = $request->moderation_status;
        if ($letter->save()) {
            return $letter;
        }
        return false;
    }

}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Letter extends Base
{
    use HasFactory;

    const PENDING_STATUS = 'PENDING';
    const APPROVED_STATUS = 'APPROVED';
    const REJECTED_STATUS = 'REJECTED';

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

    public static function createLetter($request, $user)
    {
        $letter = new self();
        $letter->content = $request->content;
        $letter->user_id = $user->id;
        $letter->submission_date = Carbon::now('UTC');
        if ($user->hasRole('admin')) {
            $letter->moderation_status = self::APPROVED_STATUS;
        }
        if ($letter->save()) {
            return $letter;
        }
        return false;
    }

    public static function updateLetter($request, $letter, $user)
    {
        $fields = $request->only($letter->getFillable());
        $letter->fill($fields);
        if ($user->hasRole('user')) {
            $fields['moderation_status'] = self::PENDING_STATUS;
        }
        if ($letter->save()) {
            return $letter;
        }

        return false;
    }

    public static function updateAttachment($letter, $file = null, $dirPath = null, $filename = null, $name = null)
    {
        $letter->file_path = $dirPath . '/' . $filename;
        $letter->file_size = $file->getSize();
        $letter->file_type = $file->extension();
        $letter->file_name = $name;
        if ($letter->save()) {
            return $letter;
        }
        return false;
    }

    public static function deleteAttachment($letter)
    {
        $letter->file_path = null;
        $letter->file_size = null;
        $letter->file_type = null;
        $letter->file_name = null;

        if ($letter->save()) {
            return $letter;
        }

        return false;
    }

}

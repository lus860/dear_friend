<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // A report belongs to one letter
    public function letter() {
        return $this->belongsTo(Letter::class);
    }

    // A report is made by one user
    public function user() {
        return $this->belongsTo(User::class);
    }
}

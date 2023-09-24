<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Base
{
    use HasFactory;

    // A country can have many users
    public function users() {
        return $this->hasMany(User::class, 'nationality', 'code');
    }

}

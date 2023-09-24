<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affirmation extends Base
{
    use HasFactory;

    protected $fillable = ['content', 'author'];

    public static function createAffirmation($request)
    {
        $affirmation = new self();
        $affirmation->content = $request->content;
        $affirmation->author = $request->author;

        if ($affirmation->save()) {
            return $affirmation;
        }
        return false;
    }

    public static function updateAffirmation($request, $affirmation)
    {
        $fields = $request->only($affirmation->getFillable());
        $affirmation->fill($fields);
        if ($affirmation->save()) {
            return $affirmation;
        }

        return false;
    }

}

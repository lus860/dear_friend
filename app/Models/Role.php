<?php

namespace App\Models;

use Spatie\Permission\Models\Role as OriginalRole;

class Role extends OriginalRole
{
    const ADMIN = 'admin';
    const USER = 'user';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var string[]|bool
     */
    protected $guarded = [];

    public static function defaultAdminPermissions(): array
    {
        return [
            ...self::defaultUserPermissions(),

            'letters.index',
            'letters.store',
            'letters.show',
            'letters.update',
            'letters.destroy',
            'letters.moderation_status.change',

            'countries.index',
            'countries.store',
            'countries.show',
            'countries.update',
            'countries.destroy',

            'reports.index',
            'reports.store',
            'reports.show',
            'reports.update',
            'reports.destroy',

            'affirmations.index',
            'affirmations.store',
            'affirmations.show',
            'affirmations.update',
            'affirmations.destroy',

        ];
    }

    public static function defaultUserPermissions(): array
    {
        return [
            'auth.me',
            'auth.logout',
        ];
    }

}

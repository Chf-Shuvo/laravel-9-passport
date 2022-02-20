<?php

namespace App\Models\OAuth;

use Illuminate\Database\Eloquent\Model;

class AuthAccessToken extends Model
{
    protected $table = 'oauth_access_tokens';
    protected $guarded = ['id'];
}

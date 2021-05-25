<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mpesa_token extends Model
{
	protected $table = 'mpesa_tokens';

    protected $fillable = [
        'access_token',
    ];
}

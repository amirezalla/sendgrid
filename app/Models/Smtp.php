<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smtp extends Model
{
    use HasFactory;

    protected $table = 'smtp'; // Explicitly defining the table name is optional here since Laravel would automatically assume it's 'smtps'

    protected $fillable = [
        'username',
        'password',
        'domain',
        'usage',
        'max_number',
        'alert',
        'status',
        'expires_at',
    ];

    // If you have dates other than created_at and updated_at, you should tell Laravel about them:
    protected $dates = ['expires_at'];
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}

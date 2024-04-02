<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maillog extends Model
{
    use HasFactory;

    protected $table = 'mail_log'; 

    protected $fillable = [
        'recipient',
        'subject',
        'sender',
        'html',
        'sent_at',
        'via'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmtpUsageHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'smtp_usage_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'smtp_id',
        'usage_before_reset',
        'reset_month_year',
    ];

    /**
     * Get the SMTP record associated with the history.
     */
    public function smtp()
    {
        return $this->belongsTo(Smtp::class);
    }
}

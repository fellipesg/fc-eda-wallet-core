<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];
} 
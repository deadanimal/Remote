<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver',
        'amount',
        'denom',
        'sequence',
        'chain_id',
        'wallet_id',
        'user_id'
    ];       
}

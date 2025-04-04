<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Chain extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'rpc',
        'primary',
        'wallet_id',
        'user_id'
    ];     
    
    public function wallet() {
        return $this->belongsTo(Wallet::class);
    }       
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'primary',
        'mnemonic',
        'public_key',
        'private_key',
        'user_id',
        'chain_id'
    ];   
    
    public function chains() {
        return $this->hasMany(Chain::class);
    }      

}

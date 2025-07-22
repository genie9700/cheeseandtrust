<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'asset',
        'address',
        'bank_name',
        'account_name',
        'account_number',
        'paypal_address',
        'ref',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

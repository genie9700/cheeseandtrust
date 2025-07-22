<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ref',
        'method',
        'amount',
        'date',
        'status',
        'payment_slip',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}


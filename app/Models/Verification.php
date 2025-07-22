<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $fillable =[
        'user_id',
        'ref',
        'type',
        'document',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

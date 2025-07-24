<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        "name",
        "icon_url",
        "wallet_address",
        "is_active",
    ] ;


}
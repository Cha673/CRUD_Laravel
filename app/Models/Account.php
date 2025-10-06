<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    // 🔹 Indique que ce modèle utilise la base 'account'
    protected $connection = 'account_bdd';

    // 🔹 Table utilisée
    protected $table = 'accounts';

    // 🔹 Champs modifiables
    protected $fillable = ['user_id', 'name'];
}


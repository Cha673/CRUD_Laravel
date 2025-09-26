<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YourModel extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'profil'
    ];

    // Règles de validation
    public static $rules = [
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email',
        'telephone' => 'required|string|max:20',
        'profil' => 'nullable|in:Administrateur,Utilisateur standard'
    
    ];

}
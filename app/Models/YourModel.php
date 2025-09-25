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

    //en fonction du mail, définit le profil à l'aide de la fonction déteminerProfil
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = $value;
        
        // Définir automatiquement le profil si ce n'est pas déjà fait
        if (!isset($this->attributes['profil']) || empty($this->attributes['profil'])) {
            $this->attributes['profil'] = $this->determinerProfil($value);
        }
    }


    //déterminer le profi en fonction du mail
    private function determinerProfil($email)
    {
        return str_ends_with($email, '@company.com') ? 'Administrateur' : 'Utilisateur standard';
    }
}
<?php

namespace App\Domain\Entity;

class UserEntity
{
    public $id;
    public string $nom;
    public string $prenom;
    public string $email;
    public string $telephone;
    public string $profil; 

    public function __construct(?int $id, string $nom, string $prenom, string $email, string $telephone, string $profil)
    {

        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->profil = $profil;

    }
}

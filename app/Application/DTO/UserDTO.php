<?php

namespace App\Application\DTO;

class UserDTO {
    public string $nom;
    public string $prenom;
    public string $email;
    public string $telephone;

    public function __construct(array $data)
    {
        $this->nom = $data['nom'] ?? '';
        $this->prenom = $data['prenom'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->telephone = $data['telephone'] ?? '';
    }
    
}

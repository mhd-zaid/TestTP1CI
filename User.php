<?php

use Carbon\Carbon;

abstract class User
{
    protected string $email;
    protected string $prenom;
    protected string $nom;
    protected Carbon $dateDeNaissance;

    public function __construct(string $email, string $prenom, string $nom, Carbon $dateDeNaissance)
    {
        $this->email = $email;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->dateDeNaissance = $dateDeNaissance;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getDateDeNaissance(): Carbon
    {
        return $this->dateDeNaissance;
    }
}
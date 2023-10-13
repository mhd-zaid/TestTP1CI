<?php

use Carbon\Carbon;
use exception\GlobalException;

class Client extends User
{
    private array $compteBancaires;
    private bool $interditBancaire;

    public function __construct(string $email,
                                string $prenom,
                                string $nom,
                                Carbon $dateDeNaissance,
                                array  $compteBancaires,
                                bool   $interditBancaire)
    {
        parent::__construct($email, $prenom, $nom, $dateDeNaissance);
        $this->compteBancaires = $compteBancaires;
        $this->interditBancaire = $interditBancaire;
    }

    /**
     * @throws GlobalException
     */
    public function verifierSiCompteValide(int $compteBancaireId): bool
    {
        if ($this->interditBancaire) {
            return false;
        }

        $bonCompteBancaire = null;
        foreach ($this->compteBancaires as $compteBancaire) {
            if ($compteBancaire->getId() === $compteBancaireId) {
                $bonCompteBancaire = $compteBancaire;
            }
        }

        if (!$bonCompteBancaire) {
            throw new GlobalException("Compte non trouvé");
        }

        return $bonCompteBancaire->estValide();
    }

    public function getCompteBancaires(): array
    {
        return $this->compteBancaires;
    }

    public function isInterditBancaire(): bool
    {
        return $this->interditBancaire;
    }
}
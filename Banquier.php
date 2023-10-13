<?php

use Carbon\Carbon;
use exception\GlobalException;

class Banquier extends User
{
    const DELAI_AVANT_BANQUIER_CONTACTE_CLIENT = 90;

    protected Carbon $dateArrivee;
    protected array $clients;

    public function __construct(string $email,
                                string $prenom,
                                string $nom,
                                Carbon $dateDeNaissance,
                                Carbon $dateArrivee,
                                array $clients)
    {
        parent::__construct($email, $prenom, $nom, $dateDeNaissance);
        $this->dateArrivee = $dateArrivee;
        $this->clients = $clients;
    }

    /**
     * @throws GlobalException
     */
    public function clientAContacter(): array
    {
        if (Carbon::now()->subDays(self::DELAI_AVANT_BANQUIER_CONTACTE_CLIENT)->isBefore($this->dateArrivee)) {
            throw new GlobalException("Veuillez valider votre période d'essai avant de contacter des clients");
        }

        $clientAContacter = [];
        foreach ($this->clients as $client) {
            foreach ($client->getCompteBancaires() as $compteBancaire) {
                if (!$compteBancaire->estValide()) {
                    $clientAContacter[] = $client;
                    break;
                }
            }
        }

        return $clientAContacter;
    }

    public function setDateArrivee(Carbon $dateArrivee): void
    {
        $this->dateArrivee = $dateArrivee;
    }

    public function setClients(array $clients): void
    {
        $this->clients = $clients;
    }
}
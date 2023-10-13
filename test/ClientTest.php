<?php

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use exception\GlobalException;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class ClientTest extends TestCase
{
    public function testVerifieSiCompteValide()
    {
        $compteBancaire = new CompteBancaire();
        $compteBancaire->credit(500);
        $compteBancaire->setId(1);
        $client = new Client("john.doe@test.fr","John", "Doe", Carbon::now()->subYears(30), [
            $compteBancaire
        ], false);

        assertTrue($client->verifierSiCompteValide($compteBancaire->getId()));

    }

    public function testVerifieSiCompteInvalide()
    {
        $compteBancaire = new CompteBancaire();
        $compteBancaire->debit(500);
        $compteBancaire->setId(1);
        $client = new Client("john.doe@test.fr","John", "Doe", Carbon::now()->subYears(30), [
            $compteBancaire
        ], true);

        assertFalse($client->verifierSiCompteValide($compteBancaire->getId()));
    }

    public function testVerificationCompteNonTrouvé()
    {
        $this->expectException(GlobalException::class);
        $this->expectExceptionMessage("Compte non trouvé");

        $compteBancaire = new CompteBancaire();
        $compteBancaire->credit(500);
        $compteBancaire->setId(1);
        $client = new Client("john.doe@test.fr","John", "Doe", Carbon::now()->subYears(30), [
            $compteBancaire
        ], false);
        $client->verifierSiCompteValide(2);

    }

}
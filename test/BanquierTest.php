<?php

use PHPUnit\Framework\TestCase;
use Carbon\Carbon;
use exception\GlobalException;

class BanquierTest extends TestCase
{
    public function testClientAContacter()
    {
        
        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(1500);
        $client = new Client("john.doe@test.fr","John", "Doe", Carbon::now()->subYears(30), [
            $compteBancaire
        ], true);

        $banquier = new Banquier('banquier@test.fr', 'Jean', 'Dupont', Carbon::now()->subYears(30), Carbon::now()->subYears(2), [$client]);
        $this->assertEquals([$client], $banquier->clientAContacter());
    }

    public function testAucunClientAContacter()
    {
        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(500);
        $client = new Client("john.doe@test.fr","John", "Doe", Carbon::now()->subYears(30), [
            $compteBancaire
        ], true);

        $banquier = new Banquier('banquier@test.fr', 'Jean', 'Dupont', Carbon::now()->subYears(30), Carbon::now()->subYears(2), [$client]);
        $this->assertEmpty($banquier->clientAContacter());
    }

    public function testPeriodeEssai()
    {
        $this->expectException(GlobalException::class);
        $this->expectExceptionMessage("Veuillez valider votre période d'essai avant de contacter des clients");
        
        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(1500);
        $client = new Client("john.doe@test.fr","John", "Doe", Carbon::now()->subYears(30), [
            $compteBancaire
        ], true);

        $banquier = new Banquier('banquier@test.fr', 'Jean', 'Dupont', Carbon::now()->subYears(30), Carbon::now()->subDays(30), [$client]);
        $this->assertEquals([$client], $banquier->clientAContacter());
    }
}
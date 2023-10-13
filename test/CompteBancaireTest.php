<?php

use PHPUnit\Framework\TestCase;
use exception\CreditException;
use exception\DebitException;

class CompteBancaireTest extends TestCase
{
    public function testCreditMauvaisMontant()
    {
        $this->expectException(CreditException::class);
        $this->expectExceptionMessage("Mauvais montant");

        $compteBancaire = new CompteBancaire();
        $compteBancaire->credit(-1);
    }

    public function testCreditCompteBancaireMauvaisEtat()
    {
        $this->expectException(CreditException::class);
        $this->expectExceptionMessage("Le compte bancaire n'est pas dans un état correct");

        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(1500);
        $compteBancaire->credit(500);
    }

    public function testCreditCompteBancaire()
    {
        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(500);
        $compteRendu = $compteBancaire->credit(500);

        $this->assertEquals(500, $compteRendu->getMontantCredite());
        $this->assertEquals(1000, $compteRendu->getNouveauSolde());
    }

    public function testCreditCompteBancaireAvecMontantSuperieurAuMax()
    {
        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(500);
        $compteRendu = $compteBancaire->credit(1500);

        $this->assertEquals(500, $compteRendu->getMontantCredite());
        $this->assertEquals(1000, $compteRendu->getNouveauSolde());
        $this->assertEquals($compteRendu->getMontantNonCredite(), 1000);
    }

    public function testDebitMauvaisMontant()
    {
        $this->expectException(DebitException::class);
        $this->expectExceptionMessage("Mauvais montant");

        $compteBancaire = new CompteBancaire();
        $compteBancaire->debit(-1);
    }

    public function testDebitCompteBancaireMauvaisEtat()
    {
        $this->expectException(DebitException::class);
        $this->expectExceptionMessage("Le compte bancaire n'est pas dans un état correct");

        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(-500);
        $compteBancaire->debit(500);
    }

    public function testDebitCompteBancaire()
    {
        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(500);
        $compteRendu = $compteBancaire->debit(500);

        $this->assertEquals(500, $compteRendu->getMontantDebite());
        $this->assertEquals(0, $compteRendu->getNouveauSolde());
    }

    public function testDebitCompteBancaireAvecMontantInferieurAuMin()
    {
        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(500);
        $compteRendu = $compteBancaire->debit(1500);

        $this->assertEquals(500, $compteRendu->getMontantDebite());
        $this->assertEquals(0, $compteRendu->getNouveauSolde());
        $this->assertEquals($compteRendu->getMontantNonDebite(), 1000);
    }

    public function testCompteBancaireValide()
    {
        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(500);

        $this->assertTrue($compteBancaire->estValide());
    }

    public function testCompteBancaireInvalide()
    {
        $compteBancaire = new CompteBancaire();
        $compteBancaire->setMontant(1500);

        $this->assertFalse($compteBancaire->estValide());
    }
}
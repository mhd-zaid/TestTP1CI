<?php

use Carbon\Carbon;
use exception\CreditException;
use exception\DebitException;

class CompteBancaire
{
    const MAX = 1000;
    const MIN = 0;

    private int $id;
    private int $montant;
    private ?Carbon $dateHeureDerniereMAJ;

    public function __construct()
    {
        $this->montant = 0;
        $this->dateHeureDerniereMAJ = null;
    }

    /**
     * @throws CreditException
     */
    public function credit(int $montantACrediter): CompteRenduOperation
    {
        if ($montantACrediter <= 0) {
            throw new CreditException("Mauvais montant");
        } elseif (!$this->estValide()) {
            throw new CreditException("Le compte bancaire n'est pas dans un état correct");
        }

        $nouveauSolde = min($this->montant + $montantACrediter, self::MAX);
        $montantCredite = $montantACrediter + $this->montant <= self::MAX
            ? $montantACrediter
            : $nouveauSolde - $this->montant;

        $this->save($nouveauSolde);

        $builder = new CompteRenduOperationBuilder($nouveauSolde);
        $builder->montantCredite($montantCredite);
        $builder->montantNonCredite($montantACrediter - $montantCredite);

        return $builder->build();
    }

    /**
     * @throws DebitException
     */
    public function debit(int $montantADebiter): CompteRenduOperation
    {
        if ($montantADebiter <= 0) {
            throw new DebitException("Mauvais montant");
        } elseif (!$this->estValide()) {
            throw new DebitException("Le compte bancaire n'est pas dans un état correct");
        }

        $nouveauSolde = max($this->montant - $montantADebiter, self::MIN);
        $montantDedite = $this->montant - $montantADebiter >= self::MIN
            ? $montantADebiter
            : $this->montant;

        $this->save($nouveauSolde);

        $builder = new CompteRenduOperationBuilder($nouveauSolde);
        $builder->montantDebite($montantDedite);
        $builder->montantNonDebite($montantADebiter - $montantDedite);

        return $builder->build();
    }

    public function estValide(): bool
    {
        return $this->montant >= self::MIN && $this->montant <= self::MAX;
    }

    public function save(int $nouveauSolde): void
    {
        // SAVE IN DB
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getMontant(): int
    {
        return $this->montant;
    }

    public function getDateHeureDerniereMAJ(): ?Carbon
    {
        return $this->dateHeureDerniereMAJ;
    }

    public function setMontant(int $montant): void
    {
        $this->montant = $montant;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
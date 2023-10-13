<?php

class CompteRenduOperation
{
    private int $nouveauSolde;
    private int $montantCredite;
    private int $montantNonCredite;
    private int $montantDebite;
    private int $montantNonDebite;

    public function __construct(int $nouveauSolde,
                                int $montantCredite,
                                int $montantNonCredite,
                                int $montantDebite,
                                int $montantNonDebite)
    {
        $this->nouveauSolde = $nouveauSolde;
        $this->montantCredite = $montantCredite;
        $this->montantNonCredite = $montantNonCredite;
        $this->montantDebite = $montantDebite;
        $this->montantNonDebite = $montantNonDebite;
    }

    public function getNouveauSolde(): int
    {
        return $this->nouveauSolde;
    }

    public function getMontantCredite(): int
    {
        return $this->montantCredite;
    }

    public function getMontantNonCredite(): int
    {
        return $this->montantNonCredite;
    }

    public function getMontantDebite(): int
    {
        return $this->montantDebite;
    }

    public function getMontantNonDebite(): int
    {
        return $this->montantNonDebite;
    }
}

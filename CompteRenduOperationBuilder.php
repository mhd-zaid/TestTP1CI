<?php

class CompteRenduOperationBuilder
{
    private int $nouveauSolde;
    private int $montantCredite = 0;
    private int $montantNonCredite = 0;
    private int $montantDebite = 0;
    private int $montantNonDebite = 0;

    public function __construct(int $nouveauSolde)
    {
        $this->nouveauSolde = $nouveauSolde;
    }

    public function montantCredite(int $montantCredite): CompteRenduOperationBuilder
    {
        $this->montantCredite = $montantCredite;
        return $this;
    }

    public function montantNonCredite(int $montantNonCredite): CompteRenduOperationBuilder
    {
        $this->montantNonCredite = $montantNonCredite;
        return $this;
    }

    public function montantDebite(int $montantDebite): CompteRenduOperationBuilder
    {
        $this->montantDebite = $montantDebite;
        return $this;
    }

    public function montantNonDebite(int $montantNonDebite): CompteRenduOperationBuilder
    {
        $this->montantNonDebite = $montantNonDebite;
        return $this;
    }

    public function build(): CompteRenduOperation
    {
        return new CompteRenduOperation($this->nouveauSolde,
            $this->montantCredite,
            $this->montantNonCredite,
            $this->montantDebite,
            $this->montantNonDebite
        );
    }
}

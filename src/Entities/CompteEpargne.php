<?php 
namespace App\Entities;
use App\Exceptions\CompteException;
class CompteEpargne extends Compte 
{
    public function __construct(int $clientId, float $solde = 0.0, ?int $id = null)
    {
        parent::__construct($clientId, $solde, $id);
    }
    public function depot(float $montant):void
    {
        $this->solde += $montant;
    }
    public function retrait(float $montant):void
    {
        if ($this->solde < $montant) {
            throw new CompteException("solde insuffisant (CompteEpargne).");
        }
        $this->solde -= $montant;
    }
}
<?php
namespace App\Entities;
use App\Exceptions\CompteException;
class CompteCourant extends Compte
{
    public float $decouvert = 500.00;

    public function __construct(int $clientId, float $solde = 0.0, ?int $id = null)
    {
        parent::__construct($clientId, $solde, $id);
    }

    public function depot(float $montant): void
{
    if ($montant <= 1) {
        throw new CompteException('Le montant du dépôt doit êtrelus que 1$');
    }
    $this->solde += $montant;
}

    public function retrait(float $montant): void
    {
        if ($this->solde - $montant < -$this->decouvert) {
            throw new CompteException('Découvert dépassé');
        }
        $this->solde -= $montant;
    }
}

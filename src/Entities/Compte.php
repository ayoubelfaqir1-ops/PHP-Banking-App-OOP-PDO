<?php
namespace App\Entities;
abstract class Compte
{
    protected ?int $id = null;
    protected float $solde = 0.0;
    protected int $clientId;

    public function __construct(int $clientId, float $solde = 0.0, ?int $id = null)
    {
        $this->clientId = $clientId;
        $this->solde = $solde;
        $this->id = $id;
    }

    public function getId(): ?int { return $this->id; }
    public function getSolde(): float { return $this->solde; }
    public function getClientId(): int { return $this->clientId; }

    abstract public function depot(float $montant): void;
    abstract public function retrait(float $montant): void;
}

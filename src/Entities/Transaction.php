<?php

namespace App\Entities;

class Transaction
{
    private ?int $id = null;
    private string $type;
    private float $montant;
    private int $compteId;
    private string $date;

    public function __construct(string $type, float $montant, int $compteId, ?string $date = null, ?int $id = null)
    {
        $this->type = $type;
        $this->montant = $montant;
        $this->compteId = $compteId;
        $this->date = $date ?? date('Y-m-d H:i:s');
        $this->id = $id;
    }

    public function getId(): ?int { return $this->id; }
    public function getType(): string { return $this->type; }
    public function getMontant(): float { return $this->montant; }
    public function getCompteId(): int { return $this->compteId; }
    public function getDate(): string { return $this->date; }
}

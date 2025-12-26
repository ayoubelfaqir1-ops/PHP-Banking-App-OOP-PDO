<?php 

namespace App\Entities;
use App\Entities\Transactiontype;

class Transaction
{
    private int $compteid;
    private Transactiontype $type;
    private float $montant;

    public function __construct(int $compteid,string $type,float $montant)
    {
        $this->compteid = $compteid;
        $this->type = Transactiontype::from($type);
        $this->montant = $montant;
    }
}
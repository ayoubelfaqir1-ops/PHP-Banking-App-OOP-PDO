<?php
namespace App\Services;

use App\Entities\Transaction;
use App\Repositories\TransactionRepository;

class TransactionService
{
    private $repo;

    public function __construct(TransactionRepository $repo)
    {
        $this->repo = $repo;
    }

    public function createTransaction($type, $montant, $compteId) {
        $transaction = new Transaction($type, $montant, $compteId);
        return $this->repo->insert($transaction);
    }

    public function getAllTransactions() {
        return $this->repo->getAll();
    }
}

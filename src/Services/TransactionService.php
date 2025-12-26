<?php
declare(strict_types=1);
namespace AppBancaire\Services;

use AppBancaire\Repositories\TransactionRepository;

class TransactionService
{
    private TransactionRepository $repo;

    public function __construct(TransactionRepository $repo)
    {
        $this->repo = $repo;
    }

    // Logique métier à implémenter
}

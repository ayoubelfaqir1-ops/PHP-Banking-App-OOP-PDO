<?php

require_once __DIR__ . '/../src/Entities/Transaction.php';
require_once __DIR__ . '/../src/Repositories/TransactionRepository.php';
require_once __DIR__ . '/../src/Services/TransactionService.php';

use App\Repositories\TransactionRepository;
use App\Services\TransactionService;

// PDO connection
$pdo = new PDO('mysql:host=localhost;dbname=App_bancaire', 'root', '');

// Initialize service
$transactionService = new TransactionService(new TransactionRepository($pdo));

echo "=== CREATE TRANSACTION ===\n";
// Assuming account ID 1 exists
$compteId = 5;
$transId = $transactionService->createTransaction('depot', 150.0, $compteId);
echo "New Transaction ID: $transId\n";

echo "\n=== READ TRANSACTIONS ===\n";
$transactions = $transactionService->getAllTransactions();
print_r($transactions);

?>
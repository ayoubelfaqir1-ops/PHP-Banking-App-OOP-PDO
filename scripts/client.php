<?php

require_once __DIR__ . '/../src/Entities/Client.php';
require_once __DIR__ . '/../src/Exceptions/ClientException.php';
require_once __DIR__ . '/../src/Repositories/ClientRepository.php';
require_once __DIR__ . '/../src/Services/ClientService.php';

use App\Entities\Client;
use App\Repositories\ClientRepository;
use App\Services\ClientService;


// PDO connection
$pdo = new PDO('mysql:host=localhost;dbname=App_bancaire', 'root', '');

// Initialize service
$clientService = new ClientService(new ClientRepository($pdo));

echo "=== CREATE ===\n";
$clientId = $clientService->createClient("loki", "loki12@gmail.com", "12345856974");
echo "New client ID: $clientId\n";

echo "\n=== READ ===\n";
$client = $clientService->getClient($clientId);
print_r($client);

echo "\n=== UPDATE ===\n";
$clientService->updateClient($clientId, "Alice Smith", "alice.smith@example.com", "987654321");
$updatedClient = $clientService->getClient($clientId);
print_r($updatedClient);

echo "\n=== DELETE ===\n";
// $clientService->deleteClient($clientId);
// $deletedClient = $clientService->getClient($clientId);
// var_dump($deletedClient); // should be null
?>
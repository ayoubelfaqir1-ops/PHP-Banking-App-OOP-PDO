<?php

require_once __DIR__ . '/../src/Entities/Compte.php';
require_once __DIR__ . '/../src/Entities/CompteCourant.php';
require_once __DIR__ . '/../src/Entities/CompteEpargne.php';
require_once __DIR__ . '/../src/Repositories/CompteRepository.php';
require_once __DIR__ . '/../src/Services/CompteService.php';
require_once __DIR__ . '/../src/Exceptions/CompteException.php';

use App\Entities\Compte;
use App\Entities\CompteCourant;
use App\Entities\CompteEpargne;
use App\Repositories\CompteRepository;
use App\Services\CompteService;

// PDO connection
$pdo = new PDO('mysql:host=localhost;dbname=App_bancaire', 'root', '');

// Initialize service
$compteService = new CompteService(new CompteRepository($pdo));

echo "=== CREATE COMPTE COURANT ===\n";
try {
    $clientId = 5; // Assuming a client with ID 1 exists
    $compteCourantId = $compteService->createCompte($clientId, 'courant', 1000.00);
    echo "New Compte Courant ID: $compteCourantId\n";
} catch (Exception $e) {
    echo "Error creating Compte Courant: " . $e->getMessage() . "\n";
}


echo "\n=== CREATE COMPTE EPARGNE ===\n";
try {
    $clientId = 6; // Assuming a client with ID 1 exists
    $compteEpargneId = $compteService->createCompte($clientId, 'epargne', 500.00);
    echo "New Compte Epargne ID: $compteEpargneId\n";
} catch (Exception $e) {
    echo "Error creating Compte Epargne: " . $e->getMessage() . "\n";
}

echo "\n=== GET COMPTE ===\n";
if (isset($compteCourantId)) {
    $compte = $compteService->getCompte($compteCourantId);
    print_r($compte);
}

echo "\n=== GET ALL COMPTES ===\n";
$all = $compteService->getAllComptes();
print_r($all);

echo "\n=== DELETE (example, commented) ===\n";
// $compteService->deleteCompte($compteCourantId);

?>

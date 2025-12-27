<?php
namespace Services;
use App\Entities\Compte;
use App\Entities\CompteEpargne;
use App\Entities\CompteCourant;
use App\Repositories\CompteRepository;
class CompteService {
    private $repo;

    public function __construct(CompteRepository $repo) {
        $this->repo = $repo;
    }

    public function createCompte(int $clientId, string $typeCompte, float $solde, int $clientid): int {
    if ($typeCompte === 'courant') {
        $compte = new CompteCourant($clientId, $solde, $clientid);  // ✅ Correct!
    } elseif ($typeCompte === 'epargne') {
        $compte = new CompteEpargne($clientId, $solde,$clientid);
    }
    return $this->repo->insert($compte,$clientId);
}

    public function getCompte($id) {
        return $this->repo->getById($id);
    }

    public function getAllComptes() {
        return $this->repo->getAllcomptes();
    }

    public function deleteCompte($id) {
        return $this->repo->delete($id);
    }
}
?>


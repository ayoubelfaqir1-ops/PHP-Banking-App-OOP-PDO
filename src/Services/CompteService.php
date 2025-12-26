<?php
namespace Services;
use App\Entities\Compte;
use App\Repositories\CompteRepository;
class ClientService {
    private $repo;

    public function __construct(CompteRepository $repo) {
        $this->repo = $repo;
    }

    public function createCompte($name, $email, $phone = null,$clientId) {
        $compte = new Compte($name, $email, $phone);
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


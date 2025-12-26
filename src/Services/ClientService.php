<?php
namespace Services;
use App\Entities\Client;
use App\Repositories\ClientRepository;
class ClientService {
    private $repo;

    public function __construct(ClientRepository $repo) {
        $this->repo = $repo;
    }

    public function createClient($name, $email, $phone = null) {
        $client = new Client($name, $email, $phone);
        return $this->repo->insert($client);
    }

    public function getClient($id) {
        return $this->repo->getById($id);
    }

    public function getAllClients() {
        return $this->repo->getAll();
    }

    public function updateClient($id, $name, $email, $phone = null) {
        $client = new Client($name, $email, $phone, $id);
        return $this->repo->update($client);
    }

    public function deleteClient($id) {
        return $this->repo->delete($id);
    }
}
?>

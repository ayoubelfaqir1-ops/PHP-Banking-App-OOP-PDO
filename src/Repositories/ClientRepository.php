<?php
namespace App\Repositories;
use App\Entities\Client;
use Config\Database;
use PDO;
class ClientRepository {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    
    public function insert(Client $client) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO clients (name, email) VALUES (:name, :email)"
        );
        $stmt->execute([
            'name' => $client->getNom(),
            'email' => $client->getEmail(),
        ]);
        return $this->pdo->lastInsertId();
    }

    
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        return $data ? new Client($data['name'], $data['email'], $data['id']) : null;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM clients");
        $clients = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $clients[] = new Client($row['name'], $row['email'], $row['id']);
        }
        return $clients;
    }

    
    public function update(Client $client) {
        $stmt = $this->pdo->prepare(
            "UPDATE clients SET name = :name, email = :email WHERE id = :id"
        );
        return $stmt->execute([
            ':name' => $client->getNom(),
            ':email' => $client->getEmail(),  
            ':id' => $client->getid()
        ]);
    }


    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM clients WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}

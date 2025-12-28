<?php

namespace App\Repositories;

use App\Entities\Compte;
use App\Entities\CompteCourant;
use App\Entities\CompteEpargne;
use Config\Database;
use PDO;

class CompteRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Compte $compte, int $clientId)
    {
        $sql = "
        INSERT INTO comptes (client_id, solde, type_compte)
        VALUES (:client_id, :solde, :type_compte)
        ";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'client_id'   => $clientId,
            'solde'       => $compte->getSolde(),
            'type_compte' => $compte instanceof CompteCourant ? 'courant' : 'epargne'
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getById($clientid)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM comptes WHERE client_id = :client_id");
        $stmt->execute([':client_id' => $clientid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $type = $row['type_compte'] ?? null;
        if ($type === 'epargne') {
            return new CompteEpargne($row['client_id'], $row['solde'], $row['id']);
        }
        return new CompteCourant($row['client_id'], $row['solde'], $row['id']);
    }

    public function getallcomptes()
    {
        $stmt = $this->pdo->query("SELECT * FROM comptes");
        $comptes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $type = $row['type_compte'] ?? null;
            if ($type === 'epargne') {
                $comptes[] = new CompteEpargne($row['client_id'], $row['solde'], $row['id']);
            } else {
                $comptes[] = new CompteCourant($row['client_id'], $row['solde'], $row['id']);
            }
        }
        return $comptes;
    }
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM comptes WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}

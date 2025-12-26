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
        INSERT INTO compte (client_id, solde, type_compte)
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

    public function getbyid($clientid)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM comptes WHERE client_id = :client_id");
        $stmt->execute([':client_id'=>$clientid]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $compte = new Compte($row['client_id'],$row['solde'],$row['id']) : null;
    }

    public function getallcomptes()
    {
        $stmt =$this->pdo->query("SELECT * FROM comptes");
        $comptes = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $comptes[] = new Compte($row['client_id'],$row['solde'],$row['id']);
        }
        return $comptes;
    }
    public function delete($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM comptes WHERE id = :id");
        return $stmt->execute([':id'=>$id]);
    }



}

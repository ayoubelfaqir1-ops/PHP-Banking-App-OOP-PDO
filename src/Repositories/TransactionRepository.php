<?php

namespace App\Repositories;

use App\Entities\Transaction;
use Config\Database;
use PDO;

class TransactionRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Transaction $transaction)
    {
        $map = $this->detectColumnMap();

        $cols = [ $map['type'], $map['montant'], $map['compte_id'], $map['date'] ];
        $placeholders = [':type', ':montant', ':compte_id', ':date'];

        $sql = sprintf("INSERT INTO transactions (%s) VALUES (%s)", implode(', ', $cols), implode(', ', $placeholders));
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':type' => $transaction->getType(),
            ':montant' => $transaction->getMontant(),
            ':compte_id' => $transaction->getCompteId(),
            ':date' => $transaction->getDate(),
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM transactions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) return null;
        $map = $this->detectColumnMap();
        $type = $data[$map['type']] ?? null;
        $montant = $data[$map['montant']] ?? null;
        $compteId = $data[$map['compte_id']] ?? null;
        $date = $data[$map['date']] ?? null;
        $idVal = $data[$map['id']] ?? null;
        return new Transaction($type, $montant, $compteId, $date, $idVal);
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM transactions");
        $transactions = [];
        $map = $this->detectColumnMap();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = new Transaction(
                $row[$map['type']] ?? null,
                $row[$map['montant']] ?? null,
                $row[$map['compte_id']] ?? null,
                $row[$map['date']] ?? null,
                $row[$map['id']] ?? null
            );
        }
        return $transactions;
    }

    public function update(Transaction $transaction)
    {
        $map = $this->detectColumnMap();
        $cols = [
            $map['type'] . ' = :type',
            $map['montant'] . ' = :montant',
            $map['compte_id'] . ' = :compte_id',
            $map['date'] . ' = :date',
        ];
        $sql = sprintf("UPDATE transactions SET %s WHERE %s = :id", implode(', ', $cols), $map['id']);
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':type' => $transaction->getType(),
            ':montant' => $transaction->getMontant(),
            ':compte_id' => $transaction->getCompteId(),
            ':date' => $transaction->getDate(),
            ':id' => $transaction->getId(),
        ]);
    }

    public function delete($id)
    {   
        $stmt = $this->pdo->prepare("DELETE FROM transactions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    private function detectColumnMap(): array
    {
        // Default mapping (fallback)
        $map = [
            'id' => 'id',
            'type' => 'type',
            'montant' => 'montant',
            'compte_id' => 'compte_id',
            'date' => 'date',
        ];

        try {
            $cols = $this->pdo->query("SHOW COLUMNS FROM transactions")->fetchAll(PDO::FETCH_COLUMN, 0);
            if (!$cols) return $map;

            $lower = array_map('strtolower', $cols);

            // helpers
            $firstLike = function(array $names) use ($lower, $cols) {
                foreach ($names as $n) {
                    foreach ($lower as $i => $col) {
                        if (strpos($col, strtolower($n)) !== false) return $cols[$i];
                    }
                }
                return null;
            };

            $map['id'] = $firstLike(['id', 'sid']) ?? $map['id'];
            $map['type'] = $firstLike(['type', 'transaction_type', 'type_transaction', 'transaction']) ?? $map['type'];
            $map['montant'] = $firstLike(['montant', 'amount', 'valeur', 'value']) ?? $map['montant'];
            $map['compte_id'] = $firstLike(['compte_id', 'compteid', 'account_id', 'compte']) ?? $map['compte_id'];
            $map['date'] = $firstLike(['date', 'created_at', 'created', 'date_created', 'timestamp']) ?? $map['date'];
        } catch (\Exception $e) {
            // ignore and use defaults
        }

        return $map;
    }
}

?>

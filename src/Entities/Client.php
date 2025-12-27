<?php

namespace App\Entities;

class Client
{
    private ?int $id = null;
    private string $nom;
    private string $email;
    public string $emailErr;

    public function __construct(string $nom, string $email, ?int $id = null)
    {
        $this->nom = $nom;
        $this->id = $id;
        $this->Emailverify($email);
    }

    public function Emailverify($email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->emailErr = "Invalid email format";
            throw new \App\Exceptions\ClientException("Invalid email format: $email");  // ✅ Stops execution
        }
        $this->email = $email;  // ✅ Always sets if we get here
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNom(): string
    {
        return $this->nom;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
}

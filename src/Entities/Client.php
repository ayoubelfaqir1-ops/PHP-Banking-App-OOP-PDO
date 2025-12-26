<?php
namespace App\Entities;

class Client
{
    private ?int $id = null;
    private string $nom;
    private string $email ;
    public string $emailErr;

    public function __construct(string $nom, string $email,?int $id = null)
    {
        $this->nom = $nom;
        $this->Emailverify($email);
        $this->id = $id;
    }
    public function Emailverify($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->emailErr = "Invalid email format";
        }else return $this->email = $email;
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

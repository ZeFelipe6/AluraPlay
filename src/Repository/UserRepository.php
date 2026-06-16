<?php

declare(strict_types=1);

namespace Alura\Mvc\Repository;

use PDO;

class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $statement->bindValue(1, $email);
        $statement->execute();

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        return $userData === false ? null : $userData;
    }

    public function updatePassword(int $id, string $password): bool
    {
        $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
        $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
        $statement->bindValue(2, $id, PDO::PARAM_INT);

        return $statement->execute();
    }
}

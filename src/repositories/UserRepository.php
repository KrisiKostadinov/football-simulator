<?php

namespace App\Repositories;

use PDO;

class UserRepository
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(array $data): bool
    {
        $sql = "INSERT INTO users (first_name, last_name, username, team_name, email, password, role)
                VALUES (:first_name, :last_name, :username, :team_name, :email, :password, :role)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':username' => $data['username'],
            ':team_name' => $data['team_name'] ?? null,
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role' => $data['role'] ?? 'user'
        ]);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findByTeamName(string $teamName): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE team_name = :team_name LIMIT 1");
        $stmt->execute([':team_name' => $teamName]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countUsers(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM users");
        return (int) $stmt->fetchColumn();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function savePasswordResetToken(string $token, int $userId): bool
    {
        $expiration = time() + 3600;

        $stmt = $this->db->prepare("
        UPDATE users 
        SET password_reset_token = :token, token_expiration = :expiration 
        WHERE id = :id
    ");

        return $stmt->execute([
            ':token' => $token,
            ':expiration' => $expiration,
            ':id' => $userId
        ]);
    }

    public function findByPasswordResetToken(string $token): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE password_reset_token = :token LIMIT 1");
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function updatePassword(int $userId): bool
    {
        $stmt = $this->db->prepare("
        UPDATE users 
        SET password = :password, 
            password_reset_token = :token, 
            token_expiration = :expiration 
        WHERE id = :id
    ");

        return $stmt->execute([
            ':password' => password_hash($_POST['new_password'], PASSWORD_DEFAULT),
            ':token' => null,
            ':expiration' => null,
            ':id' => $userId
        ]);
    }
}
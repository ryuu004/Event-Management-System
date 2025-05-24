<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use Firebase\JWT\JWT;

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->render('auth/register');
        }

        $data = [
            'username' => $_POST['username'],
            'email' => $_POST['email'],
            'password' => $_POST['password'],
            'role' => $_POST['role']
        ];

        if ($this->userModel->findByEmail($data['email'])) {
            return $this->json(['error' => 'Email already exists'], 400);
        }

        $this->userModel->create($data);
        return $this->json(['message' => 'Registration successful']);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return $this->render('auth/login');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            return $this->json(['error' => 'Invalid credentials'], 401);
        }

        session_start();
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role']
        ];
        return $this->json([
            'user' => [
                'id' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role']
            ]
        ]);
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /endama2/events');
        exit;
    }
} 
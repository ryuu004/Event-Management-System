<?php

namespace App\Core;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Controller {
    protected function render($view, $data = []) {
        // Start output buffering
        ob_start();
        
        // Extract data to make variables available in view
        extract($data);
        
        // Include the view file
        $viewFile = __DIR__ . "/../views/{$view}.php";
        if (!file_exists($viewFile)) {
            throw new \Exception("View file not found: {$view}");
        }
        
        require $viewFile;
        
        // Get the contents of the output buffer and clean it
        $content = ob_get_clean();
        
        // Include the layout
        $layoutFile = __DIR__ . "/../views/layouts/main.php";
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    protected function json($data, $status = 200) {
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data);
    }

    protected function getAuthUser() {
        session_start();
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    protected function requireAuth($roles = []) {
        $user = $this->getAuthUser();
        if (!$user) {
            $this->json(['error' => 'Unauthorized'], 401);
            exit;
        }
        if (!empty($roles) && !in_array($user['role'], $roles)) {
            $this->json(['error' => 'Forbidden'], 403);
            exit;
        }
        return $user;
    }
} 
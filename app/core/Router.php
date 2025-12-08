<?php
// app/core/Router.php

class Router {

    private $routes = [
        ""      => "public/views/index.html",
        "home"  => "public/views/index.html",
        "login" => "public/views/login.html",
        "admin" => "public/views/admin.html",
    ];

    private $protectedRoutes = ["admin"];

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function dispatch($uri) {
        $uri = trim($uri, "/");
        if ($uri === "") $uri = "home";

        $method = $_SERVER['REQUEST_METHOD'];

        // ---------------------------------------------------------
        // 1. ROTAS DE AÇÃO (Controllers)
        // ---------------------------------------------------------
        
        // Se a rota for 'login' E o método for POST -> Chama o LoginController
        if ($uri === 'login' && $method === 'POST') {
            require_once '../app/controllers/login.php';
            $controller = new LoginController();
            $controller->logar();
            return; // Encerra aqui
        }

        if ($uri === 'mensagens' && $method === 'GET') {
            require_once '../app/controllers/mensagens.php';
            $controller = new MensagemController();
            $controller->listar();
            return; 
        }

        if ($uri === 'enviar' && $method === 'POST') {
            require_once '../app/controllers/enviar.php';
            $controller = new EnviarController();
            $controller->enviar();
            return; 
        }

        // Se for Logout
        if ($uri === 'logout') {
            session_destroy();
            header("Location: login"); // Redireciona para a view de login
            exit;
        }

        // ---------------------------------------------------------
        // 2. ROTAS DE VISUALIZAÇÃO (Views)
        // ---------------------------------------------------------

        if (array_key_exists($uri, $this->routes)) {
            
            // Proteção da rota admin
            if ($this->isProtected($uri) && !isset($_SESSION['admin_id'])) {
                header("Location: login"); // Redireciona sem a barra no inicio para manter relativo se precisar
                exit;
            }

            $this->loadView($this->routes[$uri]);
            
        } else {
            http_response_code(404);
            echo "<h1>404 - Página não encontrada</h1>";
        }
    }

    private function loadView($viewPath) {
        $fullPath = "../" . $viewPath; 
        if (file_exists($fullPath)) {
            if (pathinfo($fullPath, PATHINFO_EXTENSION) === 'php') {
                include $fullPath;
            } else {
                readfile($fullPath);
            }
        } else {
            echo "Erro: View não encontrada.";
        }
    }

    private function isProtected($uri) {
        return in_array($uri, $this->protectedRoutes);
    }
}
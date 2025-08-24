<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// -------------------- Rotas aceitas --------------------
$routes = [
    ""      => "index.html",
    "login" => "adm/login.html",
    "admin" => "adm/admin.php",
];

// -------------------- Captura URI --------------------
$uri = $_GET["_uri_"] ?? "";
$uri = trim($uri, "/");

// -------------------- Captura parâmetros --------------------
$METHOD = $_SERVER['REQUEST_METHOD'];
$PARAMETERS = [];

switch(strtolower($METHOD)){
    case 'get':
        $PARAMETERS = $_GET ?? [];
        break;
    case 'post':
    case 'put':
    case 'delete':
        $input = file_get_contents("php://input");
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        if (stripos($contentType, 'application/json') !== false) {
            $PARAMETERS = json_decode($input, true) ?? [];
        } else {
            parse_str($input, $PARAMETERS);
        }
        break;
    default:
        $PARAMETERS = [];
        break;
}

foreach ($PARAMETERS as $key => $value) {
    $PARAMETERS[$key] = addslashes($value);
}

// -------------------- Arquivos públicos diretos --------------------
if (str_starts_with($uri, "public/")) {
    $fileExtension = strtolower(pathinfo($uri, PATHINFO_EXTENSION));

    if (!file_exists($uri) || is_dir($uri)) {
        http_response_code(404);
        die("404 - Arquivo não encontrado.");
    }

    ob_clean();
    headerMimeTypes($fileExtension);
    readfile($uri);
    exit;
}

// -------------------- Verifica se rota existe --------------------
if (!array_key_exists($uri, $routes)) {
    http_response_code(404);
    die("404 - Página não encontrada.");
}

$filePath = $routes[$uri];

if (!file_exists($filePath)) {
    http_response_code(404);
    die("404 - Arquivo não encontrado.");
}

// -------------------- Proteção de acesso --------------------
$protectedRoutes = ["admin"];
if (in_array($uri, $protectedRoutes) && (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true)) {
    header("Location: login");
    exit;
}

// -------------------- Executa ou serve arquivo --------------------
$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

if ($ext === "php") {
    include($filePath); // Executa PHP
} else {
    headerMimeTypes($ext);
    readfile($filePath); // Serve arquivo estático
}

// -------------------- Função MIME --------------------
function headerMimeTypes($extension) {
    $mimeTypes = [
        "html" => "text/html",
        "css"  => "text/css",
        "js"   => "text/javascript",
        "png"  => "image/png",
        "jpg"  => "image/jpeg",
        "jpeg" => "image/jpeg",
        "gif"  => "image/gif",
        "svg"  => "image/svg+xml",
        "pdf"  => "application/pdf",
        "json" => "application/json",
        "txt"  => "text/plain",
        "mp3"  => "audio/mpeg",
        "mp4"  => "video/mp4",
        "woff" => "font/woff",
        "woff2"=> "font/woff2",
        "ttf"  => "font/ttf",
        "otf"  => "font/otf",
    ];
    header("Content-Type: " . ($mimeTypes[$extension] ?? "application/octet-stream"));
}

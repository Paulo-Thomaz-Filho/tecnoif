<?php
session_start();

require_once '../app/core/Router.php';

$url = $_GET['url'] ?? '';

$app = new Router();
$app->dispatch($url);
<?php


// Simple router
$page = $_GET['page'] ?? 'home';

$viewPath = dirname(__DIR__) . '/views/';
$controllerPath = dirname(__DIR__) . '/controllers/';

switch ($page) {
    case 'home':
        require $viewPath . 'home.php';
        break;
    case 'fixtures':
        require $viewPath . 'fixtures.php';
        break;
    case 'faq':
        require $viewPath . 'faq.php';
        break;
    case 'login':
        require $viewPath . 'login.php';
        break;
    case 'groups':
        require $viewPath . 'groups.php';
        break;
    case 'signup':
        require $viewPath . 'signup.php';
        break;
    case 'table':
        require $viewPath . 'table.php';
        break;
    case 'thread':
        require $viewPath . 'thread.php';
        break;
    case 'insert_comment':
        require $controllerPath . 'insert_comment.php';
        break;
    default:
        require $viewPath . 'home.php';
        break;
}

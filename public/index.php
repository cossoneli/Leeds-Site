<?php


// Simple router
$page = $_GET['page'] ?? 'home';

$viewPath = dirname(__DIR__) . '/views/';
$controllerPath = dirname(__DIR__) . '/controllers/';
$helperPath = dirname(__DIR__) . '/helpers/';

// Special case for thread pages where we need query parameters

if ($page === 'thread' && isset($_GET['thread'])) {
    $threadPage = $_GET['thread'];
    $_GET['topic'] = $threadPage;
    require $viewPath . 'thread.php';
    exit;
}

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
    case 'insert_reply':
        require $controllerPath . 'insert_reply.php';
        break;
    case 'signup_val':
        require $controllerPath . 'signup_validate.php';
        break;
    case 'login_val':
        require $controllerPath . 'login_validate.php';
        break;
    case 'logout':
        require $controllerPath . 'logout.php';
        break;
    case 'upvote':
        require $helperPath . 'vote_comment.php';
        break;
    default:
        require $viewPath . 'home.php';
        break;
}

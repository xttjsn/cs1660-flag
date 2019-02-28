<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$args = array();

if (isset($_POST['username']))
{
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['pass']) ? trim($_POST['pass']) : '';

    if (User::isValidLoginAttempt($username, $password))
    {
        $_SESSION['username'] = $username;
        header('Location: main.php');
        exit;
    }
    else
    {
        $args['error_msg'] = 'Invalid username or password';
    }
}

$tpl->display('index.tpl', $args);

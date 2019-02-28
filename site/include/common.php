<?php

if (!defined('BASE_DIR'))
    exit;

// Enable display_errors and error reporting.
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

require BASE_DIR . 'include/db.php';
require BASE_DIR . 'include/template.php';
require BASE_DIR . 'include/user.php';

$db = new DB();
$tpl = new TemplateManager();
$cur_user = User::loadFromSession();

header('Content-Security-Policy-Report-Only: default-src *');

<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

session_destroy();
header('Location: index.php');

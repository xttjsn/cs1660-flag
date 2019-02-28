<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$db->query('DELETE FROM users WHERE id = :id', array(':id' => $_GET['id']));

header('Location: ' . $_GET['continue']);

<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

$tpl->display('main.tpl', array('user_info' => $cur_user));

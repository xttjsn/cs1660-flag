<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

$valid_who = array('staff' => 'Staff', 'student' => 'Students', 'all' => 'Everybody');
$who = isset($_GET['who']) ? $_GET['who'] : 'all';
$who = array_key_exists($who, $valid_who) ? $who : 'all';

if ($who === 'all')
{
    $result = $db->query('SELECT id, username, avatar FROM users ORDER BY username ASC');
}
else
{
    $args = array();
    if ($_GET['who'] === 'staff')
    {
        $args[':is_staff'] = '1';
    }
    else if ($_GET['who'] === 'student')
    {
        $args[':is_staff'] = '0';
    }

    $result = $db->query('SELECT id, username, avatar FROM users WHERE is_staff = :is_staff ORDER BY username ASC', $args);
}

$tpl_args = array(
    'title' => $valid_who[$who],
    'users' => $result,
    'is_staff' => (int)$cur_user->is_staff
);

$tpl->display('list-profiles.tpl', $tpl_args); 

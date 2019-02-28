<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

if ($cur_user->isStaff())
{
    if (isset($_POST['submitted_new']))
    {
        $args = array(
            ':name' => isset($_POST['name']) ? trim($_POST['name']) : 'Example Name',
            ':out_date' => isset($_POST['out_date']) ? trim($_POST['out_date']) : '2010-01-01 00:01',
            ':in_date' => isset($_POST['in_date']) ? trim($_POST['in_date']) : '2010-01-01 00:01'
        );
        $db->query('INSERT INTO assignments (name, out_date, in_date) VALUES (:name, :out_date, :in_date)', $args);
    }
    else if (isset($_GET['delete']))
    {
        $id = isset($_GET['delete']) ? intval($_GET['delete']) : 0;
        $db->query('DELETE FROM assignments WHERE id = :id', array(':id' => $id));
    }
}

if ($cur_user->isStaff())
{
    $result = $db->query('SELECT id, name, out_date, in_date, 1 AS show_sol FROM assignments');
}
else
{
    $result = $db->query(
        'SELECT id, name, out_date, in_date, in_date<=datetime("now") as show_sol FROM assignments WHERE out_date <= datetime("now")'
    );
}

$tpl->display(
    'list-asgn.tpl',
    array(
        'assignments' => $result,
        'is_staff' => $cur_user->isStaff()
    )
);

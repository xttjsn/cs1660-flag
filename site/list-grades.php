<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

$id = isset($_POST['user_id']) ? intval($_POST['user_id']) : -1;
$grades_user = User::loadById($id);
$id = $grades_user->id;

if (empty($id))
{
    if ($cur_user->isStaff())
    {
        $id = -1;
        $grades_user = null;
    }
    else
    {
        $id = $cur_user->id;
        $grades_user = $cur_user;
    }
}
$tpl_args = array(
    'is_staff' => (bool)$cur_user->is_staff,
    'selected_user' => $grades_user
);
$tpl_args['students'] = $db->query('SELECT id, username FROM users where is_staff != 1 ORDER BY username ASC');

if ($cur_user->is_staff)
{
    $tpl_args['grades'] = $db->query(
        'SELECT g.grade, g.comments, u.id AS grader_id, u.username AS grader, ' .
        'a.id AS asgn_id, a.name AS asgn_name, h.id AS handin_id, h.ext AS handin_ext ' .
        'FROM assignments AS a ' .
        'LEFT JOIN handins AS h ON (h.asgn_id = a.id) ' .
        'LEFT JOIN grades AS g ON (g.handin_id = h.id) ' .
        'LEFT JOIN users AS u ON (u.id = g.grader_id) ' .
        'WHERE a.out_date <= datetime("now") ' .
        'AND h.student_id IS NULL OR h.student_id = :student_id',
        array(
            ':student_id' => $id
        )
    );
}
else
{
    $tpl_args['grades'] = $db->query(
        'SELECT g.grade, g.comments, u.id AS grader_id, u.username AS grader, ' .
        'a.id AS asgn_id, a.name AS asgn_name, h.id AS handin_id, h.ext AS handin_ext ' .
        'FROM assignments AS a ' .
        'LEFT JOIN handins AS h ON (h.asgn_id = a.id) ' .
        'LEFT JOIN grades AS g ON (g.handin_id = h.id) ' .
        'LEFT JOIN users AS u ON (u.id = g.grader_id) ' .
        'WHERE a.in_date <= datetime("now") ' .
        'AND h.student_id IS NULL OR h.student_id = :student_id',
        array(
            ':student_id' => $id
        )
    );
}

$tpl->display('list-grades.tpl', $tpl_args); 

<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

if (!$cur_user->isStaff())
{
    $tpl->display('error.tpl', array('error_msg' => "You shouldn't be here!"));
    exit;
}

$handin = isset($_GET['handin']) ? intval($_GET['handin']) : 0;

$result = $db->query('SELECT grade, comments FROM grades WHERE handin_id = :handin_id', array(':handin_id' => $handin));

if (count($result) == 0)
{
    $tpl->display('error.tpl', array('error_msg' => "That handin doesn't exist! What's the matter with you?"));
    exit;
}

if (isset($_POST['submitted']))
{
    $grade = isset($_POST['grade']) ? intval($_POST['grade']) : 0;
    $comment = isset($_POST['comment']) ? trim($_POST['comment']) : '';

    $db->query('DELETE FROM grades WHERE handin_id = :handin_id', array(':handin_id' => $handin));
    $db->query(
        'INSERT INTO grades (handin_id, grader_id, grade, comments) VALUES (:handin_id, :grader_id, :grade, :comments)',
        array(
            ':handin_id' => $handin,
            ':grader_id' => $cur_user->id,
            ':grade' => $grade,
            ':comments' => $comment
        )
    );

    header('Location: list-grades.php');
    exit;
}

$tpl->display(
    'edit-grade.tpl',
    array(
        'grade' => $result[0],
        'handin' => $handin
    )
);

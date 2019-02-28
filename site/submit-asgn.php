<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

$id = isset($_GET['asgn']) ? intval($_GET['asgn']) : 0;

$result = $db->query('SELECT name from assignments where id = :id', array(':id' => $id));

if (count($result) == 0)
{
    $tpl->display('error.tpl', array('error_msg' => "That assignment doesn't exist! What are you doing here?"));
    exit;
}

$asgn_name = $result[0]['name'];

if (isset($_FILES['handin']))
{
    if (0 != $_FILES['handin']['error'])
    {
        $tpl->display('error.tpl', array('error_msg' => "An error occurred while uploading your file."));
        exit;
    }

    $split = explode('.', $_FILES['handin']['name'], 2);
    $ext = $split[1];

    if ($cur_user->isStaff())
    {
        $filename = 'handout.pdf';
        if (isset($_GET['soln']))
            $filename = 'solution.pdf';

        move_uploaded_file($_FILES["handin"]["tmp_name"], BASE_DIR . 'handouts/' . $asgn_name . '/' . $filename);

        header("Location: list-asgn.php");
        exit;
    }
    elseif (strpos($_FILES['handin']['name'], ".pdf") === false) {
        $tpl->display('error.tpl', array('error_msg' => "Cannot upload a non pdf file."));
        exit;
    }
    else
    {
        move_uploaded_file($_FILES["handin"]["tmp_name"], $cur_user->getMyHandinUrl($asgn_name, $ext));

        $args = array(
            ':student_id' => $cur_user->id,
            ':asgn_id' => $id,
            ':ext' => $ext
        );
        $db->query('DELETE FROM handins WHERE asgn_id = :asgn_id AND student_id = :student_id', $args);
        $db->query('INSERT INTO handins (asgn_id, student_id, ext) VALUES (:asgn_id, :student_id, :ext)', $args);

        header("Location: list-grades.php");
        exit;
    }
}

$tpl->display(
    'submit-asgn.tpl',
    array(
        'asgn_name' => $asgn_name,
        'upload_sol' => isset($_GET['soln']),
        'is_staff' => $cur_user->isStaff()
    )
);

<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

$id = isset($_GET['id']) ? intval($_GET['id']) : $cur_user->id;
$profile_user = User::loadById($id);
$id = $profile_user->id;

if (empty($id))
{
    $tpl->display('error.tpl', array('error_msg' => 'Invalid user'));
    exit;
}

if (isset($_POST['comment']))
{
    $args = array(
        ':commenter' => $cur_user->id,
        ':commentee' => $id,
        ':comment' => trim($_POST['comment'])
    );
    $db->query('INSERT INTO comments (commenter_id, commentee_id, comment, created_at) VALUES (:commenter, :commentee, :comment, datetime("now"))', $args);
}

$comments = $db->query(
    "select comments.created_at, comments.comment, users.username from comments "
    . "inner join users on comments.commenter_id = users.id "
    . "where comments.commentee_id = :id "
    . "order by comments.created_at desc",
    array(
        ':id' => $id
    )
);

$tpl_args = array(
    'title' => sprintf('%s\'s Profile', $profile_user->username),
    'user' => $profile_user,
    'cur_user' => $cur_user,
    'comments' => $comments
);

$tpl->display('view-profile.tpl', $tpl_args); 

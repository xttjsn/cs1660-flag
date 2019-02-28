<?php
define('BASE_DIR', './');
require BASE_DIR . 'include/common.php';

$cur_user->enforceLogin();

$updated = false;
$pass_updated = false;
$messages = array();

if (isset($_POST['update']))
{
    $oldpass = isset($_POST['oldpass']) ? trim($_POST['oldpass']) : '';
    $new_pass = isset($_POST['newpass']) ? trim($_POST['newpass']) : '';
    $confirm = isset($_POST['confirm']) ? trim($_POST['confirm']) : '';
    if (!empty($oldpass) && !empty($new_pass))
    {
        if (User::hash_password($oldpass) !== $cur_user->password)
        {
            $messages[] = "Incorrect value for 'Current Password'";
        }
        else if ($new_pass !== $confirm)
        {
            $messages[] = "New password does not match confirmation";
        }
        else
        {
            $cur_user->password = User::hash_password($new_pass);
            $pass_updated = true;
        }
    }

    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    if (!empty($name))
        $cur_user->username = $name;

    $avatar_url = isset($_POST['avatar_url']) ? trim($_POST['avatar_url']) : '';
    $cur_user->avatar = $avatar_url;

    $about_me = isset($_POST['about_me']) ? trim($_POST['about_me']) : '';
    $cur_user->about_me = $about_me;

    $cur_user->save();
    $updated = true;
}

$tpl->display(
    'edit-profile.tpl',
    array(
        'user' => $cur_user,
        'updated' => $updated,
        'password_updated' => $pass_updated,
        'messages' => $messages,
    )
);

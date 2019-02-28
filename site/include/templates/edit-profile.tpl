<?php $this->display('header.tpl', $args); ?>
<h1>Edit Profile</h1>

<?php foreach ($messages as $cur_msg): ?>
<p class="error-msg"><?php echo $cur_msg; ?></p>
<?php endforeach; ?>
<?php if ($password_updated): ?>
<p class="success-msg">The password for this account has been updated.</p>
<?php endif; ?>
<?php if ($updated): ?>
<h3 class="centered, success-msg" style="float: center; text-align: center;">Profile Information Updated!</h3>
<?php endif; ?>

<form action="edit-profile.php" method="post">

  <table style="width: 1000px; margin-left: auto; margin-right: auto;">

    <tr><th style="width: 50%" /><th style="width: 50%" /></tr>
    <tr>
      <td>Name</td>
      <td><input style="width: 90%" type="text" name="name" value="<?php echo $user->username ?>" /></td>
    </tr>
    <tr>
      <td>Current Password</td>
      <td><input style="width: 90%" name="oldpass" type="password" /></td>
    </tr>
    <tr>
      <td>New Password</td>
      <td><input style="width: 90%" name="newpass" type="password" /></td>
    </tr>
    <tr>
      <td>Confirm New Password</td>
      <td><input style="width: 90%" name="confirm" type="password" /></td>
    </tr>
    <tr>
      <td>Avatar URL <br> <img width="50px" height="auto" src="<?php echo $user->avatar ?>" /></td>
      <td><input style="width: 90%" type="text" name="avatar_url" value="<?php echo $user->avatar ?>" /></td>
    </tr>
    <tr>
      <td>About You</td>
      <td><textarea style="width: 90%" rows="6" name="about_me"><?php echo $user->about_me ?></textarea></td>
								 </tr>
    <tr>
      <td></td>
      <td><input type="Submit" style="width: 90%" name="update" value="Update Profile" /></td>
    </tr>
  </table>
</form>
<?php $this->display('footer.tpl', $args); ?> 

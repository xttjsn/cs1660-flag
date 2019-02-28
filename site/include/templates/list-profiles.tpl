<?php $this->display('header.tpl', $args); ?>
<h1>Profile List: <?php echo $title; ?></h1>

<script type="text/javascript">
  var is_staff = <?php echo $is_staff; ?>;
  function remove_user(id)
  {
  if (is_staff)
  {
  if (confirm('This action cannot be undone. Really delete this account?'))
  window.location = 'delete-user.php?id=' + id + '&continue=' + document.location.href;
  }
  }
</script>

<table id="profile-list" border="1">
  <thead>
    <th></th>
    <th>Login</th>
    <?php if (!$is_staff): ?>
    <!--
	<?php endif; ?>
	 <th></th>
	 <?php if (!$is_staff): ?>
	  -->
	  <?php endif; ?>
			 </thead>
  <tbody>
    <?php foreach ($users as $cur_user): ?>
    <tr>
      <td class="avatar" style="width: 70px"><img width="50" height="auto" src="<?php echo $cur_user['avatar']; ?>" /></td>
      <td class="username"><a href="profile.php?id=<?php echo $cur_user['id']; ?>"><?php echo $cur_user['username']; ?></a></td>
      <?php if (!$is_staff): ?>
      <!--
	  <?php endif; ?>
	   <td class="delete" style="width: 50px"><a href="#" onclick="remove_user(<?php echo $cur_user['id']; ?>);"><img src="http://icons.iconarchive.com/icons/hopstarter/rounded-square/256/Button-Delete-icon.png" style="width: 50px; height: 50px; text-align: center; float: center;"/></a></td>
	   <?php if (!$is_staff): ?>
	    -->
	    <?php endif; ?>
			   </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php $this->display('footer.tpl', $args); ?> 

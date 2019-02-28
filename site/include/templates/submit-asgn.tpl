<?php $this->display('header.tpl', $args); ?>
<a href="list-grades.php">Back to grades</a><br><br>
<table style="text-align:center; margin-left:auto; margin-right:auto; border-style:solid">
  <tr><td>Submit <?php echo $is_staff ? "document":"handin"; ?> for
      <?php echo $asgn_name; ?></td></tr>
  <tr><td>
      <form method="post" enctype="multipart/form-data">
	<input name="handin" type="file" />
	<input type="submit" value="Submit" />
      </form>
</tr></td>
</table>

<?php $this->display('footer.tpl', $args); ?> 

<?php $this->display('header.tpl', $args); ?>
<h1>Edit Grade</h1>

<form method="post">
  <table style="text-align:center; margin-left:auto; margin-right:auto; border-style:solid">
    <tr>
      <td>
	Grade
	<input name="grade" type="text" maxlength="3" size="4" value="<?php echo $grade['grade']; ?>" />
      </td>
      <td>
	<input type="submit" name="submitted" value="Submit" />
      </td>
    </tr>
    <tr>
      <td colspan="2">
	<textarea name="comment" rows="4" cols="50"><?php echo $grade['comments']; ?></textarea>
      </td>
    </tr>
  </table>
  <input name="handin" type="hidden" value="<?php echo $handin; ?>" />
</form>
<?php $this->display('footer.tpl', $args); ?> 

<?php $this->display('header.tpl', $args); ?>
<h1>Assignment List</h1>

<table cellspacing="20" style="text-align:center; margin-left:auto; margin-right:auto; border-style:solid" class="slightRed" id="assignmentList">
  <thead>
    <tr>
      <th>Name</th>
      <th>Handout</th>
      <?php if ($is_staff): ?>
      <th>Update Handout</th>
      <?php endif; ?>
      <th>Solutions</th>
      <?php if ($is_staff): ?>
      <th>Update Solutions</th>
      <th>Delete</th>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($assignments as $cur_asgn): ?>
    <tr>
      <td><?php echo $cur_asgn['name']; ?></td>
      <td><a href="handouts/<?php echo $cur_asgn['name']; ?>/handout.pdf">View</a></td>
      <?php if ($is_staff): ?>
      <td><a href="submit-asgn.php?asgn=<?php echo $cur_asgn['id']; ?>">Upload</a></td>
      <?php endif; ?>
      <td><a href="handouts/<?php echo $cur_asgn['name']; ?>/solution.pdf">View</a></td>
      <?php if ($is_staff): ?>
      <td><a href="submit-asgn.php?asgn=<?php echo $cur_asgn['id']; ?>&amp;soln=1">Upload</a></td>
      <td><a href="list-asgn.php?delete=<?php echo $cur_asgn['id']; ?>"><img src="http://icons.iconarchive.com/icons/hopstarter/rounded-square/256/Button-Delete-icon.png" style="width: 50px; height: 50px;"/></a></td>
      <?php endif; ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php if ($is_staff): ?>
<br><br>
<form method="post">
  <table style="text-align:center; margin-left:auto; margin-right:auto; border-style:solid" class="slightRed">
    <tr>
      <td>Name:</td>
      <td><input name="name" type="text" maxlength="64" /></td>
    </tr>
    <tr>
      <td>Out (YYYY-MM-DD HH:MM:SS):</td>
      <td><input name="out_date" type="text" maxlength="19" /></td>
    </tr>
    <tr>
      <td>In (YYYY-MM-DD HH:MM:SS):</td>
      <td><input name="in_date" type="text" maxlength="19" /></td>
    </tr>
    <tr>
      <td colspan="2"><input type="submit" value="Create Assignment" /></td>
    </tr>
  </table>
  <input name="submitted_new" type="hidden" value="1" />
</form>
<?php endif; ?>
<?php $this->display('footer.tpl', $args); ?> 

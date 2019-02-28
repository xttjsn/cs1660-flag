<?php $this->display('header.tpl', $args); ?>

<div id="grade_page">

  <h1>Grade List</h1>

  <form id="grade_list_form" method="post">
    <div id="grade-select" <?php if (!$is_staff): ?> style="display: none;"<?php endif; ?>>
      <select name="user_id">
	<?php foreach ($students as $cur_student): ?>
	<option value="<?php echo $cur_student['id'] ?>"<?php if (!empty($selected_user) && $selected_user->id == $cur_student['id']): ?> selected="selected"<?php endif; ?>><?php echo $cur_student['username']; ?></option>
<?php endforeach; ?>
</select>
<input type="submit" value="View Grades" />
</div>

<?php if ($selected_user !== null): ?>
<table cellspacing="0" cellpadding="10" style="text-align:center; margin-left:auto; margin-right:auto; width:400px; border-style:solid" class="slightRed" id="gradesTable">
  <thead>
    <tr>
      <th>Assignment</th>
      <th>Graded By</th>
      <th>Grade</th>
      <th><?php echo ($is_staff) ? 'Edit' : 'Submit'; ?></th>
      <th>View Handin</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($grades as $cur_grade): ?>
    <tr>
      <td style="border-top-style:solid"><?php echo $cur_grade['asgn_name']; ?></td>
      <td style="border-top-style:solid">
	<?php if ($cur_grade['grader_id'] !== null): ?>
	<a href="profile.php?id=<?php echo $cur_grade['grader_id']; ?>"><?php echo $cur_grade['grader']; ?></a>
	<?php else: ?>
	&nbsp;
	<?php endif; ?>
      </td>
      <td style="border-top-style:solid">
	<?php if ($cur_grade['grade'] !== null): ?>
	<?php echo $cur_grade['grade']; ?>
	<?php else: ?>
	&nbsp;
	<?php endif; ?>
      </td>
      <td style="border-top-style:solid">
	<?php if ($is_staff): ?>
	<a href="edit-grade.php?handin=<?php echo $cur_grade['handin_id']; ?>"><?php echo ($cur_grade['grade'] !== null) ? 'Regrade' : 'Grade'; ?></a>
	<?php else: ?>
	<a href="submit-asgn.php?asgn=<?php echo $cur_grade['asgn_id'] ?>"><?php echo ($cur_grade['handin_ext'] !== null) ? 'Resubmit' : 'Submit'; ?></a>
	<?php endif; ?>
      </td>
      <td style="border-top-style:solid">
	<?php if ($cur_grade['handin_ext'] !== null): ?>
	<a target="_blank" href="<?php echo $selected_user->getMyHandinUrl($cur_grade['asgn_name'], $cur_grade['handin_ext']); ?>">View</a>
	<?php else: ?>
	&nbsp;
	<?php endif; ?>
      </td>
    </tr>
    <?php if ($cur_grade['comments'] !== null): ?>
    <tr>
      <td colspan="5" style="padding:10px 50px 10px 50px; border-top-style: dotted">
	<?php echo $cur_grade['comments']; ?>
      </td>
    </tr>
    <?php endif; ?>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
</div>

<?php $this->display('footer.tpl', $args); ?> 

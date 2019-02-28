<?php $this->display('header.tpl', $args); ?>
<div id="mainPage">

  <h2 id="username"><?php echo $user_info->username; ?></h2>

  <ul>
    <li>
      <a href="list-grades.php">Grades</a>
      <p class="descriptionText">View All <?php echo $user_info->username; ?>'s Grades</p>
    </li>
    <li>
      <a href="list-asgn.php">Assignments</a>
      <p class="descriptionText">View and change handins</p>
    </li>
    <li>
      <a href="profile.php">My Profile</a>
      <p class="descriptionText">Change account details</p>
    </li>
    <li>
      <a href="list-profiles.php?who=staff">Staff</a>
      <p class="descriptionText">View staff members and associated details</p>
    </li>
    <li>
      <a href="list-profiles.php?who=student">Students</a>
      <p class="descriptionText">View all students</p>
    </li>
    <li><a href="logout.php">Logout</a>
      <p class="descriptionText">Leave the secure portal</p></li>
  </ul>
</div>

<?php $this->display('footer.tpl', $args); ?>

<?php $this->display('header.tpl', $args); ?>
<h1><?php echo $title; ?></h1>

<table id="profile-table">
  <tr>
    <td style="width: 70px">
      <img width="200px" height="auto" src="<?php echo $user->avatar ?>" />
    </td>
    <td>
      <span style="font-size: 200%"><?php echo $user->username ?></span><br>
				     <?php echo $user->isStaff() ? 'Staff Member' : 'Student'; ?>
				      </td>
    <td><h1>&ldquo;</h1></td>
    <td>
      <p style="font-size: 120%"><?php echo $user->about_me ?></p>
				  </td>
    <td><h1>&rdquo;</h1></td>
    <?php if ($cur_user->id == $user->id): ?>
     <td><a href="edit-profile.php">Edit</a></td>
     <?php endif; ?>
      </tr>
</table>


<div style="width: 500px; margin-left: auto; margin-right: auto; float: center;">
  <form action="profile.php?id=<?php echo $user->id; ?>" method="post" style="margin-top:20px">
    <textarea rows="4" name="comment" style="width: 100%"></textarea>
    <input type="submit" value="Leave a Comment" style="margin-left: auto; margin-right: auto;" />
  </form>
  <?php foreach ($comments as $comment): ?>
   <hr />
   <table>
     <tr>
       <td>
	 <span style="font-size: 150%"><?php echo $comment['username'] ?></span>
					</td>
       <td style="text-align: right; width: 100%;">
	 <span style="font-size: 100%"><?php echo $comment['created_at'] ?></span>
					</td>
     </tr>
   </table>
   <table>
     <tr>
       <td><h1>&ldquo;</h1></td>
       <td style="width: 100%; vertical-align: top">
	 <p style="margin-top: 10px"><?php echo $comment['comment'] ?></p>
				      </td>
       <td><h1>&rdquo;</h1></td>
     </tr>
   </table>
   <?php endforeach; ?>
    </div>

<?php $this->display('footer.tpl', $args); ?> 

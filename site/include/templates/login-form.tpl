<div id="login-form">
  <img src="https://sso.brown.edu/idp/images/header-authentication-required.png" class="centered"/>
  <?php if (isset($error_msg)): ?>
  <p class="error-msg"><?php echo $error_msg; ?></p>
  <?php endif; ?>
  <form action="index.php" method="post" id="loginFormForm">
    <p><input type="text" name="username" id="username_input" placeholder="Username"/></p>
    <p><input type="password" name="pass" id="password_input" placeholder="Password"/></p>
    <p><input type="submit" value="Secure Login"/> <a href="javascript:alert('Please try to remember!');">Forgot your password?</a></p>
  </form>
  <p class="flagText" id="flagVersion">F.L.A.G Version 1.0</p>
</div> 

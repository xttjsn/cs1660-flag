<?php
// don't leak any information to the user
exec('/bin/reset-flag > /dev/null 2>/dev/null');
header('Location: /setup');
?>

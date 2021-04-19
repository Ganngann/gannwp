<?php
$userId = get_current_user_id();

$datas = new stdClass();
$datas->ID = $userId;


$user = new Gannwp_User($datas);

if (isset($_POST["user"])) {
   $user->action();
}


?>
<div class="wrap">
   <h2>AgoraWP user panel</h2>
   <?php
   if (!is_user_logged_in()) {
      wp_login_form();
   } else {
      $user->populate();
      $user->form();
      ?>
      <form class="" action="" method="post">
         <input type="hidden" name="user" value="logout">
         <input type="submit" name="user" value="logout">
      </form>
      <?php
   }
   ?>
</div>

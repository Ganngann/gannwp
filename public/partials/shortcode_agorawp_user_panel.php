<?php
$userId = get_current_user_id();

$object = new stdClass();
$object->ID = $userId;


$user = new Gannwp_User($object);

if (isset($_POST["user"])) {
   $user->db();
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
   }
   ?>

</div>

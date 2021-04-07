<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;

$users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users", OBJECT);
$gannwp_users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users", OBJECT);

$gannwp_users_fields_meta = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}gannwp_users_meta", OBJECT);

// var_dump($gannwp_users);

$path = 'admin.php?page=gannwp%2Fadmin%2Fpartials%2Fgann_userForm.php';
$url = admin_url($path);
// $link = "<a href='{$url}'>Edit</a>";
// echo $link;



foreach ($gannwp_users as $key => $gannwp_user) {
   // echo $gannwp_user->userID;

   foreach ($users as $key => $user) {
      if ($user->ID == $gannwp_user->userID) {
         foreach ($gannwp_user as $key => $value) {
            // echo "</br></br>";
            $user->$key = $value;
            // var_dump($user->$key);
         }
         // var_dump($user);
      }
   }
}








//
// $indexed = array();
$results = array();
//
// foreach($gannwp_users as $value) {
//    $indexed[$value->userID] = $value;
// }
//
// foreach($users as $obj) {
//    $tempValue = '';
//    if (isset($indexed[$obj->ID])) {
//       // echo "string";
//       $tempValue = $indexed[$obj->ID];
//
//    }
//
//    // var_dump($value);
//    // echo "</br>coucou</br>";
//
//    if ($tempValue != '') {
//       // echo "</br>coucou ca existe</br>";
//
//       foreach($tempValue as $name => $val) {
//          $obj->$name = $val;
//       }
//       array_push($results, $obj);
//
//    }
//
// }



// $result = array_merge( $gannwp_users, $users );

// foreach ($users as $key => $value) {
// var_dump($value);
// echo "</br></br>";
// }

?>
<div class="wrap">
   <h1>GannWP Agora submenu</h1>
   <form class="" action=<?php echo $url ?> method="post">
      <table>
         <thead>
            <?php foreach ($gannwp_users_fields_meta as $key => $value) : ?>
               <th>
                  <?php echo $value->name ?>
               </th>
            <?php endforeach; ?>
         </thead>
         <?php foreach ($users as $key => $user) : ?>
            <tr>
               <?php foreach ($gannwp_users_fields_meta as $key => $field) : ?>
                  <?php $columnName = $field->columnName; ?>
                  <td>
                     <p>
                        <?php echo isset($user->$columnName) ? $user->$columnName : ''; ?>
                     </p>
                  </td>
               <?php endforeach; ?>
            </tr>
         <?php endforeach; ?>
      </table>
      <input type="submit" name="" value="test">

      <?php
      // echo admin_url();
      ?>

      <?php

      ?>

   </form>
</div>

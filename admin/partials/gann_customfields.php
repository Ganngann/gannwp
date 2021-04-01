<?php

// 1st Method - Declaring $wpdb as global and using it to execute an SQL query statement that returns a PHP object
global $wpdb;
$params = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}gannwp_params WHERE id = 1", OBJECT );
$users = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users", OBJECT);

$gannwp_users = $wpdb->get_results("SHOW COLUMNS FROM {$wpdb->prefix}gannwp_users;", OBJECT);

// var_dump($gannwp_users);

var_dump($_POST);

?>

<?php
global $wpdb;
$table_name = $wpdb->prefix . "gannwp_users";


if (isset($_POST["delete"])) {
   $data = str_replace( '-', '_',sanitize_html_class($_POST["columnName"]));
   $sql = "ALTER TABLE $table_name
   DROP COLUMN $data ;";
   echo $sql;
   $wpdb->query($sql);
   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}

if (isset($_POST["collname"])) {
   $data = str_replace( '-', '_',sanitize_html_class($_POST["collname"]));
   $sql = "ALTER TABLE $table_name
   ADD $data int;";
   echo $sql;
   $wpdb->query($sql);
   require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}

if (isset($_POST["collname"]) or isset($_POST["delete"])) {
   echo "<script type='text/javascript'>window.location=document.location.href; </script>";
};
?>


<div class="wrap">

   <h2>champs extras</h2>
   <table>
      <thead>
         <th>champ</th>
         <th>nom</th>
         <th></th>
      </thead>

      <?php foreach ($gannwp_users as $key => $value) : ?>
         <form class="" action="" method="post">
            <input type="hidden" name="delete" value="Y" />
            <tr>
               <td>
                  <label for="columnName"><?php echo $value->Field ?></label>
               </td>
               <td>
                  <input type="text" name="columnName" value="<?php echo $value->Field ?>">
               </td>
               <td>
                  <input type="submit" name="" value="remove">
               </td>
            </tr>
         </form>
      <?php endforeach; ?>
   </table>
   <input type="submit" name="" value="Update">
   <form class="" action="" method="post">
      <label for="collname">ajouter une colone</label>
      <input type="text" name="collname" value="test">
      <input type="submit" name="" value="add">
   </form>
</div>
